<?php

namespace Orange\Wip\Controllers;

use Orange\Core\Libraries\Input; /* our input class */

class InputController
{

	public function input1(Input $input)
	{
		$rules = [
			'name'=>['replace:n,x'],
			'age'=>['replace:2,3'],
			'color'=>['replace:r,x'],
			'birthday'=>['replace:n,x'],
		];

		$filtered = $input->filtered($rules);

		return $filtered;
	}

	public function input2(Input $input)
	{
		$rules = [
			'name'=>['replace:n,x'],
			'age'=>['replace:2,3'],
			'color'=>['replace:r,x'],
			'birthday'=>['replace:n,x'],
		];

		$filtered = $input->filtered($rules,['name','age']);

		return $filtered;
	}

	public function input3(Input $input)
	{
		$rules = [
			'name'=>['replace:n,x'],
			'age'=>['replace:2,3'],
			'color'=>['replace:r,x'],
			'birthday'=>['replace:n,x'],
		];

		$filtered = $input->filter($rules,['name','age'])->request();

		return $filtered;
	}

	public function input4(Input $input)
	{
		$rules = [
			'name'=>['replace:n,x'],
			'age'=>['replace:2,3'],
			'color'=>['replace:r,x'],
			'birthday'=>['replace:n,x'],
		];

		$filtered = $input->filteredWith(\Orange\Core\Setting\Setting::class,'create');

		return $filtered;
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

		dd($validator->errors());

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

		dd($validator->errors());

		echo 'end';
	}


} /* end class */
