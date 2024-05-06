<?php
$servername = "localhost";      // connection to database
$username ="kennethc";
$password = "kenneth0718";
$database = "bid4u_system_db";
       
$conn = mysqli_connect($servername, $username, $password, $database);

$item_id = $_GET["item_id"];        // get parent_id from display.php table
$item_name = "";
$item_desc = "";
$init_bid = "";
$endtime = "";
$current_bid = "";
$item_livestream = "";

$sql = "SELECT item_id, item_name, item_desc, init_bid, endtime, current_bid, item_livestream FROM item WHERE item_id='$item_id'";
$results = mysqli_query($conn,$sql);   // execute the query to retrive data
while($row = mysqli_fetch_array($results))
{   
    $item_id = $row["item_id"];
    $item_name = $row["item_name"];
    $item_desc = $row["item_desc"];
    $init_bid = $row["init_bid"];
    $endtime = $row["endtime"];
    $current_bid = $row["current_bid"];
    $item_livestream = $row["item_livestream"];
}


?>
    
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="CSS/display.css">
    </head>
    <body>
    <?php
        session_start();

        if(!isset($_SESSION["username"])) // prevent directly access from user
        {  
            header("Location:adminlogin.php");
            $_SESSION["username"] = $_POST["username"];
        }
        else
        {
       ?>
       <div class="wrapper">
      <input type="checkbox" id="btn" hidden>
      <label for="btn" class="menu-btn">
        <i class="fas fa-bars"></i>
        <i class="fas fa-times"></i>
      </label>
      <nav id="sidebar">
        <div class="title">Side Menu</div>
        <ul class="list-items">
          <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
          <li><a href="add_item.php"><i class="fas fa-sliders-h"></i>Add Item</a></li>
          <li><a href="itemdisplay.php"><i class="fas fa-home"></i>Item</a></li>
          <li><a href="userdisplay.php"><i class="fas fa-sliders-h"></i> User</a></li>
        </ul>
      </nav>
    </div>
    <header>
       <div class="navbar">
          <nav class="navbar_a">
              <ul>  
                   <li><h2>Welcome!!!<?php echo $_SESSION["username"]?></h2></li>               
	               <li><h2><a href="adminlogout.php" >Logout </a></h2></li>
              </ul>
         </nav>
       </div>
      </header>

        <div class="table2">  
         <form action="item_edit.php" class=addpatient_form method="POST">

            <h2>  Item Info </h2>
            <table> 
                
                <tr>
                    <td> Item ID: </td>
                    <td> <input type="text" name ="item_id" readonly value=<?php echo $item_id ?> > 
                    </td>
                </tr>

                <tr>
                    <td> Name: </td>
                    <td> <input type="text" name ="item_name" value=<?php echo $item_name ?> > 
                    </td>
                </tr>
  
                <br>
     
                <tr>
                    <td> Description: </td>
                    <td> 
                        <input type="text" name ="item_desc" value=<?php echo $item_desc ?> >  
                      
                    </td>
                </tr>
     
                <br>
 
                    
                <tr>
                    <td> Initial Bid: </td>
                    <td> <input type="text" name="init_bid" value=<?php echo $init_bid?> > 
                    </td>
                </tr>
 
                <br>
   
               <br>
                <tr>
                    <td> Ending Bid Time: </td>  
                    <td> <input type="datetime-local" name="endtime"  value=<?php echo $endtime ?>> 
                    </td>
                </tr>
      
                <br>
                       
                <tr>
                    <td> Current Bid: </td>  
                    <td> <input type="text" name="current_bid"  readonly value=<?php echo $current_bid ?>>
                    </td>
                </tr>
 
                <br>
         
                <tr>
                    <td> Livestream: </td>  
                    <td> <input type="text" name="item_livestream"  value=<?php echo $item_livestream ?>> 
                    </td>
                </tr>
              
                
            </table>
            <div class="input-box button">
            <input type="submit" name="update" value="Update">
            </form>
           </div>
            <br>
        <?php
        }
        ?>
        <script src="" async defer></script>
    </body>
</html>
<?php
if(isset($_POST["update"]))    // change the data
{
    $item_id = $_POST["item_id"];
    $item_name = $_POST["item_name"];
    $item_desc = $_POST["item_desc"];
    $init_bid = $_POST["init_bid"];    
    $endtime = $_POST["endtime"];    
    $current_bid = $_POST["current_bid"];
    $item_livestream = $_POST["item_livestream"];

    $sql = "UPDATE item SET item_name = '$item_name', item_desc = '$item_desc',init_bid = '$init_bid', endtime = '$endtime', item_livestream = '$item_livestream' WHERE item_id = '$item_id'";  

    $results = mysqli_query($conn, $sql);

    if($results)
    {   
        echo '<script type ="text/JavaScript">';
        echo 'alert("Item Updated Sucessful!!!")';
        echo '</script>';

        header("Location: itemdisplay.php");

    }
    else 
    {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Item Not Updated Sucessful!!!")';
        echo '</script>';
        header("Location: item_edit.php?item_id= $item_id");
    }


}
?>