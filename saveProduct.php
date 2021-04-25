<?php
	
	require 'config.php';

    $filename = $_FILES["productImage"]["name"];
    $tempname = $_FILES["productImage"]["tmp_name"];  
    $folder = "image/".$filename;
    $name = $_POST['name'];
    $shortDescription = $_POST['shortDescription'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];  
    
        // Get all the submitted data from the form
        $sql = "INSERT INTO product (product_name,short_description,description,product_price,product_image,status) VALUES ('$name','$shortDescription','$description','$price','$folder','$status')";
       
        // Execute query
        mysqli_query($conn, $sql);
          
        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($tempname, $folder))  {
            $msg = 1;
        }else{
            $msg = "Failed to upload image";
      }
 
	  echo $msg;
	
?>