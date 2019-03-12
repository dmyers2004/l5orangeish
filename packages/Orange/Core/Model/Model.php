<?php

namespace Orange\Core\Model;

use Illuminate\Database\Eloquent\Model as Laravel_Model;
use Illuminate\Support\Facades\Validator;

class Model extends Laravel_Model
{
	//protected $guarded = [];
	//protected $fillable = [];
	//protected $hidden = [];
	//protected $casts = [];
  //protected $table = 'my_flights';

	protected $setName;

	protected $rules = [
	];

	protected $ruleSets = [
	];

	protected $validator;
	protected $success = false;

	public function errors()
	{
		/* Laravel MessageBag or nothing if we didn't even validate yet */
		return (isset($this->validator)) ? $this->validator->errors() : [];
	}

	public function messageBag()
	{
		$data = new \StdClass;

		$data->success = $this->success;
		$data->input = $this->attributes;
		$data->errors = $this->errors();

		return json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	}

	public function ruleSet(string $setName) : self
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

	public function delete()
	{
		$this->success = parent::delete();

		return $this->success;
	}

	protected function validate(string $setName) : bool
	{
		$recordKeys = array_keys($this->attributes);

		if ($setName) {
			if (!isset($this->ruleSets[$setName])) {
				throw new \Exception(sprintf('Could not locate the rule set "%s" on your class "%s".',$setName,__CLASS__));
			}

			/* our rule sets are comma separated string of column names */
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

		$this->success = $this->validator->passes();

		/* preform actual validation and return if it passed */
		return $this->success;
	}

} /* end class */
