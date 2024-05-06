<html>
<head><title></title>

	 <link rel="stylesheet" type="text/css" href="style.css">
</head> 
<body>
	
<?php

if(!empty($_POST["item_name"]))
{
	$servername = "localhost";
	$username ="kenenthc";
	$password = "kenneth0718";
	$database = "bid4u_system_db";
	
	$conn = new mysqli( $servername, $username, $password, $database);


if($conn->connect_error)
{
die("Connection failed!".$conn->connect_error);
}

 

$item_name = $_POST["item_name"];




$statement = "SELECT * FROM item WHERE item_name=?";

$stmt = $conn->prepare($statement);
$stmt->bind_param("s", $item_name);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows<=0)
{
$value = "no_item";
	
header("Location:delete_item.php?item=$value");
}

else
{
	

$statement = "DELETE FROM item WHERE item_name=?";
$stmt = $conn->prepare($statement);
$stmt->bind_param("s", $item_name);
$stmt->execute();

$value = "successful";
	
header("Location:delete_item.php?item=$value");

} /*check if such an item even exists */
 

$conn->close();
} /*if statement blocking direct access*/

else
{	
header("Location:delete_item.php");
} /*verify did the user access from the appropriate place */
?>
</body>
</html>

