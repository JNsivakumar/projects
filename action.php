<?php
	session_start();
	require 'config.php';

	// Add products into the cart table
	if (isset($_POST['pid'])) {
	   $pid = $_POST['pid'];
	  $pname = $_POST['pname'];
	  $pprice = $_POST['pprice'];
	  $pimage = $_POST['pimage'];
	  $pcode = $_POST['pcode'];
	  $pqty = $_POST['pqty'];
	  $total_price = $pprice * $pqty;


	  $sql = "SELECT * FROM cart where product_id='$pid'";
	  $result = $conn->query($sql);

	  if ($result->num_rows > 0) {
		echo '<div class="alert alert-danger alert-dismissible mt-2">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Item already added to your cart!</strong>
	  </div>';

	  }else{
		$sql = "INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_id) VALUES ('$pname','$pprice','$pimage','$pqty','$total_price','$pid')";       
        // Execute query
        mysqli_query($conn, $sql);


	    echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your cart!</strong>
						</div>';
	  }
	
		
	}





	

?>