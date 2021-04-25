<?php
	session_start();
	require 'config.php';



	// Checkout and save customer info in the orders table
	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = $_POST['name'];
	  $email = $_POST['email'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $grand_total = $_POST['grand_total'];
	  $address = $_POST['address'];
	  $pmode = $_POST['pmode'];

	  $data = '';


      $sql = "INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid) VALUES ('$name','$email','$phone','$address','$pmode','$products','$grand_total')";
      mysqli_query($conn, $sql);

      $dsql = "DELETE FROM cart";
      mysqli_query($conn, $dsql);

	  $data .= '<div class="text-center">
					<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
					<h2 class="text-success">Your Order Placed Successfully!</h2>
					<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
					<h4>Your Name : ' . $name . '</h4>
					<h4>Your E-mail : ' . $email . '</h4>
					<h4>Your Phone : ' . $phone . '</h4>
					<h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
					<h4>Payment Mode : ' . $pmode . '</h4>
				</div>';
	  echo $data;
	}
?>