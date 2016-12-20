<?php

namespace Validator;

/**
* This class is used to validate single pieces of data.
*/
class DataValidator
{
	/**
	* @var mixed $data The data to validate.
	*/
	protected $data = null;

	/**
	* @var array $rules Validation rules to use in validation.
	*/
	protected $rules = [];

	/**
	* Constructor.
	* @param mixed $data The data to validate
	* @param array $rules Validation rules
	*/
	public function __construct($data, array $rules)
	{
		$this->data = $data;
		$this->rules = $rules;
	}

	/**
	* Validates a rule.
	* @param string $ruleName The name of the rule
	* @param mixed $ruleParams The rule's parameters
	* @return bool
	*/
	protected function validateRule(string $ruleName, string $ruleParams): bool
	{
		$className = Rules\Rule::getClassName($ruleName);
		$rule = new $className($ruleParams);
		$rule->setData($this->data);
		return $rule->validate();
	}

	/**
	* Validates the data.
	* @return bool
	*/
	public function validate(): bool
	{
		foreach($this->rules as $ruleName => $ruleParams)
		{
			if(!$this->validateRule($ruleName, $ruleParams))
				return false;
		}

		return true;
	}
}

?>