<?php

namespace Validator\Rules;

/**
* This is the base class for all validation Rules.
* @author Sheldon Juncker
*/
abstract class Rule
{
	/**
	* @var mixed $data The data to validate.
	*/
	protected $data = null;

	/**
	* @var string $error The error message for invalid data.
	*/
	protected $errors = null;

	/**
	* @var bool $valid Indicated whether the rule has been validated.
	*/
	protected $valid = false;

	/**
	* Sets the rule's data to validate.
	* @param mixed $data
	*/
	public function setData($data)
	{
		$this->data = $data;
	}

	/**
	* Determines if the rule was validated.
	* @return boolean
	*/
	public function isValid(): bool
	{
		return $this->valid;
	}

	/**
	* Gets the error message.
	* @return string
	*/
	public function getError(): string
	{
		return $this->error;
	}

	/**
	* Sets the error message.
	* @param string $error
	*/
	public function setError(string $error)
	{
		$this->error = $error;
	}

	/**
	* Gets the class name for a rule's name.
	* @param string $ruleName
	* @return string
	*/
	public static function getClassName(string $ruleName): string
	{
		$camels = explode('-', $ruleName);
		foreach($camels as &$camel)
		{
			$camel = ucfirst($camel);
		}
		
		return 'Validator\\Rules\\' . implode('', $camels);
	}
}

?>