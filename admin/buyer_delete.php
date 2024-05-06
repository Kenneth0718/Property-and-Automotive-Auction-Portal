<?php

//incldue database connection
$servername = "localhost";
$username ="kennethc";
$password = "kenneth0718";
$database = "bid4u_system_db";

$conn = mysqli_connect($servername, $username, $password, $database);


$buyer_id = $_GET["buyer_id"];                      // delete user when admin press the delete button from the patient info table
$sql = "DELETE FROM buyer WHERE buyer_id  = '$buyer_id'";
$results = mysqli_query($conn, $sql);

header("Location:userdisplay.php");


?>