<?php
	require_once "GenericService.php";
	require_once "../Entity/Task.php";
	
	class TaskService extends GenericService {

		function __construct() {
			parent::__construct();
		}

		function getTask($id) {
			$params = array('id' => $id);
			$query = "SELECT * FROM `tasks` WHERE `tasks`.`id` = :id";
			var_dump(self::$db->fetchAll($query, $params));
		}

	}

?>