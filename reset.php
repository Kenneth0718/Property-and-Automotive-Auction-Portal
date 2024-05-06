<html>

<head><title></title></head>
<body>
<?php
$servername = "localhost";
$username ="kennethc";
$password = "kenneth0718";
$database = "bid4u_system_db";

$conn = new mysqli( $servername, $username, $password, $database);


if($conn->connect_error)
{
die("Connection failed!".$conn->connect_error);
}

$statement = "DELETE FROM bid";
$conn->query($statement);

$statement = "UPDATE item SET current_bid=0, bid_num=0";
$conn->query($statement);

$conn->close();

?>


</body>
</html>