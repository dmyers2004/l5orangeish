<?php

namespace Orange\Theme\Controllers;

use Orange\Core\BaseController\BaseController;
use \Orange\Core\Filter\Filter;
use \Orange\Core\Input\Input;

class DonmyersController extends BaseController
{
	/**
	 * $filter
	 *
	 * @var undefined
	 */
	protected $filter;

	/**
	 * $input
	 *
	 * @var undefined
	 */
	protected $input;

	/**
	 * __construct
	 *
	 * @param Filter $filter
	 * @param Input $input
	 * @return void
	 */
	public function __construct(Filter $filter, Input $input)
	{
		parent::__construct();

		$this->filter = $filter;
		$this->input = $input;
	}

	/**
	 * test
	 *
	 * @return void
	 *
	 * Route::get('/donmyers/test', 'Orange\Theme\Controllers\DonmyersController@test');
	 */
	public function test()
	{
		$value = 'abc123';

		$new_value = $this->filter->clean('replace:b,x',$value);

		echo '<pre>';
		var_dump($value,$new_value);
	}

	/**
	 * passbyuri
	 *
	 * @param string $name
	 * @return void
	 *
	 * Route::get('/donmyers/passbyuri/{name}', 'Orange\Theme\Controllers\DonmyersController@passbyuri');
	 */
	public function passbyuri(string $name)
	{
		$success = $this->input->filter->clean('replace:t,X',$name);

		var_dump($success);
	}

} /* end class */
