<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="CSS/cart.css">
    </head>
    <body>
    <script src="JS/display.js"> </script>

<?php

session_start();
if(!isset($_SESSION["username"])) //prevent directly access
{  
    header("Location:adminlogin.php");
}
else
{
?>
<header>
<div class="navbar">
  <img class='logo' src ='bid4ulogo.png'/>
  <nav>
  <ul>
    <li><a href="ReviewPage.php">Testinomial</a></li>
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
$username = $_SESSION["username"];
?>
<div id="shopping-cart">
   <div class="txt-heading">Shopping Cart</div>
   <?php
   if (isset($_POST['checkout'])) {
    $sql = "DELETE FROM item WHERE item_id IN (SELECT item_id FROM bid WHERE username = ? AND item_visible = 'FALSE')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    header("Location: cart.php");
}
}
?>
    <form action="cart.php" method="post">
        <table class="tbl-cart" cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <td style="text-align:left;">Product</td>
                    <td style="text-align:left;">Ending Date</td>
                    <td style="text-align:right;">Price</td>
                </tr>
            <tbody>
                <?php
                    $statement1 = "SELECT item.item_name, item.item_pic, item.endtime, item.item_visible, bid.bid_price FROM item  
                      INNER JOIN bid ON bid.item_id = item.item_id
                        WHERE item.item_visible = 'FALSE' AND bid.username = '$username' ";
                       $result1 = $conn->query($statement1);
                 if ($result1->num_rows < 0)
                { ?>
                <tr>
                    <td class="no-records">You have no item in your Bidding Cart</td>
                </tr>
                <?php
                }
                
                     
                         
                 else
                 {  
                     $statement = "SELECT item.item_name, item.item_pic, item.endtime, item.item_visible, bid.bid_price FROM item  
                 INNER JOIN bid ON bid.item_id = item.item_id
                 WHERE item.item_visible = 'FALSE' 
                  AND bid.username = '$username' ";
                 $result = $conn->query($statement);
                 $totalprice=0;
                 if($result->num_rows > 0){ 
  
                    while($row = $result->fetch_assoc()){ 

                       $totalprice += $row["bid_price"]; 
                    ?>

                <tr>
                    <td class="img">
    
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["item_pic"]);?>"class="cart-item-image" /><?php echo $row["item_name"]; ?>
                    </td>
                 
                    <td><?php echo $row["endtime"];?></td>
  
                    <td style="text-align:right;"><?php echo $row["bid_price"]; ?></td>
                </tr>
                <tr>
                    
                   
                   <?php
                    }
                    ?>
                    
                  <td colspan="2" align="right">Total:</td>
                  <td align="right" colspan="2"><strong>$<?php echo $totalprice; ?></strong></td>
                  <td></td>
               </tr>
               <tr>
                   <td></td>
                   <td align="right" colspan="2"> <input type="submit" value="Checkout" name="checkout"> </td>
                </tr>    
                <?php
                   
                  }
                }  
                ?>
            </tbody>
        </table>
        <hr>
    </form>
</div>


<?php
$conn->close();


?>   
        <script src="" async defer></script>
    </body>
</html>

