<?php

use Validator\ClassValidator;

require 'src/autoload.php';

class User
{
	private $name;
	private $pass;

	public function __construct($name, $pass)
	{
		$this->name = $name;
		$this->pass = $pass;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPass()
	{
		return $this->pass;
	}
}

class UserValidator extends ClassValidator
{
	public function validateName()
	{
		return [
			'min-length' => 2,
		];
	}

	public function validatePass()
	{
		return [
			'min-length' => 8,
		];
	}
}

$user = new User('', '');
$validator = new UserValidator($user);
$validator->validate();

print "<pre>";
print_r($validator->getErrors());
print "</pre>";

?>