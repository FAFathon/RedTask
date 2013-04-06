<?php
	require_once "config.php";
	require_once "db-mysql.php";

	class GenericService {
		public static $db = NULL;

		protected function __construct() {
			global $config;
			if (self::$db == NULL) {
				self::$db = new MysqlDB($config['host'], $config['username'], $config['password'], $config['db']);
			}
		}
	}
?>