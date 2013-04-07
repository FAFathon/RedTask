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
				//$queryLabel = "SELECT * FROM `label_task` LEFT JOIN `labels` ON `label_task`.`label_id` = `labels`.`id` WHERE `label_task`.`task_id` = :id";
				//$task->uploadLabels(self::$db->fetchAll($queryLabel, $params));
				$tasks[] = $task;
			}
			return $tasks;
		}

        public function addTask($name) {
			$params = array('name' => $name);
			$query = "INSERT INTO `tasks` (`tasks`.`title`) VALUES (:name)";
            self::$db->Q($query, $params);
            $inserted_id = self::$db->lastInsertID();
            return array('id' => $inserted_id);
		}


		public function editTask($id, $params) {
			$params['id'] = $id;
			$oldTask = $this->getTask($id);

			$task = $this->combineTask($oldTask, $params);
			
			$task = $this->evalTask($task);
			var_dump($task);
			$task->setId($id);

			$this->persistTask($task);
		}

		public function evalTask($task) {
			if (!$this->verifyTask($task)) 
				return $task;

			$timeSpent = $task->getTimeSpent();
			$progress = $task->getProgress();
			$priority = $task->getPriority();


			$dlDelta = (strtotime($task->getDeadline()) - time()) / 60;
			echo "delta: " . $dlDelta . "\n";
			$necessaryTime;

			if ($task->getProgress() <= 0) {
				$necessaryTime = $task->getTimeEstimated();
			} else {
				$necessaryTime = ($timeSpent * (100 - $progress)) / $progress;
			}
			echo "necerrary:". $necessaryTime . "\n";

			if (($dlDelta - $necessaryTime) >= 0) {
				$weight = ( 1200000 * ( log($priority) / ( 4 * log( ( ($dlDelta - $necessaryTime) / 300 ) + 2 ) ) + 1 ) ) / ($dlDelta + 500) + 1000;
				$task->setWeigth(intval($weight));
				echo "if1 \n" . $weight . "\n";
				return $task;
			} 
			if ($dlDelta >= 0 && $dlDelta < $necessaryTime){
				$weight = ( 1200000 * ( log($priority) / ( 4 * log( ( $dlDelta / $necessaryTime - 1 ) * 0.75 + 2 ) ) + 1 ) ) / ($dlDelta + 500) + 1000;
				$task->setWeigth(intval($weight));
				echo "if2 \n";
				return $task;
			} 
			if ($dlDelta < 0) {
				$weight = 1000 + ((0.25 * log($priority) / log(1.25) +1) / 500) * 1200000 - $dlDelta * 0.05; //last parammeter means how fast weight grow aftes DL, 0.05 - 720 per day
				$task->setWeigth(intval($weight));
				echo "if3 \n";
				return $task;
			}
			echo "necerrary:". $necessaryTime;
 		}

		/**
		* Combine the old task from DB with the new got params from Json
		*/
		public function combineTask($oldTask, $params) {
			$newTask = new Task();
			$newTask->setId($oldTask->getId());
			$newTask->setTitle($oldTask->getTitle());
			$newTask->getDescription($oldTask->getDescription());

			// Check deadline
			if (isset($params['deadline'])) {
				$newTask->setDeadline(date('Y-m-d H:i:s', strtotime($params['deadline'])));
			} else {
				$value = $oldTask->getDeadline();
				if (isset($value)) {
					$newTask->setDeadline(date('Y-m-d H:i:s', strtotime($value)));
				}
			}

			// Check progress
			if (isset($params['progress'])) {
				$newTask->setProgress($params['progress']);
			} else {
				$value = $oldTask->getProgress();
				if (isset($value)) {
					$newTask->setProgress($value);
				}
			}

			// Check priority
			if (isset($params['priority'])) {
				$newTask->setPriority($params['priority']);
			} else {
				$value = $oldTask->getPriority();
				if (isset($value)) {
					$newTask->setPriority($value);
				}
			}

			// Check spent time
			if (isset($params['time_spent'])) {
				$value = $oldTask->getTimeSpent();
				$newTask->setTimeSpent($params['time_spent'] + $value);
			} else {
				$newTask->setTimeSpent($oldTask->getTimeSpent());
			}

			// Check estimated time
			if (isset($params['time_estimated'])) {
				$newTask->setTimeEstimated($params['time_estimated']);
			} else {
				$value = $oldTask->get();
				if (isset($value)) {
					$newTask->set($value);
				}
			}
			return $newTask;
		}

		/**
		* Verify if the weight of the task can be executed
		*/
		public function verifyTask($task) {
			
			$value = $task->getDeadline();
			if (!isset($value)) {
				return false;
			}

			$value = $task->getTimeSpent();
			if (!isset($value)) {
				return false;
			}

			$value = $task->getPriority();
			if (!isset($value)) {
				return false;
			}

			$value = $task->getProgress();
			if (!isset($value)) {
				return false;
			}


			$value = $task->getTimeEstimated();
			if (!isset($value) || (($value <= 0) && ($task->getProgress() <= 0))) { // Can be a technical mistake
				return false;
			}

			return true;
		}

		public function persistTask($task) {
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
				$set_query .= ', ' . $index . ' = :'. $index;
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
				$index = "weight";
				$params[$index] = $value;
				$set_query .= ', ' . $index . ' = :' . $index;
			}

			$query = "UPDATE `tasks` SET " . $set_query . " WHERE `tasks`.`id` = :id";
<<<<<<< HEAD
			
=======
			//echo $query;

>>>>>>> d14c3b1384c7ecb3f6d88f141902835c9a9d8c06
			$value = $task->getId();
			if (isset($value)) {
				$params['id'] = $task->getId();
				self::$db->Q($query, $params);
			}
		}

		public function processTasks() {
			$tasks = $this->getTasks();

			foreach ($tasks as $value) {
				var_dump($value);
				//$task = $this->evalTask($value);
				//$this->persistTask($task);
			}			
		}
	}

	$params = array('deadline' => '2013-04-8 00:00:00',
					'time_estimated' => 60*6,
					'progress' => 0,
					'time_spent' => 0,
					'priority' => 3);

	
	$pearja = new TaskService();

	$pearja->processTasks();

?>

