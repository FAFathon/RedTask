<?php
	require_once "Label.php";

	class Task {

		private $id;
		private $title;
		private $description;
		private $deadline;
		private $timeEstimated;
		private $timeSpent;
		private $priority;
		private $progress;
		private $weigth;

		// Array of labe Objects
		private $labels;


		/**
		* @param set 2 dimensional array
		*/
		function __construct($array = NULL) {
			if ($array == NULL)
				return;
			if (isset($array['id'])) 
				$this->setId($array['id']);
			if (isset($array['title']))
				$this->setTitle($array['title']);
			if (isset($array['description']))
				$this->setDescription($array['description']);
			if (isset($array['deadline']))
				$this->setDeadline($array['deadline']);
			if (isset($array['time_estimated']))
				$this->setTimeEstimated($array['time_estimated']);
			if (isset($array['time_spent']))
				$this->setTimeSpent($array['time_spent']);
			if (isset($array['time_spent']))
				$this->setPriority($array['time_spent']);
			if (isset($array['progress']))
				$this->setProgress($array['progress']);
			if (isset($array['weight']))
				$this->setWeigth($array['weight']);
		}

		/**
		* @param 2 dimensional array
		*/
		function uploadLabels($array_2D) {
			foreach ($array_2D as $value) {
				$this->labels[] = new Label($value);
			}
		}


		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}

		public function getTitle() {
			return $this->title;
		}
		public function setTitle($title) {
			$this->title = $title;
		}

		public function getDescription() {
			return $this->description;
		}
		public function setDescription($description) {
			$this->description = $description;
		}

		public function getDeadline() {
			return $this->deadline;
		}
		public function setDeadline($deadline) {
			$this->deadline = $deadline;
		}

		public function getTimeEstimated() {
			return $this->timeEstimated;
		}
		public function setTimeEstimated($timeEstimated) {
			$this->timeEstimated = $timeEstimated;
		}

		public function getTimeSpent() {
			return $this->timeSpent;
		}
		public function setTimeSpent($timeSpent) {
			$this->timeSpent = $timeSpent;
		}

		public function getPriority() {
			return $this->priority;
		}
		public function setPriority($priority) {
			$this->priority = $priority;
		}

		public function getProgress() {
			return $this->progress;
		}
		public function setProgress($progress) {
			$this->progress = $progress;
		}

		public function getWeigth() {
			return $this->weigth;
		}
		public function setWeigth($weigth) {
			$this->weigth = $weigth;
		}

		public function getLabels() {
			return $this->labels;
		}
		public function setLabels($labels) {
			$this->labels = $labels;
		}

		/* <<< Prototype >>>
		
		public function get() {
			return $this->;
		}
		public function set($) {
			$this-> = $;
		}
		*/
	}
?>