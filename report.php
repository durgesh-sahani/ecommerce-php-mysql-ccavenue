<?php 
	require_once('db/DbConnect.php');
    $db   = new DbConnect();
    $conn = $db->connect();

    require 'classes/transaction.class.php';
    $objTrans = new transaction($conn);
	$transactions = $objTrans->getTransactions();

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add to cart functionality in php and mysql</title>
  <link rel="stylesheet" href="../library/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<table class="table table-striped">
		 	<caption><strong>Workshop Booked</strong></caption>
		 	<thead>
		 		<tr>
		 			<th>#id</th>
		 			<th>Customer</th>
		 			<th>Quantity</th>
		 			<th>Amount</th>
		 			<th>Status</th>
		 			<th>Booked Date</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		<?php 
		 			foreach ($transactions as $key => $transaction) {
		 		?>
		 		<tr>
		 			<td><?= $transaction['id']; ?></td>
		 			<td><?= $transaction['name']; ?></td>
		 			<td><a href="reportDetails.php?tid=<?= $transaction['id']; ?>"><?= $transaction['quantity']; ?></a></td>
		 			<td><?= $transaction['amount']; ?></td>
		 			<td><?= $objTrans->getOrderStatusById($transaction['orderStatus']); ?></td>
		 			<td><?= $transaction['createdOn']; ?></td>
		 		</tr>
		 	<?php } ?>
		 	</tbody>
		</table>
	</div>
	<div style="position: fixed; bottom: 10px; right: 10px; color: green;">
	    <strong>
	        Durgesh Sahani
	    </strong>
	</div>
</body>
</html>