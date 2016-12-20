<?php

use Validator\Rules\Rule;

class RuleTest extends \PHPUnit_Framework_TestCase
{
	public function testGetClassName()
	{
		$expected = [
			'abc-def-ghi' => 'Validator\\Rules\\AbcDefGhi',
			'abc' => 'Validator\\Rules\\Abc',
		];
		
		foreach($expected as $input => $output)
		{
			$this->assertEquals($output, Rule::getClassName($input));
		}
	}
}

?>