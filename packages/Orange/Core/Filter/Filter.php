<?php

namespace Orange\Core\Filter;

use Illuminate\Support\Facades\Validator;

class filter {
	protected $key = 'field name';

	/**
	 * filter a value(s) (array|string) value against rule(s) (array|mixed)
	 * returns the filtered value(s) (array|string)
	 *
	 * @param mixed $rule
	 * @param mixed $value
	 * @return mixed
	 */
	public function clean($rule,$value = null) /* mixed */
	{
		if (is_array($rule)) {
			if (!is_array($value)) {
				throw new \Exception('No values to filter has been provided.');
			}

			$value = multiple($rule,$value);
		} elseif (is_string($rule)) {
			if (is_null($value)) {
				throw new \Exception('No value to filter has been provided.');
			}

			$value = $this->single($rule,$value);
		}

		return $value;
	}

	public function multiple(array $rules,array $values)
	{
		foreach ($rules as $name=>$rule) {
			$values[$name] = $this->single($rule,$values[$name]);
		}

		return $values;
	}

	public function single($rule,$value)
	{
		$validator = Validator::make([$this->key=>$value],[$this->key=>$rule]);

		/* Preform validation */
		if (!$validator->passes()) {
			throw new \Exception($rule.' is being called as a filter and it does not return true.');
		}

		return $validator->getData()[$this->key];
	}

} /* end class */
