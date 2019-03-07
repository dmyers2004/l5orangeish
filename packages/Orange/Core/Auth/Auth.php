<?php

namespace Orange\Core\Auth;

use Illuminate\Http\Request;
use Orange\Core\Event\Event;
use Orange\Core\User\User;
use Illuminate\Support\MessageBag;

class Auth
{
	/**
	 * session key
	 *
	 * @var string
	 */
	protected $sessionKey = 'user::data';

	/**
	 * Auth configuration array
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * CodeIgniter Session Object
	 *
	 * @var array
	 */
	protected $session;

	/**
	 * CodeIgniter Event Object
	 *
	 * @var array
	 */
	protected $event;

	/**
	 * Orange Errors Object
	 *
	 * @var array
	 */
	protected $errors;

	/**
	 * CodeIgniter Controller (active)
	 *
	 * @var array
	 */
	protected $controller;

	/**
	 * Orange User Model
	 *
	 * @var array
	 */
	protected $user_model;

	/**
	 *
	 * Constructor
	 *
	 * @access public
	 *
	 * @param array $config []
	 *
	 */
	public function __construct(Request $request, Event $event, User $user)
	{
		$this->config = config('auth');

		/* get session from request */

		$this->request = $request;
		$this->event = $event;
		$this->user = $user;

		/* https://stillat.com/blog/2018/04/21/laravel-5-message-bags-adding-messages-to-the-message-bag-with-add */
		$this->errors = new MessageBag;

		/* define some global Constants */
		define('ADMIN_ROLE_ID', $this->config['admin role id']);
		define('NOBODY_USER_ID', $this->config['nobody user id']);
		define('EVERYONE_ROLE_ID', $this->config['everyone role id']);

		/* We all start off as nobody in life... */
		$this->switchToNobody();

		/* Are we in GUI mode? */
		if (strpos(php_sapi_name(), 'cli') === false) {
			/* we are in GUI mode is there a user id in the session? */
			$user_primary_key = $this->request->session()->get($this->sessionKey);

			if (!empty($user_primary_key)) {
				/**
				 * refresh the user based on the user identifier
				 * but don't save to the session
				 * because we already loaded it from the session
				 */
				$this->refreshUserdata($user_primary_key, false);
			}
		}

	}

	/**
	 *
	 * Switch the current user to nobody
	 *
	 * @access public
	 *
	 * @return Auth
	 *
	 */
	public function switchToNobody() : Auth
	{
		$this->refreshUserdata($this->config['nobody user id'], false);

		return $this;
	}

	/**
	 *
	 * Perform a login using email and password
	 *
	 * @access public
	 *
	 * @param string $user_primary_key
	 * @param string $password
	 *
	 * @return Bool
	 *
	 */
	public function login(string $user_primary_key, string $password) : Bool
	{
		$success = $this->_login($user_primary_key, $password);

		$this->event->trigger('auth.login', $user_primary_key, $success);

		return $success; /* boolean */
	}

	/**
	 *
	 * Perform a logout
	 *
	 * @access public
	 *
	 * @return Bool
	 *
	 */
	public function logout() : Bool
	{
		$success = true;

		$this->event->trigger('auth.logout', $success);

		if ($success) {
			$this->switchToNobody();
			$this->session->set_userdata([$this->sessionKey => '']);
		}

		return $success;
	}

	/**
	 *
	 * Refresh the current user profile based on a user id
	 * you can optionally save it to the current session
	 *
	 * @access public
	 *
	 * @param String $user_primary_key
	 * @param Bool $save_session true
	 *
	 * @return String
	 *
	 */
	public function refreshUserdata(String $user_primary_key, Bool $save_session) : Void
	{
		if (empty($user_primary_key)) {
			throw new \Exception('Auth session refresh user identifier empty.');
		}

		$profile = $this->user_model->get_by_primary_ignore_read_role($user_primary_key);

		if ((int)$profile->is_active === 1 && $profile instanceof O_user_entity) {
			/* no real need to have this floating around */
			unset($profile->password);

			/* Attach profile object as user "service" */
			ci('user',$profile);

			/* should we save this profile id in the session? */
			if ($save_session) {
				$this->session->set_userdata([$this->sessionKey => $profile->id]);
			}
		}
	}

	/**
	 *
	 * Do actual login with multiple levels of validation
	 *
	 * @access protected
	 *
	 * @param String $login
	 * @param String $password
	 *
	 * @return Bool
	 *
	 */
	protected function _login(String $login, String $password) : Bool
	{
		/* Does login and password contain anything empty values are NOT permitted for any reason */
		if ((strlen(trim($login)) == 0) or (strlen(trim($password)) == 0)) {
			$this->errors->add($this->config['empty fields error']);
			return false;
		}

		/* Run trigger */
		$this->event->trigger('user.login.init', $login);

		/* Try to locate a user by there email */
		if (!$user = $this->user_model->get_user_by_email($login)) {
			$this->errors->add($this->config['general failure error']);
			return false;
		}

		/* Did we get a instance of orange user entity? */
		if (!($user instanceof O_user_entity)) {
			$this->errors->add($this->config['general failure error']);
			return false;
		}

		/* Is the user id 0? There is not user 0 */
		if ((int) $user->id === 0) {
			$this->errors->add($this->config['general failure error']);
			return false;
		}

		/* Verify the Password entered with what's in the user object */
		if (password_verify($password, $user->password) !== true) {
			$this->event->trigger('user.login.fail', $login);
			$this->errors->add($this->config['general failure error']);
			return false;
		}

		/* Is this user activated? */
		if ((int) $user->is_active == 0) {
			$this->event->trigger('user.login.in active', $login);
			$this->errors->add($this->config['general failure error']);
			return false;
		}

		/* ok they are good refresh the user and save to the session */
		$this->refreshUserdata($user->id, true);

		return true;
	}
} /* end class */
