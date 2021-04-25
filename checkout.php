<?php
	require 'config.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Ecommerce website</title>
  <link rel='stylesheet' href='css/bootstrap.min.css' />
  <link rel='stylesheet' href='css/all.min.css' />

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>
  
  <div class="container">
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php">&nbsp;&nbsp;Checkout</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
         <li class="nav-item">
          <a class="nav-link" href="index.php">Back</a>
        </li>
        
      </ul>
    </div>
  </nav>
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Complete your order!</h4>

        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
          <label>Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
          <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
          <label>Phone</label>
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter Phone" onkeypress="return isNumber(event)">
          </div>
          <div class="form-group">
          <label>Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead">Select Payment Mode</h6>
          <div class="form-group">
            <select name="pmode" id="pmode" class="form-control">
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod">Cash On Delivery</option>
              <option value="netbanking">Net Banking</option>
              <option value="cards">Debit/Credit Card</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='js/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script type="text/javascript">
  $(document).ready(function() {

    


    // Sending Form data to the server
    $("#placeOrder").submit(function(e) {
      let nameVal = $('#name').val();
      if (nameVal.length == '') {
        alert("Enter the name");
        $('#name').focus();
          return false;
      }
      let emailVal = $('#email').val();
      if (emailVal.length == '') {
        alert("Enter the email");
        $('#email').focus();
          return false;
      }
      let phoneVal = $('#phone').val();
      if (phoneVal.length == '') {
        alert("Enter the phone");
        $('#phone').focus();
          return false;
      }


      let addressVal = $('#address').val();
      if (addressVal.length == '') {
        alert("Enter the address");
        $('#address').focus();
          return false;
      }
      let pmodeVal = $('#pmode').val();
      if (pmodeVal.length == '') {
        alert("Please Select Payment Mode");
        $('#pmode').focus();
          return false;
      }
      e.preventDefault();
      $.ajax({
        url: 'saveOrder.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'cartcount.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });


  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
  </script>
</body>

</html>