<?php

namespace Orange\Core\Libraries;

use Illuminate\Database\Eloquent\Model as Laravel_Model;
use Illuminate\Support\Facades\Validator;

class Model extends Laravel_Model
{
	//protected $guarded = [];
	//protected $fillable = [];
	
	protected $setName;
	
	protected $rules = [
	];

	protected $ruleSets = [
	];
	
	protected $validator;
	protected $passed = false;

	public function errors()
	{
		/* Laravel MessageBag */
		return $this->validator->errors();
	}

	public function ruleSet(string $setName) : Model
	{
		$this->setName = $setName;

		return $this;
	}

	public function save(array $options = []) : bool
	{
		if (!$this->setName && !$this->exists) {
			$this->setName = 'store';
		} elseif(!$this->setName && $this->exists) {
			$this->setName = 'update';
		}

		if ($success = $this->validate($this->setName)) {
			parent::save($options);
		}

		unset($this->setName);

		return $success;
	}

	protected function validate(string $setName) : bool
	{
		$recordKeys = array_keys($this->attributes);

		if ($setName) {
			if (!isset($this->ruleSets[$setName])) {
				throw new \Exception(sprintf('Could not locate the rule set "%s" on your class "%s".',$setName,__CLASS__));
			}
			
			/* our rule sets are comma seperated string of column names */
			$onlyRuleColumns = explode(',',$this->ruleSets[$setName]);
		} else {
			$onlyRuleColumns = array_keys($this->rules);
		}

		$newAttributes = [];
		$validationRules = [];

		foreach ($onlyRuleColumns as $dataColumnKey) {
			$newAttributes[$dataColumnKey] = isset($this->attributes[$dataColumnKey]) ? $this->attributes[$dataColumnKey] : null;
			$validationRules[$dataColumnKey] = $this->rules[$dataColumnKey];
		}

		$this->attributes = $newAttributes;

		$this->validator = Validator::make($this->attributes, $validationRules);

		$success = $this->validator->passes();

		//$this->validator->errors()->add('success',);
		$this->validator->errors()->merge(['success'=>(bool)$success]);

		/* preform actual validation and return if it passed */
		return $success;
	}

} /* end class */
