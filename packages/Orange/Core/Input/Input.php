<?php

namespace Orange\Core\Input;

use Illuminate\Http\Request;

use Orange\Core\Filter\Filter;
use Orange\Core\Validate\Validate;

class Input
{
	/*
	 * instance of Illuminate\Http\Request
	 */
	protected $request;

	/*
	 * Array of request form data
	 */
	protected $requestValues = [];

	/*
	 * instance of Illuminate\Validator\Validator
	 */
	public $validate;

	/**
	 * $filter
	 *
	 * @var undefined
	 */
	public $filter;

	/**
	 * __construct
	 *
	 * @param Request $request
	 * @return void
	 */
	public function __construct(Request $request,Filter $filter, Validate $validate)
	{
		$this->request = $request;
		$this->filter = $filter;
		$this->validate = $validate;

		$this->requestValues = $this->request->all();
	}

	/**
	 * All of OUR request data
	 * This maybe different then actual HTTP Request data
	 *
	 * @return void
	 */
	public function request(): array
	{
		return $this->requestValues;
	}

	/**
	 * remap request input from one key value pair to a different key value
	 *
	 * @param array $map
	 * @return void
	 */
	public function remap(array $map) : self
	{
		foreach ($map as $old_key => $new_key) {
			$this->requestValues[$new_key] = $this->requestValues[$old_key];

			unset($this->requestValues[$old_key]);
		}

		return $this;
	}

	/**
	 * remove every other request entry except these
	 *
	 * @param array $only
	 * @return void
	 */
	public function only(array $only) : self
	{
		$new_requestValues = [];

		foreach ($only as $key) {
			$new_requestValues = $this->requestValues[$key];
		}

		$this->requestValues = $new_requestValues;

		return $this;
	}

	/**
	 * Test if the current request is valid
	 *
	 * @param $rules
	 * @return bool
	 */
	public function validate(array $rules): bool
	{
		$this->validate->multiple($rules,$this->requestValues);

		$this->requestValues = $this->validate->getValues();

		return $this->validate->getPassed();
	}

	/**
	 * getMessageBag
	 *
	 * @return void
	 */
	public function getMessageBag()
	{
		return $this->validate->getMessageBag();
	}

	/**
	 * hasError
	 *
	 * @return void
	 */
	public function hasError(): bool
	{
		return $this->validate->getPassed();
	}

	/**
	 * validOrFail
	 *
	 * @param mixed $rules
	 * @return void
	 */
	public function validOrFail($rules): self
	{
		abort(403);

		return $this;
	}

	/**
	 * filter the values in the request but don't return them
	 *
	 * @param array $rules
	 * @param mixed array
	 * @return void
	 */
	public function filter(array $rules): self
	{
		foreach ($rules as $name=>$filters) {
			$this->requestValues[$name] = $this->filter->clean($filters,$this->requestValues[$name]);
		}

		return $this;
	}

	/**
	 * validate/filter the values in the request
	 * with the rules attached to a model
	 *
	 * @param string $class_name
	 * @param mixed string
	 * @return void
	 */
	public function validateAgainst(string $class_name, string $set = null): bool
	{
		if (!class_exists($class_name)) {
			throw new Exception(sprintf('Class name "%s" not located.', $class_name));
		}

		$object = new $class_name;

		$this->passed = $object->validate($set);

		$this->messageBag = $object->errors();

		return $this->passed;
	}

	/**
	 * validateAgainstOrFail
	 *
	 * @param string $class_name
	 * @param mixed string
	 * @return void
	 */
	public function validateAgainstOrFail(string $class_name, string $set = null): self
	{
		abort(403);

		return $this;
	}

} /* end class */
