<?php
	$conn = new mysqli("localhost","root","zaq12345","product");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>