<?php

namespace Orange\Wip\Controllers;

use Validator;
use Illuminate\Http\Request;

use Orange\Wip\Interfaces\MyEventInterface;

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

	public function validate()
	{
		echo '<pre>start validate'.PHP_EOL;

		$rules = ['name' => 'matches'];

		$input = ['name' => 'test'];

		$validator = Validator::make($input, $rules);

		//dd($validator);

		echo 'end';
	}

	public function filter()
	{
		echo '<pre>start filter'.PHP_EOL;
		
		$rules = ['name' => 'replace'];

		$input = ['name' => 'abc'];

		$validator = Validator::make($input, $rules);

		//dd($validator);

		echo 'end';
	}


} /* end class */
