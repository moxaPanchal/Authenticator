<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/
// Try connecting to the database
// $conn means connection
$conn = mysqli_connect("localhost", "root", "", "login");

// Check the connection
if(!$conn){
    echo "Connection Failed";
}

?>