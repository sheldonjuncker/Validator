<?php

/**
* A dummy User class to use during testing.
*/
class User
{
	//One public property
	public $name;

	//And a private one with a getter
	private $password;

	public function __construct($name, $password)
	{
		$this->name = $name;
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}
}

/**
* A validation class for the user.
*/
class UserValidator extends Validator\ClassValidator
{
	public function validateName()
	{
		return [
			'min-length' => 2
		];
	}

	public function validatePassword()
	{
		return [
			'min-length' => 8
		];
	}
}

class ClassValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function testValidUser()
	{
		$user = new User("John", "password");
		$uv = new UserValidator($user);
		$this->assertTrue($uv->validate());
	}

	public function testInvalidUser()
	{
		$user = new User("A", "pass");
		$uv = new UserValidator($user);
		$this->assertFalse($uv->validate());
	}
}

?>