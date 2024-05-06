<html>
<head><title></title>

	 <link rel="stylesheet" type="text/css" href="CSS/style.css">

	 </head>
<body>

<?php


echo "<img id='logo' src ='bid4ulogo.png'/>";
echo "<br>";
echo "<form class='delete_item_form' action='check_delete_item.php' method='POST'>";
	if(isset($_GET["item"]))
	{

	if($_GET["item"]=="no_item")
	{
		echo "<h4>No such item exists</h4>";
		echo "<br>";
		echo "<h4>Please try again</h4>";
 
	}

	else if($_GET["item"]=="successful")
	{
	echo "<h4>Successfully deleted the item!</h4>";
	} 


	}
 
	else
	{
	echo "<h4>To Delete An Item, Please Enter The Item Name</h4>";
	}
	

echo "<label for='item_name' class='label'>Item Name: </label> <input class='text' type='text' name='item_name' placeholder='Item name'>";
echo "<input class='submit' type='submit' value='Delete Item'/>";	
echo "</form>";

?>
</body>
</html>


