<?php

use Validator\Rules\MinLength;

class MinLengthTest extends \PHPUnit_Framework_TestCase
{
	public function testInvalidDataType()
	{
		$min = new MinLength(5);

		//Invalid data: expects array/string
		$min->setData(0);

		$this->assertFalse($min->validate());
	}

	public function testStringValidation()
	{
		$min = new MinLength(13);
		$min->setData("Hello, world!");
		$this->assertTrue($min->validate());
	}

	public function testStringInvalidation()
	{
		$min = new MinLength(13);
		$min->setData("Hello, world");
		$this->assertFalse($min->validate());
	}

	public function testArrayValidation()
	{
		$min = new MinLength(13);
		$min->setData(str_split("Hello, world!"));
		$this->assertTrue($min->validate());
	}

	public function testArrayInvalidation()
	{
		$min = new MinLength(13);
		$min->setData(str_split("Hello, world"));
		$this->assertFalse($min->validate());
	}
}

?>