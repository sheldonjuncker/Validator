<?php

namespace Validator\Rules;

/**
* Validates the minimum length of strings and arrays.
* @author Sheldon Juncker
*/
class MinLength extends Rule
{
	/**
	* @var double $min The minimum value for the data.
	*/
	protected $min;

	/**
	* Constructor
	* @param float $min
	*/
	public function __construct(float $min)
	{
		$this->min = $min;
	}

	/**
	* Generates the error message.
	*/
	public function generateErrorMessage()
	{
		$this->error = "length must be greater or equal to {$this->min}";
	}

	/**
	* Validates the data.
	* @return bool
	*/
	public function validate(): bool
	{
		$valid = false;

		if(is_array($this->data))
		{
			$valid = count($this->data) >= $this->min;
		}

		else if(is_string($this->data))
		{
			$valid = strlen($this->data) >= $this->min;
		}

		if(!$valid)
		{
			$this->generateErrorMessage();
		}

		return $valid;
	}
}

?>