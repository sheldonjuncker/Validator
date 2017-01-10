<?php

namespace Validator;

/**
* This is the base class for classes that validate associate arrays.
* Specifically useful for validating forms from $_GET/$_POST data.
* @author Sheldon Juncker
*/
abstract class ArrayValidator
{
	/**
	* @var array $array The array to validate.
	*/
	protected $array = [];

	/**
	* @var array $errors Errors generated during validation.
	*/
	protected $errors = [];

	/**
	* Constructor accepts an array to validate.
	* @param array $array
	*/
	public function __construct(array $array)
	{
		$this->array = $array;
	}

	/**
	* Gets the rules to validate each array index.
	* Each child class specifies the appropriate rules to validate its array data.
	* @return array
	*/
	abstract public function getRules(): array;

	/**
	* Validates the array.
	* @return bool
	*/
	public function validate(): bool
	{
		$rules = $this->getRules();

		$valid = true;
		foreach($rules as $key => $rule)
		{
			//TODO: allow for optional elements
			if(isset($this->array[$data]))
			{
				$data = $this->array[$key];
				$validator = new DataValidator($data, $rule);
				if(!$validator->validate())
				{
					$valid = false;
					$this->errors[$key] = $validator->getErrors();
				}
			}
			else
			{
				$valid = false;
			}
		}

		return $valid;
	}

	/**
	* Gets generated errors.
	* @return array
	*/
	public function getErrors(): array
	{
		return $this->errors;
	}
}

?>