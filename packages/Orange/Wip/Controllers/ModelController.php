<?php

namespace Orange\Wip\Controllers;

use Orange\Wip\Models\Snippets;

class ModelController
{

	public function input1()
	{

		$record = Snippets::all()->first();

		$success = $record->validate();

		var_dump($success);

		return $record->errors();
	}

	public function input2()
	{
		$record = new Snippets;

		$record->file = 'filename';
		$record->key = 'foobar';

		$success = $record->save();

		echo '<pre>';

		//var_dump($success);

		echo $record->errors();
	}

	public function input3()
	{
		$data = [
			'file'=>'filename',
		];

		$record = Snippets::create($data);

		echo $record->errors();
	}


} /* end class */
