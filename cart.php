<?php
  session_start();
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
    <a class="navbar-brand">&nbsp;&nbsp;Cart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
         <li class="nav-item">
          <a class="nav-link" href="index.php">Back</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><img src="css/cart.png" height="31px"> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
      </ul>
    </div>
  </nav>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
  echo $_SESSION['showAlert'];
} else {
  echo 'none';
} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="cartcount.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                require 'config.php'; 
                $sql = "SELECT * FROM cart";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i=1;
                    while($row = $result->fetch_assoc()) {
              ?>
              <tr>
                <td><?php echo $row['id'] ?></td>
                <input type="hidden" class="pid" value="<?php echo $row['id'] ?>">
                <td><img src="<?php echo $row['product_image'] ?>" width="50"></td>
                <td><?php echo $row['product_name'] ?></td>
                <td>
                  Rs. &nbsp;&nbsp;<?php echo number_format($row['product_price'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?php echo $row['product_price'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?php echo $row['qty'] ?>" style="width:75px;">
                </td>
                <td>Rs. &nbsp;&nbsp;<?php echo number_format($row['total_price'],2); ?></td>
                <td>
                  <a href="cartcount.php?remove=<?php echo $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['total_price']; ?>
              <?php }
            $i++;
            } ?>
              <tr>
                <td colspan="3">
                  <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b>Rs. &nbsp;&nbsp;<?php echo number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkout.php" class="btn btn-info <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='js/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'cartcount.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
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
  </script>
</body>

</html>