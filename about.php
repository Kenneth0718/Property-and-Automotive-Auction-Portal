<html>
<head><title>Auction System</title>


    <link rel="stylesheet" type="text/css" href="CSS/about.css">
    
</head>
<body>
<script src="JS/display.js"> </script>
<?php 

session_start();

if(!isset($_SESSION["username"]))
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
<div class="table-bkground"> 
<div class="table">
<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <h3><i class="glyphicon glyphicon-thumbs-up"></i>The purpose of this project is to establish an "Online Auction System", a store for buyers and stores to be contacted almost anywhere.<br><br><i class="glyphicon glyphicon-thumbs-up"></i>Users do not need to register to view the functions of this website, but users who can bid and sell must register.<br><br>
                        <i class="glyphicon glyphicon-thumbs-up"></i>The auction has a name, a description, possibly a photo uploaded by the user (of the related item), and an end time: when the auction interval ends, the user cannot bid, but if there is no item for which the offer is offered, it may be suspended.<br>
                        <br> <i class="glyphicon glyphicon-thumbs-up"></i>In addition, the administrator can accept or reject auctions proposed by users, view information about users and items, and create, modify, and delete auction categories (for mobile phones, and computers).</h3>
                </div>
            </div>
        </div>
    </div>
<?php
}    
?>
</body>
</html>