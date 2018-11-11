<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add to cart functionality in php and mysql</title>
  <link rel="stylesheet" href="../library/css/bootstrap.min.css">
<style>
  h2, h3 {
    margin-top: 0px;
    padding-top: 0px;
  }
  td {
    border-top: none !important;
  }
</style>
</head>
<body>

  <?php 
    session_start();

    require_once('db/DbConnect.php');
    $db   = new DbConnect();
    $conn = $db->connect();

    require 'classes/customer.class.php';
    $objCustomer = new customer($conn);
    $objCustomer->setId($_SESSION['cid']);
    $customer = $objCustomer->getCustomerById();

    require 'classes/cart.class.php';
    $objCart = new cart($conn);
    $objCart->setCid($customer['id']);
    $cartItems = $objCart->getAllCartItems();
    $cartPrices = $objCart->calculatePrices($cartItems);
    
  ?>

  <div class="container well">
    <center><h2>Book Seats</h2></center>
    <hr>
  <form method="post" action="ccavenue/ccavRequestHandler.php" class="form-horizontal">
    
    <!-- <input type="hidden" name="tid" id="tid" readonly />
    <input type="hidden" name="merchant_id" value=""/>
    <input type="hidden" name="order_id" value=""/>
    <input type="hidden" name="amount" value="10.00"/> -->
    <input type="hidden" name="currency" value="INR"/>
    <input type="hidden" name="redirect_url" value="http://tutorials.lcl/cart/ccavenue/ccavResponseHandler.php"/>
    <input type="hidden" name="cancel_url" value="http://tutorials.lcl/cart/ccavenue/ccavResponseHandler.php"/>
    <input type="hidden" name="language" value="EN"/>

    <div class="row">
      <div class="col-md-7 well">
        <h3>Billing Address</h3>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-user"></span>
            </div>
            <input class="form-control" type="text" id="billing_name" name="billing_name" placeholder="Mr Rakesh" value="<?= $customer['name']; ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-envelope"></span>
            </div>
            <input class="form-control" type="text" id="billing_email" name="billing_email" placeholder="rakesh@gmail.com" value="<?= $customer['email']; ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-earphone"></span>
            </div>
            <input class="form-control" type="text" id="billing_tel" name="billing_tel" placeholder="123456789" value="<?= $customer['mobile']; ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-home"></span>
            </div>
            <input class="form-control" type="text" id="billing_address" name="billing_address" placeholder="11, Abc road" value="<?= $customer['address']; ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-home"></span>
            </div>
            <input class="form-control" type="text" id="billing_city" name="billing_city" placeholder="Pune" value="Pune">
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon addon-diff-color">
                    <span class="glyphicon glyphicon-home"></span>
                </div>
                <input class="form-control" type="text" id="billing_state" name="billing_state" placeholder="MH" value="MH">
              </div>
            </div>
          </div>
          <div class="col-md-5 col-md-offset-2">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon addon-diff-color">
                    <span class="glyphicon glyphicon-map-marker"></span>
                </div>
                <input class="form-control" type="text" id="billing_zip" name="billing_zip" placeholder="10001" value="411027">
              </div>
            </div>
          </div> 
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon addon-diff-color">
                <span class="glyphicon glyphicon-home"></span>
            </div>
            <input class="form-control" type="text" id="billing_country" name="billing_country" placeholder="India" value="India">
          </div>
        </div>
      </div>
      <div class="col-md-4 col-md-offset-1 well">
        <div class="text-right">
          <h3>Your Seats</h3>
          <h4><span class="glyphicon glyphicon-shopping-cart"></span><sup id="itemCount"><?= $cartPrices['itemCount']; ?></sup></h4>
          <table class="table">
            <tbody>
              <?php 
                foreach ($cartItems as $key => $cartItem) { 
               ?>    
                <tr>
                  <td align="right" width="85%">
                    <a href="#"><?= $cartItem['title']; ?></a>
                  </td>
                  <td width="15%">
                    <strong><span>&#x20b9;</span><?= ($cartItem['price']*$cartItem['quantity']); ?></strong>
                  </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <hr style="border: 1px dotted gray;">
          <p>Total: <strong>
              <span>&#x20b9;</span><?= $cartPrices['finalPrice']; ?>
            </strong>
          </p>
        </div>
        <div class="text-right">
          <input type="submit" value="Pay Now" class="btn btn-success btn-block">
        </div>
      </div>
    </div>
  </form>
</div>
<div style="position: fixed; bottom: 10px; right: 10px; color: green;">
    <strong>
        Durgesh Sahani
    </strong>
</div>
</body>
</html>
