<!DOCTYPE html>
<html>
<head>
	<title>Add to cart functionality in php and mysql</title>
	<link rel="stylesheet" href="../library/css/bootstrap.min.css">
	<script src="../library/js/jquery-3.2.1.min.js"></script>
	<script src="../library/js/bootstrap.js"></script>
</head>
<style type="text/css">
	.alert, #loader {
    	display: none;
    }

    .glyphicon, #itemCount {
    	font-size: 18px;
    }
</style>
<body>
	<div class="container">
		<pre style="padding: 0; margin: 0;">
		<h2 style="margin-top: 0px; padding-top: 0; padding-left: 5px; ">Add to cart functionality in php and mysql
		with CCAvenue payment gateway integration</h2></pre>
		<hr>

		<?php 
			require_once('db/DbConnect.php');
            $db   = new DbConnect();
            $conn = $db->connect();

			require 'classes/customer.class.php';
	    	$objCustomer = new customer($conn);
	    	$objCustomer->setEmail('durgesh@gmail.com');
	    	$customer = $objCustomer->getCustomerByEmailId();
	    	session_start();
	    	$_SESSION['cid'] = $customer['id'];

			require 'classes/cart.class.php';
			$objCart = new cart($conn);
			$objCart->setCid($customer['id']);
			$cartItems = $objCart->getAllCartItems();
		?>
		<div class="row">
	    	<div class="col-md-12 text-right">
	    		<a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span><sup id="itemCount"><?php echo count($cartItems); ?></sup></a>
	    	</div>
	    </div>

	    <div class="row">
	    	<div class="col-md-10 col-md-offset-1">
				<div class="alert alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
					<div id="result"></div>
				</div>
				<center><img src="images/loader.gif" id="loader"></center>
			</div>

	    	<?php 

		    	require 'classes/workshop.class.php';
		    	$objWorkshop = new workshop($conn);
		    	$workshops = $objWorkshop->getAllWorkshops();
		    	foreach ($workshops as $key => $workshop) {
		    ?>
		  <div class="col-sm-6 col-md-3">
		    <div class="thumbnail">
		      <img src="images/<?= $workshop['image']; ?>" alt="" style="width: 200px; height: 200px;">
		      <div class="caption">
		        <h3><?= $workshop['title']; ?></h3>
		        <p><?= substr($workshop['description'], 0, 60) . '...'; ?></p>
		        <p>
		        	<div class="row">
		        		<div class="col-sm-6 col-md-6">
		        			<strong> <span style="font-size: 18px;">&#x20b9;</span><?= number_format( $workshop['price'], 2 ); ?></strong>
		        		</div>
		        		<div class="col-sm-6 col-md-6">
		        			<?php 
		        				$disButton = "";
		        				if( array_search($workshop['id'], array_column($cartItems, 'pid')) !==false ) {
		        					$disButton = "disabled";
		        				}
		        			 ?>
		        			<button id="cartBtn_<?=$workshop['id'];?>" <?php echo $disButton; ?> class="btn btn-success" onclick="addToCart(<?=$workshop['id'];?>, this.id)" role="button">Book Seat</button>
		        		</div>
		        	</div>
		        </p>
		      </div>
		    </div>
		  </div>
		<?php } ?>
		</div>
		<div class="row">
	    	<div class="col-md-12 text-right">
	    		<a href="cart.php" class="btn btn-success">Seats <span class="glyphicon glyphicon-play"></span></a>
	    	</div>
	    </div>
	</div>

	<div style="position: fixed; bottom: 10px; right: 10px; color: green;">
        <strong>
            Durgesh Sahani
        </strong>
    </div>
</body>
<script type="text/javascript">
	function addToCart(wId, btnId) {
		
		$('#loader').show();
		$.ajax({
			url: "action.php",
			data: "wId=" + wId + "&action=add",
			method: "post"
		}).done(function(response) {
			var data = JSON.parse(response);
			$('#loader').hide();
			$('.alert').show();
			if(data.status == 0) {
				$('.alert').addClass('alert-danger');
				$('#result').html(data.msg);
			} else {
				$('.alert').addClass('alert-success');
				$('#result').html(data.msg);
				$('#'+btnId).prop('disabled',true);
				$('#itemCount').text( parseInt( $('#itemCount').text() ) + 1);
			}
			
		})
	}
</script>
</html>