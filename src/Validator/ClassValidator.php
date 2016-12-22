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
	* @var string $methodPrefix Prefix used for validation methods.
	*/
	protected $methodPrefix = 'validate';

	/**
	* Constructor.
	* @param object $class
	*/
	public function __construct($class)
	{
		$this->class = $class;
	}

	/**
	* Gets all methods to be used for validation.
	* @return ReflectionMethod[]
	*/
	protected function getValidationMethods(): array
	{
		$class = new ReflectionClass($this);
		$publicMethods = $class->getMethods( ReflectionMethod::IS_PUBLIC);

		$validationMethods = [];
		foreach($validationMethods as $method)
		{
			if(strncmp($method->getName(), $this->methodPrefix, strlen($this->methodPrefix)) && $method != $this->methodPrefix)
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
	public function validateMethod(ReflectionMethod $method): bool
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
		return $validator->validate();
	}

	/**
	* Validates the class.
	* @return bool
	*/
	public function validate(): bool
	{
		$methods = $this->getValidationMethods();
		foreach($methods as $method)
		{
			if(!$this->validateMethod($method))
			{
				return false;
			}
		}
		return true;
	}
}

?>