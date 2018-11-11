<?php 
	if (isset($_POST['action'])) {
		session_start();
		require_once('db/DbConnect.php');
        $db   = new DbConnect();
        $conn = $db->connect();

		require 'classes/workshop.class.php';
		require 'classes/cart.class.php';

		if (isset($_POST['wId'])) {
			$objWorkshop = new workshop($conn);
			$objWorkshop->setId($_POST['wId']);
			$workshop = $objWorkshop->getWorkshopById();
		}
    	
    	$objCart = new cart($conn);
		switch ($_POST['action']) {
			case 'add':
		    	$objCart->setCid($_SESSION['cid']);
			 	$objCart->setPid($workshop['id']);
			 	$objCart->setTitle($workshop['title']);
			 	$objCart->setQuantity(1);
			 	$objCart->setTotalAmount($workshop['price']);
			 	$objCart->setCreatedOn(date('Y-m-d H:i:s'));

			 	if($objCart->addItem()) {
			 		echo json_encode( ["status" => 1, "msg" => "Added to cart."] );
					exit;
			 	} else {
			 		echo json_encode( ["status" => 0, "msg" => "Opps!! Something went wrong."] );
					exit;
			 	}

				break;

			case 'update':
		    	$objCart->setCid($_SESSION['cid']);
			 	$objCart->setPid($workshop['id']);
			 	$objCart->setQuantity($_POST['quantity']);
			 	$objCart->setTotalAmount($workshop['price']*$_POST['quantity']);

			 	if($objCart->updateItem()) {
			 		$data = $objCart->calculatePrices();

			 		echo json_encode( ["status" => 1, "msg" => "Cart updated.", 'data' => $data] );
					exit;
			 	} else {
			 		echo json_encode( ["status" => 0, "msg" => "Opps!! Something went wrong."] );
					exit;
			 	}

				break;

			case 'remove':
		    	$objCart->setCid($_SESSION['cid']);
			 	$objCart->setId($_POST['cartId']);

			 	if($objCart->removeItem()) {
			 		$data = $objCart->calculatePrices();

			 		echo json_encode( ["status" => 1, "msg" => "Cart item deleted.", 'data' => $data] );
					exit;
			 	} else {
			 		echo json_encode( ["status" => 0, "msg" => "Opps!! Something went wrong."] );
					exit;
			 	}

				break;

			case 'clear':
		    	$objCart->setCid($_SESSION['cid']);
			 	
			 	if($objCart->removeAllItems()) {

			 		echo json_encode( ["status" => 1, "msg" => "Cart is clear."] );
					exit;
			 	} else {
			 		echo json_encode( ["status" => 0, "msg" => "Opps!! Something went wrong."] );
					exit;
			 	}

				break;

			default:
				# code...
				break;
		}
	} else {
		header('location: index.php');
	}
 ?>