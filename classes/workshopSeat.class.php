<?php 
	/**
	 * 
	 */
	class workshopSeat {
		private $id;
		private $tId;
		private $wId;
		private $quantity;
		private $createdOn;
		public $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setTid($tId) { $this->tId = $tId; }
		function getTid() { return $this->tId; }
		function setWid($wId) { $this->wId = $wId; }
		function getWid() { return $this->wId; }
		function setQuantity($quantity) { $this->quantity = $quantity; }
		function getQuantity() { return $this->quantity; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct($conn) {
			$this->dbConn = $conn;
		}

		public function bookSeats() {
			$sql = "INSERT INTO `workshop_seats`(`id`, `tid`, `wid`, `quantity`, `createdOn`) VALUES (null, :tid, :wid, :quantity, :cdate)";
			$stmt = $this->dbConn->prepare($sql);

            $stmt->bindParam(':tid', $this->tId);
            $stmt->bindParam(':wid', $this->wId);
            $stmt->bindParam(':quantity', $this->quantity);
            $stmt->bindParam(':cdate', $this->createdOn);

            try {
                if($stmt->execute()) {
                    return $this->dbConn->lastInsertId();
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
		}

		public function getWorkshopSeatsByTid() {
            $sql  = "SELECT 
            			ws.id, 
            			ws.quantity, 
            			ws.createdOn, 
            			w.title, 
            			w.price, 
            			w.image,
            			c.name
            		FROM 
            			workshop_seats ws 
            			JOIN transactions t ON ws.tid = t.id
            			JOIN workshops w ON w.id = ws.wid
            			JOIN customers c ON c.id = t.cid
            		WHERE 
            			ws.tid = :tid";

            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam('tid', $this->tId);

            $stmt->execute();
            $workshopSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $workshopSeats;   
        }
	}
 ?>