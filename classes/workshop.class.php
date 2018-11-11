<?php 
	/**
	 * 
	 */
	class workshop {
		private $id;
		private $title;
		private $price;
		private $description;
		private $image;
		private $createdOn;
		public $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setTitle($title) { $this->title = $title; }
		function getTitle() { return $this->title; }
		function setPrice($price) { $this->price = $price; }
		function getPrice() { return $this->price; }
		function setDescription($description) { $this->description = $description; }
		function getDescription() { return $this->description; }
		function setImage($image) { $this->image = $image; }
		function getImage() { return $this->image; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct($conn) {
			$this->dbConn = $conn;
		}

		public function getAllWorkshops() {
			$sql  = "SELECT * FROM workshops";
			$stmt = $this->dbConn->prepare($sql);
			$stmt->execute();
			$workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $workshops;	
		}

		public function getWorkshopById() {
			$sql  = "SELECT * FROM workshops WHERE id = :wid";
			$stmt = $this->dbConn->prepare($sql);
			$stmt->bindParam('wid', $this->id);
			$stmt->execute();
			$workshop = $stmt->fetch(PDO::FETCH_ASSOC);
			return $workshop;	
		}
	}
 ?>