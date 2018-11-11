<?php 
	require_once('db/DbConnect.php');
    $db   = new DbConnect();
    $conn = $db->connect();

    require 'classes/workshopSeat.class.php';
    $objWseat = new workshopSeat($conn);
    $objWseat->settId($_GET['tid']);
	$workshopSeats = $objWseat->getWorkshopSeatsByTid();

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
		 	<caption><strong>Workshop Seats Booked Report</strong></caption>
		 	<thead>
		 		<tr>
		 			<th>#id</th>
		 			<th>Title</th>
		 			<th>Quantity</th>
		 			<th>Amount</th>
		 			<th>Booked By</th>
		 			<th>Booked Date</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		<?php 
		 			foreach ($workshopSeats as $key => $workshopSeat) {
		 		?>
		 		<tr>
		 			<td><?= $workshopSeat['id']; ?></td>
		 			<td><img width="60" height="30" src="images/<?= $workshopSeat['image']; ?>"> <?= $workshopSeat['title']; ?></td>
		 			<td><?= $workshopSeat['quantity']; ?></td>
		 			<td><?= ($workshopSeat['quantity'] * $workshopSeat['price']); ?></td>
		 			<td><?= $workshopSeat['name']; ?></td>
		 			<td><?= $workshopSeat['createdOn']; ?></td>
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