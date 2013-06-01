<?php
/**
 * Test tests: Make sure that PHPUnit runs.
 *
 * @author  Dan Ross <ross9885@gmail.com>
 * @license GPLv3 gnu.org/licenses/gpl.html
 */

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testPushAndPop()
	{
		$stack = array();
		$this->assertEquals(0, count($stack));
 
		array_push($stack, 'foo');
		$this->assertEquals('foo', $stack[count($stack)-1]);
		$this->assertEquals(1, count($stack));
 
		$this->assertEquals('foo', array_pop($stack));
		$this->assertEquals(0, count($stack));
	}
}
