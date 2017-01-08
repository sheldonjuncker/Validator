<?php

use Validator\DataValidator;

class DataValidatorTest extends \PHPUnit_Framework_TestCase
{
	//Validation only fails if a rule fails, if there are no rules, none can fail
	public function testEmptyRules()
	{
		$rules = [];
		$validator = new DataValidator('data', $rules);
		$this->assertTrue($validator->validate());
	}

	public function testValidation()
	{
		$validator = new DataValidator('data', [
			'min-length' => 4
		]);
		$this->assertTrue($validator->validate());
	}

	public function testInvalidation()
	{
		$validator = new DataValidator('data', [
			'min-length' => 5
		]);
		$this->assertFalse($validator->validate());
	}

	public function testErrorMessage()
	{
		$validator = new DataValidator('data', [
			'min-length' => 5
		]);
		$validator->validate();
		$errors = $validator->getErrors();
		$this->assertTrue(isset($errors['min-length']));
	}
}

?>