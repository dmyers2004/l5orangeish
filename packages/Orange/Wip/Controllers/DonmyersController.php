<?php

namespace Orange\Wip\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Orange\Wip\Interfaces\MyEventInterface;
use Orange\Core\Auth\Auth;

class DonmyersController
{

	public function index(MyEventInterface $event,\Joe $joe)
	{

		# dd(app());

		return $joe->hello('Jenny').$event->hello('Johnny');
	}

	public function test()
	{
		return view('orange-wip::welcome');
	}

	public function auth(Auth $auth)
	{
		dump($auth);
	}

	public function validate()
	{
		echo '<pre>start validate'.PHP_EOL;

		$input = [
			'name' => 'abc',
			'age'=>''
		];
		
		$rules = [
			'name' => ['required','matches:1'],
			'age' => ['required']
		];

		$validator = Validator::make($input, $rules);
		
		/* actually preform validation */
		$success = $validator->passes();

		$errors = $validator->errors();

		dd($validator);

		echo 'end';
	}

	public function filter()
	{
		echo '<pre>start filter'.PHP_EOL;
		
		$input = ['name' => 'abc','age'=>''];
		$rules = ['name' => 'required|replace:a,x','age' => 'required'];

		$validator = Validator::make($input, $rules);

		/* actually preform validation */
		$success = $validator->passes();

		dd($validator);

		echo 'end';
	}


} /* end class */
