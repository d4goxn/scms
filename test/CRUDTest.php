<?php

require_once __DIR__ . '/../controllers/entity.php';
require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../lib/db.php';

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

class CRUDTest extends PHPUnit_Framework_TestCase {

	private $testTable = 'entities_test';
	private $entityController;

	/**
	 * Create a test table with the same schema as entities.
	 */

	protected function setUp() {
		global $dbConnectionInfo;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare("DROP TABLE IF EXISTS $this->testTable");
		$statement->execute();
		$statement = $db->prepare("CREATE TABLE $this->testTable LIKE `entities`");
		$statement->execute();

		$this->entityController = new EntityController($this->testTable);
	}

	/**
	 * Drop the testing table.
	 */

	protected function tearDown() {
		global $dbConnectionInfo;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare("DROP TABLE $this->testTable");
		$statement->execute();
	}

	/**
	 * Test entityExists.
	 */

	public function testEntityExists() {
		$entity = Yaml::parse(file_get_contents(__DIR__ . '/data/testEntity.yml'));
		$entity['name'] = 'shouldNotExist';
		$this->assertFalse($this->entityController->entityExists($entity['name']), "'$entity[name]' already exists.");
	}

	/**
	 * Test the createEntity, getEntity, updateEntity and deleteEntity controllers in order.
	 */

	public function testCRUDControllers() {
		$entity = Yaml::parse(file_get_contents(__DIR__ . '/data/testEntity.yml'));
		$entity['name'] = 'CRUDTest';

		$this->assertFalse($this->entityController->entityExists($entity['name']), "'$entity[name]' already exists.");
		$this->entityController->createEntity($entity);
		$this->assertTrue($this->entityController->entityExists($entity['name']), "'$entity[name]' was not created.");

		$localEntity = $this->entityController->getEntity($entity['name']);
		foreach(array_keys($entity) as $key)
			$this->assertEquals($localEntity[$key], $entity[$key],
				"localEntity[$key] '"
				. $localEntity[$key]
				. "' does not match entity[$key] '"
				. $entity[$key]
				. "'.");

		$this->entityController->deleteEntity($entity['name']);
		$this->assertFalse($this->entityController->entityExists($entity['name']), "'$entity[name]' was not deleted.");
		usleep(10000);
	}
}
