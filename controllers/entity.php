<?php

require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../lib/db.php';

class EntityController {

	private $table;

	public function __construct($table) {
		$this->table = $table;
	}

	/**
	 * Check if an entity exists in the database.
	 *
	 * @param $name The uniques name of the entity
	 * @returns boolean
	 */

	public function entityExists($name) {
		global $dbConnectionInfo;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare("SELECT * FROM $this->table WHERE name = ?");
		$statement->execute(array($name));

		return ($statement->rowCount() === 1);
	}

	/**
	 * Create an entity in the database.
	 *
	 * @param $entity An associative array. Only the `name` parameter is mandatory.
	 *
	 * @throws UserError if the entity has no name.
	 */

	public function createEntity($entity) {
		global $dbConnectionInfo;

		$entry = []; # We set the column names manually to prevent sql injection.
		$entry['name'] = $entity['name'];
		$entry['type'] = $entity['type'];
		$entry['title'] = empty($entity['title'])? '': $entity['title'];
		$entry['body'] = empty($entity['body'])? '': $entity['body'];
		$entry['created'] = empty($entity['created'])? time(): $entity['created'];
		$entry['updated'] = empty($entity['updated'])? time(): $entity['updated'];

		if(empty($entity['name']))
			throw UserError('An entity must have a name.');

		if(empty($entity['type']))
			throw UserError('An entity must have a type.');

		$placeholders = [];
		foreach(array_keys($entry) as $field)
			$placeholders[] = ':' . $field;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare(
			"INSERT INTO $this->table ("
			. implode(', ', array_keys($entry))
			. ') VALUES ('
			. implode(', ', $placeholders)
			. ')');

		$entryMap = array_combine($placeholders, array_values($entry));

		$statement->execute($entryMap);
	}

	/**
	 * Get an entity by name from the database.
	 *
	 * @param $name The unique name of the entity.
	 *
	 * @returns an entity as an associative array.
	 */

	public function getEntity($name) {
		global $dbConnectionInfo;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare("SELECT * FROM $this->table WHERE name = ?");
		$statement->execute(array($name));

		return($statement->fetch(PDO::FETCH_ASSOC));
	}

	/**
	 * Delete an entity.
	 *
	 * @param $name The unique name of the entity.
	 */

	public function deleteEntity($name) {
		global $dbConnectionInfo;

		$db = connect($dbConnectionInfo);
		$statement = $db->prepare("DELETE FROM $this->table WHERE name = ?");
		$statement->execute(array($name));
	}
}
