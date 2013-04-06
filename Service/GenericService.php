<?php
	require_once "config.php";
	require_once "db-mysql.php";

	class GenericService {
		public static $db = NULL;

		function __construct() {
			if ($db == NULL) {
				$db = new MysqlDB($host, $username, $password, $db);
			}
		}
	}
?>