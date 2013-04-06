<?php
    chdir(dirname(__FILE__));
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
			$task = new Task(self::$db->fetchAll($query1, $params)[0]);
			$task->uploadLabels(self::$db->fetchAll($query2, $params));
			return $task;
		}

		function getTasks() {
			$tasks;
			$query = "SELECT * FROM `tasks`";

			foreach (self::$db->fetchAll($query) as $value) {
				$task = new Task($value);
				$params = array('id' => $task->getId());
				$queryLabel = "SELECT * FROM `label_task` LEFT JOIN `labels` ON `label_task`.`label_id` = `labels`.`id` WHERE `label_task`.`task_id` = :id";
				$task->uploadLabels(self::$db->fetchAll($queryLabel, $params));
				$tasks[] = $task;
			}
			return $tasks;
		}

		function addTask($name) {
			//INSERT INTO table_name (column1, column2, column3,...)
			//VALUES (value1, value2, value3,...)
			$params = array('name' => $name);
			$query = "INSERT INTO `tasks` (`tasks`.`title`) VALUES (:name)";
			self::$db->Q($query, $params);
		}

	}

	$pearja = new TaskService();
	$pearja->addTask("Sa fac perojoace");
?>

