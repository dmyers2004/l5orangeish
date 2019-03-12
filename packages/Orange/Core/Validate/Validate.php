<?php

namespace Orange\Core\Validate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class Validate {
	/**
	 * $validator
	 *
	 * @var undefined
	 */
	protected $validator;

	/**
	 * $messageBag
	 *
	 * @var undefined
	 */
	protected $messageBag;

	/**
	 * $passed
	 *
	 * @var boolean
	 */
	protected $passed = false;

	/**
	 * $value
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * $key
	 *
	 * @var string
	 */
	protected $key = 'field name';

	/**
	 * single
	 *
	 * @param string $rules
	 * @param mixed $value
	 * @param mixed string
	 * @return void
	 */
	public function single(string $rules,$value,string $fieldname = null): bool
	{
		$fieldname = ($fieldname) ? $fieldname : $this->key;

		$validator = Validator::make([$fieldname=>$value],[$fieldname=>$rules]);

		/* run validation */
		$this->passed = $validator->passes();

		$this->messageBag = $validator->errors();

		$this->value = $validator->getData()[$fieldname];

		return $this->passed;
	}

	/**
	 * multiple
	 *
	 * @param array $rules
	 * @param array $data
	 * @return void
	 */
	public function multiple(array $rules, array $data) : bool
	{
		$validator = Validator::make($data,$rules);

		/* run validation */
		$this->passed = $validator->passes();

		$this->messageBag = $validator->errors();

		$this->value = $validator->getData();

		return $this->passed;
	}

	/**
	 * getPassed
	 *
	 * @return void
	 */
	public function getPassed() : bool
	{
		return $this->passed;
	}

	/**
	 * getValue
	 *
	 * @return void
	 */
	public function getValue() /* mixed */
	{
		return $this->value;
	}

	/**
	 * getValues
	 *
	 * @return array
	 */
	public function getValues() : array
	{
		return $this->value;
	}

	/**
	 * getMessageBag
	 *
	 * @return void
	 */
	public function getMessageBag()
	{
		return $this->messageBag;
	}

} /* end class */
