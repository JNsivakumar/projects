<!DOCTYPE html>
<html>

<head>
  <title>Ecommerce website</title>
  <link rel='stylesheet' href='css/bootstrap.min.css' />


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <link rel='stylesheet' href='css/all.min.css' />
</head>

<body>
  <div class="container">
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php">&nbsp;&nbsp;Products</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
         <li class="nav-item">
          <a class="nav-link" href="add.php">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><img src="css/cart.png" height="31px"> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
      </ul>
    </div>
  </nav>
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include 'config.php';
        $sql = "SELECT * FROM product where status='active'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {

  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="<?php echo $row['product_image'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?php echo $row['product_name'] ?></h4>
              <h4 class="card-title text-center"><?php echo $row['short_description'] ?></h4>
              <h5 class="card-text text-center text-danger"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?php echo number_format($row['product_price'],2) ?>/-</h5>

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="<?php echo $row['product_qty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?php echo $row['id'] ?>">
                <input type="hidden" class="pname" value="<?php echo $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?php echo $row['product_price'] ?>">
                <input type="hidden" class="pimage" value="<?php echo $row['product_image'] ?>">
                <input type="hidden" class="pcode" value="<?php echo $row['product_code'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php }} ?>
    </div>
  </div>
  <!-- Displaying Products End -->

  <script src='js/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server
    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();

      var pqty = $form.find(".pqty").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pname: pname,
          pprice: pprice,
          pqty: pqty,
          pimage: pimage,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
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