<?php
	session_start();
	require 'config.php';


	// Get no.of items available in the cart table
	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	 $sql = "SELECT * FROM cart";
	  $result = $conn->query($sql);

	  $rows =$result->num_rows;

	  echo $rows;
	}

	// Remove single items from cart
	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];
	  $dsql = "DELETE FROM cart WHERE id=$id";
      mysqli_query($conn, $dsql);

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}

	// Remove all items at once from cart
	if (isset($_GET['clear'])) {
		$dsql = "DELETE FROM cart";
		mysqli_query($conn, $dsql);
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}

	// Set total price of the product in the cart table
	if (isset($_POST['qty'])) {
	  $qty = $_POST['qty'];
	  $pid = $_POST['pid'];
	  $pprice = $_POST['pprice'];
	  $tprice = $qty * $pprice;
	  $sql = "UPDATE cart SET qty=$qty, total_price=$tprice WHERE id=$pid'";
      mysqli_query($conn, $sql);
	}
?>