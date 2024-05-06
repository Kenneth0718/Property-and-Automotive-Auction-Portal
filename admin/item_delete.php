<?php

//incldue database connection
$servername = "localhost";
$username ="kennethc";
$password = "kenneth0718";
$database = "bid4u_system_db";

$conn = mysqli_connect($servername, $username, $password, $database);


$item_id = $_GET["item_id"];                      // delete user when admin press the delete button from the patient info table
$sql = "DELETE FROM item WHERE item_id  = '$item_id'";
$results = mysqli_query($conn, $sql);

header("Location:itemdisplay.php");


?>