<!DOCTYPE html>
<html>
<head>
	<title>Add to cart functionality in php and mysql</title>
	<link rel="stylesheet" href="../library/css/bootstrap.min.css">
	<script src="../library/js/jquery-3.2.1.min.js"></script>
	<script src="../library/js/bootstrap.js"></script>
</head>
<style type="text/css">
    #itemCount,.glyphicon {
        font-size: 18px;
    }
    .alert, #loader {
        display: none;
    }
</style>
<body>
<div class="container">
    <div class="text-center">
        <h2 style="margin-top: 0px; padding-top: 0; padding-left: 5px; ">Update your seats</h2>
    </div>
    <hr>
    <?php 
        session_start();

        require_once('db/DbConnect.php');
        $db   = new DbConnect();
        $conn = $db->connect();
            
        require 'classes/cart.class.php';
        $objCart = new cart($conn);
        $objCart->setCid($_SESSION['cid']);
        $cartItems = $objCart->getAllCartItems();
        
        $cartCss = 'display: none';
        $emptyCss = 'display: block';
        if (count($cartItems) > 0) {
            $cartCss = 'display: block';
            $emptyCss = 'display: none';
        }
        ?>
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span><sup id="itemCount"><?php echo count($cartItems); ?></sup></a>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class="alert alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <div id="result"></div>
        </div>
        <center><img src="images/loader.gif" id="loader"></center>
    </div>

    <div id="fullCart" class="row" style="<?=$cartCss?>">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Workshop</th>
                    <th>Seats</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total</th>
                    <td>
                        <button id="clearItems" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash"></span> Clear
                        </button>
                    </td>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $subTotal   = 0;
                        $quantity   = 0;
                        $tax        = 10;
                        foreach ($cartItems as $key => $cartItem) {
                          $subTotal += $cartItem['totalAmount'];
                          $quantity += $cartItem['quantity'];
                     ?>
                <tr id="item_<?= $cartItem['id']; ?>">
                    <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="images/<?= $cartItem['image']; ?>" style="width: 72px; height: 72px;"> </a>
                            <div style="padding-left: 10px;" class="media-body">
                                <h4 class="media-heading"><a href="#"><?= $cartItem['title']; ?></a></h4>
                                <p><?= substr( $cartItem['description'], 0, 60) . '...'; ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="col-sm-1 col-md-1" style="text-align: center">
                        <select onchange="updateCart(<?= $cartItem['pid']; ?>, <?= $cartItem['id']; ?>)" class="form-control" id="seat_<?= $cartItem['id']; ?>">
                            <?php 
                                for ($i=1; $i < 11; $i++) { 
                            ?>
                            <option value="<?= $i; ?>" <?php echo ($i == $cartItem['quantity']) ? "selected" : ''; ?>><?= $i; ?></option>
                        <?php } ?>
                        </select>
                        
                    </td>
                    <td class="col-sm-1 col-md-1 text-center">
                        <strong><span style="font-size: 18px;">&#x20b9;</span><span id="price"><?= number_format( $cartItem['price'], 2 ); ?></span>
                        </strong>
                    </td>
                    <td class="col-sm-1 col-md-1 text-center">
                        <strong><span style="font-size: 18px;">&#x20b9;</span><span id="totalPrice_<?= $cartItem['id']; ?>"><?= number_format( $cartItem['totalAmount'], 2 ); ?></span>
                        </strong>
                    </td>
                    <td class="col-sm-1 col-md-1">
                        <button type="button" class="btn btn-danger" onclick="removeItem(<?= $cartItem['id']; ?>)">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button>
                    </td>
                </tr>
            <?php } ?>
                <tr>
                    <td colspan="4" align="right">Subtotal</td>
                    <td class="text-right">
                        <strong><span style="font-size: 18px;">&#x20b9;</span>
                            <span id="subTotal"><?= number_format( $subTotal, 2 ); ?></span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">Taxes</td>
                    <td class="text-right">
                        <strong><span style="font-size: 18px;">&#x20b9;</span>
                            <span id="taxes"><?= number_format( $tax * $quantity, 2 ); ?></span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">Total</td>
                    <td class="text-right">
                        <strong><span style="font-size: 18px;">&#x20b9;</span>
                            <span id="finalPrice"><?= number_format( $subTotal+($tax * $quantity), 2 ); ?></span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        <a href="index.php" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Book workshop
                        </a>
                    </td>
                    <td >
                        <a href="checkout.php" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="emptyCart" class="row" style="<?=$emptyCss?>">
        <div class="col-md-12 text-center">
            <p><strong>Your cart is empty. <a href="index.php">Click here</a> to book your seat.</strong></p>
        </div>
    </div>

    <div style="position: fixed; bottom: 10px; right: 10px; color: green;">
        <strong>
            Durgesh Sahani
        </strong>
    </div>
</body>
<script type="text/javascript">
    function updateCart(pId, cartId) {
        console.log($('#seat_'+cartId).val())
        $('#loader').show();
        $.ajax({
            url: "action.php",
            data: "wId=" + pId + "&action=update&quantity="+$('#seat_'+cartId).val(),
            method: "post"
        }).done(function(response) {
            console.log(response)
            var data = JSON.parse(response);
            $('#loader').hide();
            $('.alert').show();
            if(data.status == 0) {
                $('.alert').addClass('alert-danger');
                $('#result').html(data.msg);
            } else {
                $('.alert').addClass('alert-success');
                $('#result').html(data.msg);
                $('#totalPrice_'+cartId).text( data.data.totalPrice );
                $('#subTotal').text( data.data.subTotal);
                $('#taxes').text( data.data.taxes);
                $('#finalPrice').text( data.data.finalPrice);
            }
        })
    }

    function removeItem(cartId) {
        $('#loader').show();
        $.ajax({
            url: "action.php",
            data: "cartId=" + cartId + "&action=remove",
            method: "post"
        }).done(function(response) {
            console.log(response);
            var data = JSON.parse(response);
            $('#loader').hide();
            $('.alert').show();
            if(data.status == 0) {
                $('.alert').addClass('alert-danger');
                $('#result').html(data.msg);
            } else {
                $('.alert').addClass('alert-success');
                $('#result').html(data.msg);
                $('#item_'+cartId).remove();
                $('#itemCount').text( data.data.itemCount);

                if (data.data.itemCount == 0.00) {
                    $('#fullCart').hide();
                    $('#emptyCart').show();
                } else {
                    $('#subTotal').text( data.data.subTotal);
                    $('#taxes').text( data.data.taxes);
                    $('#finalPrice').text( data.data.finalPrice);
                }
            }
        })
    }

    $('#clearItems').click(function(){
        $('#loader').show();
        $.ajax({
            url: "action.php",
            data: "action=clear",
            method: "post"
        }).done(function(response) {
            console.log(response);
            var data = JSON.parse(response);
            $('#loader').hide();
            $('.alert').show();
            if(data.status == 0) {
                $('.alert').addClass('alert-danger');
                $('#result').html(data.msg);
            } else {
                $('.alert').addClass('alert-success');
                $('#result').html(data.msg);

                $('#itemCount').text( 0 );
                $('#fullCart').hide();
                $('#emptyCart').show();
            }
        })
    })

</script>
</html>