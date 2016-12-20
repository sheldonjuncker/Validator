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
	protected $min = null;

	/**
	* Constructor
	* @param float $min
	*/
	public function __construct(float $min)
	{
		$this->min = $min;
	}

	/**
	* Validates the data.
	* @return bool
	*/
	public function validate(): bool
	{
		if(is_array($this->data))
		{
			return count($this->data) >= $this->min;
		}

		else if(is_string($this->data))
		{
			return strlen($this->data) >= $this->min;
		}

		return false;
	}
}

?>