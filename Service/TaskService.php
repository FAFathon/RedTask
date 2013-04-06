<?php
    chdir(dirname(__FILE__));
	require_once "GenericService.php";
	require_once "../Entity/Task.php";

	class TaskService extends GenericService {

		function __construct() {
			parent::__construct();
		}

		public function getTask($id) {
			$params = array('id' => $id);
			$query1 = "SELECT * FROM `tasks` WHERE `tasks`.`id` = :id";
			$query2 = "SELECT * FROM `label_task` LEFT JOIN `labels` ON `label_task`.`label_id` = `labels`.`id` WHERE `label_task`.`task_id` = :id";
			$task = new Task(self::$db->fetchAll($query1, $params)[0]);
			$task->uploadLabels(self::$db->fetchAll($query2, $params));
			return $task;
		}

		public function getTasks() {
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

		public function addTask($name) {
			//INSERT INTO table_name (column1, column2, column3,...)
			//VALUES (value1, value2, value3,...)
			$params = array('name' => $name);
			$query = "INSERT INTO `tasks` (`tasks`.`title`) VALUES (:name)";
			self::$db->Q($query, $params);
		}

		public function editTask($id, $params) {
			$params['id'] = $id;
			$task = new Task($params);
			$this->persistTask($task);
		}

		protected function persistTask($task) {
			$set_query = "";
			$params = array();
			
			$value = $task->getTitle();
			if (isset($value)) {
				$index = "title";
				$params[$index] = $value;
				$set_query .= $index . ' = :' . $index;
			}
			
			$value = $task->getDescription();
			if (isset($value)) {
				$index = "description";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getDeadline();
			if (isset($value)) {
				$index = "deadline";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getTimeEstimated();
			if (isset($value)) {
				$index = "time_estimated";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getTimeSpent();
			if (isset($value)) {
				$index = "time_spent";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getPriority();
			if (isset($value)) {
				$index = "priority";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getProgress();
			if (isset($value)) {
				$index = "progress";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$value = $task->getWeigth();
			if (isset($value)) {
				$index = "weigth";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$query = "UPDATE `tasks` SET " . $set_query . " WHERE `tasks`.`id` = :id";
			echo $query;
			
			$value = $task->getId();
			if (isset($value)) {
				$params['id'] = $task->getId();
				self::$db->Q($query, $params);
			}
		}
	}
?>

