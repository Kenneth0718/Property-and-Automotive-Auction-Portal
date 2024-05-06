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
        <link rel="stylesheet" type="text/css" href="CSS/livestream.css">
    </head>
    <body>
        <?php
         session_start();

         if(!isset($_SESSION["username"]))
         {
            header("Location:display_items.php"); 
         }
         else
         { 
           ?>   
           <header>
<div class="navbar">
  <img class='logo' src ='bid4ulogo.png'/>
  <nav>
  <ul>
    <li><a href="">Home</a></li>
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
            $row = $result->fetch_assoc();  /*select the data of the specific item from the ITEM table*/
            $item_id = $row["item_id"];
            $ilivestream = $row["item_livestream"];
            $iname= $row["item_name"];
            $i_desc = $row["item_desc"];
            $iiprice = $row["init_bid"];
            $end = $row["endtime"];
            $bid_num = $row["bid_num"];
            $icprice = $row["current_bid"];
            $ilivestream = $row["item_livestream"];
            ?>
            <iframe width="1520" height="553" src="<?php echo $ilivestream ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div class='item'>	
            <div class='item_row'>Item Id: <?php echo $iid ?></div>
            <div class='item_row'>Item Name: <?php echo $iname ?></div>
            <img class='item_img' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["item_pic"]); ?>">
            <div class='item_row'>Item Description: <?php echo $i_desc ?></div>
            <div class='item_row'>End Time: <?php echo $end ?></div>
            <div class='item_row'>Number Of Bids:<?php echo $bid_num ?></div>
            <div class='item_row'>Initial Price: <?php echo $iiprice ?></div>
            <div class='item_row'>Current Bid: <?php echo $icprice ?></div>
            <form action='bid.php' method='POST'>
            <input type='hidden' value="<?php echo $iid; ?>" name='item_id'/>
            <input type='hidden' value="<?php echo $username; ?>" name='username'>
            <select name='bid'>
            <form action='bid.php' method='POST'>
            <input type='hidden' value="<?php echo $iid; ?>" name='item_id'/>
            <input type='hidden' value="<?php echo $username; ?>" name='username'>
            <select name='bid'>   
<?php
for($i=0; $i < 10; $i++)
{
 $iiprice = $iiprice + 100;
echo "<option value='$iiprice'>$$iiprice</option>";
}
echo "</select>";	
echo "<input type='submit' value='Bid'>";
echo "</form>";
echo "</div>"; 

$conn-> close();
        
      }
        ?>          
        <script src="" async defer></script>
    </body>
</html>