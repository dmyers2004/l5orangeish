<?php

namespace Orange\Wip\Libraries;

use Orange\Wip\Interfaces\MyEventInterface;

class FooBar implements MyEventInterface
{

	public function hello(string $name) : string
	{
		return '<p>Hello there, '.$name.'<p>';
	}

}
