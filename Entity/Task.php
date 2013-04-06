<?php
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