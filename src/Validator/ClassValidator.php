<?php

namespace Validator;
use \ReflectionClass;
use \ReflectionMethod;

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
	* @var string $methodPrefix Prefix used for validation methods.
	*/
	protected $methodPrefix = 'validate';

	/**
	* @var array $errors The array of generated errors.
	* Indexed by property name in property format
	*/
	protected $errors = [];

	/**
	* Constructor.
	* @param object $class
	*/
	public function __construct($class)
	{
		$this->class = $class;
	}

	/**
	* Gets error messages.
	* @return array
	*/
	public function getErrors(): array
	{
		return $this->errors;
	}

	/**
	* Gets all methods to be used for validation.
	* @return ReflectionMethod[]
	*/
	protected function getValidationMethods(): array
	{
		$class = new ReflectionClass($this);
		$publicMethods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

		$validationMethods = [];
		foreach($publicMethods as $method)
		{
			if(!strncmp($method->getName(), $this->methodPrefix, strlen($this->methodPrefix)) && $method->getName() != $this->methodPrefix)
			{
				$validationMethods[] = $method;
			}
		}

		return $validationMethods;
	}

	/**
	* Gets getter name corresponding to a validation method.
	* @param ReflectionMethod $method
	* @return string
	*/
	protected function getGetterName(ReflectionMethod $method): string
	{
		return 'get' . substr($method->getName(), strlen($this->methodPrefix));
	}

	/**
	* Gets the property name corresponding to a validation method.
	* @param ReflectionMethod $method
	* @return string
	*/
	protected function getPropertyName(ReflectionMethod $method): string
	{
		return lcfirst(substr($method->getName(), strlen($this->methodPrefix)));
	}

	/**
	* Performs validation for a specific method.
	* @param ReflectionMethod $method
	* @return bool
	*/
	protected function validateMethod(ReflectionMethod $method): bool
	{
		$rules = $method->invoke($this);
		$data = null;

		$reflectionClass = new ReflectionClass($this->class);

		//Check for getter
		$getterName = $this->getGetterName($method);
		if($reflectionClass->hasMethod($getterName))
		{
			$dataMethod = $reflectionClass->getMethod($getterName);
			if($dataMethod->isPublic())
			{
				$data = $dataMethod->invoke($this->class);
			}
		}

		//Check for property
		$propertyName = $this->getPropertyName($method);
		if($reflectionClass->hasProperty($propertyName))
		{
			$dataProperty = $reflectionClass->getProperty($propertyName);
			if($dataProperty->isPublic())
			{
				$data = $this->class->{$propertyName};
			}
		}

		$validator = new DataValidator($data, $rules);
		$valid = $validator->validate();
		if(!$valid)
		{
			$this->errors[$propertyName] = $validator->getErrors();
		}
		return $valid;
	}

	/**
	* Validates the class.
	* @return bool
	*/
	public function validate(): bool
	{
		$valid = true;
		$methods = $this->getValidationMethods();
		foreach($methods as $method)
		{
			if(!$this->validateMethod($method))
			{
				$valid = false;
			}
		}
		return $valid;
	}
}

?>