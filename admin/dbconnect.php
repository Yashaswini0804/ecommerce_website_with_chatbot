<?php
    $hostname="localhost";
    $db_username="root";
    $db_password="";
    $db_name="ecommerce_db";
    $conn = mysqli_connect($hostname,$db_username,$db_password,$db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 ?>