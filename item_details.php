<html>
<head><title></title>

	 <link rel="stylesheet" type="text/css" href="CSS/display.css?v=2">
	
</head>

	 
 
	
<body>


<?php
 
session_start();



if(!isset($_GET["item_id"]) || !isset($_SESSION["username"]))
{
header("Location:login.php"); 
}


else
{
?>
<header>
<div class="navbar">
  <img class='logo' src ='bid4ulogo.png'/>
  <nav>
  <ul>
    <li><a href="ReviewPage">Home</a></li>
    <li><a href="display_items.php">Products</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="contact.php">Contact</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="#"> Hello <?php echo $_SESSION["username"]?> </a></li>  
  	<li><a href="logout.php" >Logout </a></li>
  </ul>
</nav>
</div>
</header>
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


$statement = "SELECT * FROM item WHERE item_id =?";
$iid = $_GET["item_id"];

$stmt = $conn->prepare($statement);
$stmt->bind_param("s", $iid);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) /*select the data of the specific item from the ITEM table*/
{

$iid = $row["item_id"];
$iname= $row["item_name"];
$i_desc = $row["item_desc"];
$iiprice = $row["init_bid"];
$end = $row["endtime"];
$bid_num = $row["bid_num"];
$icprice = $row["current_bid"];
$ilivestream = $row["item_livestream"];
 ?>

<div class='box'>
  
  <div>
    <div class='item'>	
      <div class='item_name'><?php echo $iname ?></div>
      <div class='item_desc'> <?php echo $i_desc ?></div>
      <div class='item_end'>End Time: <?php echo $end ?></div> 
      <div class='item_ini'>Initial Price: <?php echo $iiprice ?></div>
      <div class='item_current'>Current Bid: <?php echo $icprice ?></div>
    </div>
    
    <div class='bid'>
      <form action='bid.php' method='POST'>
      <input type ='hidden' value="<?php echo $iid; ?>" name='item_id'/>
      <input type ='hidden' value="<?php echo $username; ?>" name='username'>
      <select name='bid'>
    <?php
    for($i=0; $i < 10000; $i++)
    {
     $iiprice = $iiprice + 100;
    echo "<option value='$iiprice'>$$iiprice</option>";
    }
    
    echo "</select>";	
    echo "<input type='submit' value='Bid'>";
    echo "</form>";
    echo "</div>"; 
    ?>
  </div>
    <img class='item_img' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["item_pic"]); ?>">
</div>

<?php 


 
$conn->close(); /*display the item details */ 
}
}/*prevent direct access by user */

	
	?>
</body>
</html>