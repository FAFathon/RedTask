<?php
	require_once "config.php";
	require_once "db-mysql.php";

	class GenericService {
		public static $db = NULL;

		
		protected function connect() {
			global $config;
			if ($this->db == NULL) {
				$this->db = new MysqlDB($config['host'], $config['username'], $config['password'], $config['db']);
			}
		}
	}
?>