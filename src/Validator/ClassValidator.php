<?php

namespace Validator;

/**
* This class is used as the base class for classes that are
* created to validate other classes.
* @author Sheldon Juncker
*/
abstract class ClassValidator
{
	/**
	* @var object $class The class to validate.
	*/
	protected $class = null;

	/**
	* Constructor.
	* @param object $class
	*/
	public function __construct($class)
	{
		$this->class = $class;
	}
}

?>