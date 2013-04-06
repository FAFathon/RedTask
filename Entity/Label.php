<?php
	class Label {
		private $id;
		private $name;
		private $description;

		function __construct($array = NULL) {
			if ($array == NULL)
				return;

			$this->setId($array['id']);
			$this->setName($array['name']);
			$this->setDescription($array['description']);
		}


		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}

		public function getName() {
			return $this->name;
		}
		public function setName($name) {
			$this->name = $name;
		}

		public function getDescription() {
			return $this->description;
		}
		public function setDescription($description) {
			$this->description = $description;
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