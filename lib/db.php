<?php
	/**
	 * Connect to a MySQL database using PDO and return a handle.
	 * @param host
	 * @param database: database name
	 * @param user: database user name
	 * @param password: database user password
	 *
	 * @return A new PDO database handle.
	 */
	function connect(&$args) {
		$dsn = "mysql:host=$args[host];dbname=$args[database]";
		$dbh = new PDO($dsn, $args['user'], $args['password']);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}
