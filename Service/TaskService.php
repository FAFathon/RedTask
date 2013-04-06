<?php
	require_once "GenericService.php";
	require_once "../Entity/Task.php";
	
	class TaskService extends GenericService {

		function __construct() {
			parent::__construct();
		}

		function getTask($id) {
			$params = array('id' => $id);	
			$query1 = "SELECT * FROM `tasks` WHERE `tasks`.`id` = :id";
			$query2 = "SELECT * FROM `label_task` LEFT JOIN `labels` ON `label_task`.`label_id` = `labels`.`id` WHERE `label_task`.`task_id` = :id";
			var_dump(self::$db->fetchAll($query2, $params));
			$task = new Task(self::$db->fetchAll($query1, $params)[0]);
			$task->uploadLabels(self::$db->fetchAll($query2, $params));
			return $task;
		}

	}

	$pearja = new TaskService();
	$task = $pearja->getTask(1);
	echo $task->getId();
	foreach ($task->getLabels() as $value) {
		$value->getName();
	}

?>