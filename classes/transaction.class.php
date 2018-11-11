<?php 
	/**
	 * 
	 */
	class transaction	{
		private $id;
		private $cId;
		private $quantity;
		private $amount;
		private $orderStatus;
		private $createdOn;
		public $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setCid($cId) { $this->cId = $cId; }
		function getCid() { return $this->cId; }
		function setQuantity($quantity) { $this->quantity = $quantity; }
		function getQuantity() { return $this->quantity; }
		function setAmount($amount) { $this->amount = $amount; }
		function getAmount() { return $this->amount; }
		function setOrderStatus($orderStatus) { $this->orderStatus = $orderStatus; }
		function getOrderStatus() { return $this->orderStatus; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct($conn) {
			$this->dbConn = $conn;
		}

		public function saveTransaction() {
			$sql = "INSERT INTO `transactions`(`id`, `cid`, `quantity`, `amount`, `orderStatus`, `createdOn`) VALUES (null, :cid, :quantity, :amount, :orderStatus, :cdate)";
			$stmt = $this->dbConn->prepare($sql);

			$stmt->bindParam(':cid', $this->cId);
            $stmt->bindParam(':quantity', $this->quantity);
            $stmt->bindParam(':amount', $this->amount);
            $stmt->bindParam(':orderStatus', $this->orderStatus);
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

		public function updateTransaction() {
			$sql = "UPDATE `transactions` SET `orderStatus` =:orderStatus WHERE id =:tid AND cid = :cid";
			$stmt = $this->dbConn->prepare($sql);

			$stmt->bindParam(':cid', $this->cId);
            $stmt->bindParam(':tid', $this->id);
            $stmt->bindParam(':orderStatus', $this->orderStatus);

            try {
                if($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
		}

		public function getTransactions() {
            $sql  = "SELECT 
            			t.id, 
            			t.quantity, 
            			t.amount, 
            			t.orderStatus, 
            			t.createdOn, 
            			c.name 
            		FROM 
            			transactions t 
            			JOIN customers c ON c.id = t.cid";

            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam('cid', $this->cid);
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $transactions;   
        }

        public function getOrderStatusById($statusId) {
        	switch ($statusId) {
        		case 0:
        			return 'Initiated';
        			break;
        		case 1:
        			return 'Success';
        			break;
        		case 2:
        			return 'Aborted';
        			break;
        		case 3:
        			return 'Failed';
        			break;
        	}

        }
	}
 ?>