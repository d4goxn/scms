<?php

/**
 * Test for the HTTPPostTestEntity helper function.
 *
 * @author  Dan Ross <ross9885@gmail.com>
 * @license GPLv3 gnu.org/licenses/gpl.html
 */

require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/HTTPPostTestEntity.php';

class HTTPPostTestEntityTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test YAML parsing ability.
	 */

	public function testParseYaml() {
		$entity = Yaml::parse('key: value');

		$this->assertArrayHasKey('key', $entity);
		$this->assertEquals('value', $entity['key']);
	}

	/**
	 * Make sure that testEntity.yml exists at the expected location.
	 */

	public function testTestEntityFile() {
		$this->assertTrue(is_readable(__DIR__ . '/data/testEntity.yml'));
	}
}

