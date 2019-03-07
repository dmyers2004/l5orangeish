<?php 

namespace Orange\Core\Input;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Input
{
	/*
	 *
	 */
	protected $request;

	/*
	 *
	 */
	protected $all;

	/*
	 *
	 */
	protected $validator;
	
	/*
	 *
	 */
	protected $passed = false;
	
	/*
	 *
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
		
		#$this->all = $this->request->all();
		$this->all = [
			'name'=>'Johnny Appleseed',
			'age'=>23,
			'color'=>'orange',
			'birthday'=>'11/18/1970',
		];
	}
	
	public function request() : array
	{
		return $this->all;
	}
	
	public function valid(array $rules) : bool
	{
		$this->validator = Validator::make($this->all, $rules);

		/* actually preform validation */
		$this->passed = $this->validator->passes();
		
		return $this->passed;
	}
	
	public function get_errors() : array
	{
		/* Laravel MessageBag */
		return $this->validator->errors();
	}
	
	public function has_errors() : bool
	{
		return $this->passed;
	}
	
	public function filter(array $rules,array $only = null) : Input
	{
		$clean = (is_array($only)) ? array_intersect_key($this->all,array_combine($only,$only)) : $this->all;
		
		$validator = Validator::make($clean, $rules);

		/* actually preform validation */
		$validator->passes();
		
		$this->all = $validator->getData();
		
		return $this;
	}
	
	public function filteredWith(string $class_name,string $set = null) : array
	{
		if (!class_exists($class_name)) {
			throw new Exception(sprintf('Class name "%s" not located.',$class_name));
		}

		$object = new $class_name;
		
		if (!method_exists($object,'getRuleSet')) {
			throw new Exception(sprintf('Could not locate the rule set "%s" on your class "%s".',$set,$class_name));
		}

		
		
		return $this->filter($rules,$only)->request();
	}
	
	public function filtered(array $rules,array $only = null) : array
	{
		return $this->filter($rules,$only)->request();
	}

} /* end class */
