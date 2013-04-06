<?php
	require_once "GenericService.php";
	require_once "../Entity/Task.php";
	
	class TaskService extends GenericService {

		function __construct() {
			$this->connect();
		}

		function getTask($id) {
			$params = array('id' => $id);
			$query = "SELECT * FROM `tasks` WHERE `tasks`.`id` = :id";
			var_dump($this->db->fetchAll($query, $params));	
		}	
	}

	$pearja = new TaskService();
	$pearja->getTask(1);
?>