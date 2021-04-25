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
</head>

<body>
  
  <div class="container">
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php">&nbsp;&nbsp;Add Product</a>
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
      <div class="col-lg-6 px-4 pb-4" id="product">
      <div id="msgContent"></div>
        <h4 class="text-center text-info p-2">Add Product</h4>        
        <form method="post" action="" enctype="multipart/form-data" id="addProduct">
          <div class="form-group">
            <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" >
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <input type="text" name="shortDescription" id="shortDescription"class="form-control" placeholder="Enter Short Description">
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea name="description" id="description"class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
            </div>
            <div class="form-group">
              <label>Product</label>             
              <input type="file" class="form-control" name="productImage" id="productImage">
          </div>
            <div class="form-group">
              <label>Price</label>
              <input type="price" name="price" id="price" class="form-control" placeholder="Enter price"  onkeypress="return isNumber(event)" >
          </div>
            <div class="form-group">
            <label>Status</label>
              <select id="status" class="form-control" name="status">
                        <option value="">---Select---</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
              </select>
            </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Add" class="btn btn-danger btn-block">
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
    $("#addProduct").submit(function(e) {

      let nameVal = $('#name').val();
      if (nameVal.length == '') {
        alert("Enter the Product name");
        $('#name').focus();
          return false;
      }
      let shortDescriptionVal = $('#shortDescription').val();
      if (shortDescriptionVal.length == '') {
        alert("Enter the short Description");
        $('#shortDescription').focus();
          return false;
      }
      let descriptionVal = $('#description').val();
      if (descriptionVal.length == '') {
        alert("Enter the Description");
        $('#description').focus();
          return false;
      }

      if($('#productImage')[0].files.length === 0){
        alert("Attachment Required");
        $('#productImage').focus();

        return false;
    }
      let priceVal = $('#price').val();
      if (priceVal.length == '') {
        alert("Enter the Price");
        $('#price').focus();
          return false;
      }
      let statusVal = $('#status').val();
      if (statusVal.length == '') {
        alert("Please Select Status");
        $('#status').focus();
          return false;
      }
        var form = $("#addProduct").get(0); 
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form

        $.ajax({
            url: 'saveProduct.php',
            type: 'POST',
            data: new FormData(form),
            dataType: 'json',
            mimeType: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function (response) {
              if(response==1){
                alert("product added successfully");
                window.location.replace("index.php");
              }

            },
            error: function (data) {
              $("#msgContent").html(data);

            }
      });



    });
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