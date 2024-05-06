<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Add Item Form </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="CSS/display.css">
    </head>
    <body>
    <?php
        session_start();

        if(!isset($_SESSION["username"]))  // prevent directly access
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
                   <li><h2><?php echo $_SESSION["username"]?> Admin</h2></li>               
	               <li><h2><a href="adminlogout.php" >Logout </a></h2></li>
              </ul>
         </nav>
       </div>
      </header>
        
        <div class="table2">  
         <form class='add_item_form' action='add_item.php' method='POST'  enctype='multipart/form-data'>
           <fieldset>
            <legend> Add Item Form </legend>
            <table> 
                 <?php                                             
                             if(isset($_GET["item"]))
                             {
                             
                             if($_GET["item"]=="duplicate")
                             {
                                 echo "<h4>Already entered this item</h4>";
                                 echo "<br>";
                                 echo "<h4>Please try again</h4>";
                              
                             }
                             
                             else if($_GET["item"]=="successful")
                             {
                             echo "<h4>Successfully added an item!</h4>";
                             } 
                             
                             }
                              
                             else
                             {
                             echo "<h4>Please add an item</h4>";
                             }  
                 ?>
                 <tr>
                      <td><label for='item_name' class='label'>Item Name:</label></td>
                      <td> <input class='text'  type='text' name='item_name' required/></td>
                 </tr>

                  <br>

                  <tr>
                       <td><label for='item_description'  class='label'>Item Description:</label></td>
                       <td><input class='text'  type='text' name='item_description' required></td>
                  </tr>

                  <br>
                    
                  <tr>
                       <td><label for='init_bid'  class='label'> Initial Bid: </label></td>
                       <td> <input class='text'  type='text' name='init_bid' required></td>        
                  </tr>

                  <br>

	              <tr>
                       <td><label for='endtime'  class='label'> Ending Bid Time: </label></td>
                       <td> <input class='text'  type='datetime-local' name='endtime' required></td>        
                  </tr>
        
                  <br>

	              <tr>
                       <td><label for='item_pic'  class='label'> Item Picture: </label></td>
                       <td><input class='text'  type='file' value='item_pic' name='item_pic' id="item_pic" required></td>
                  </tr>
 
                  <br>

                  <tr>
                       <td><label for='item_livestream'  class='label'> Livestream Hyperlink(Optional): </label></td>
                       <td><input class='text'  type='text' name='item_livestream' id="item_livestream" ></td>
                  </tr>
  
           </table>
           <br>
           <br>
           <input class='submit' type='submit' name="insert" id="insert" value='Add Item'/>
          </fieldset>
         </form>
        <?php
        }
        ?>
</body>
</html>
<?php

if(isset($_POST["insert"]))
{

if(!empty($_POST["item_name"]) && !empty($_POST["item_description"]) && !empty($_POST["init_bid"]) && !empty($_POST["endtime"]) && !empty($_FILES["item_pic"]["name"]) && !empty($_POST["item_livestream"]))
{
    $servername = "localhost";
    $username ="kennethc";
    $password = "kenneth0718";
    $database = "bid4u_system_db";
    
    $conn = new mysqli( $servername, $username, $password, $database);

if($conn->connect_error)
{
die("Connection failed!".$conn->connect_error);
}

  
$iname = mysqli_real_escape_string($conn, $_POST["item_name"]);
$idesc = mysqli_real_escape_string($conn, $_POST["item_description"]);
$init_bid = $_POST["init_bid"];
$iipic = $_FILES["item_pic"]["name"]; 
$endtime = $_POST["endtime"];
$ilivestream = $_POST["item_livestream"];


$statement = "SELECT * FROM item WHERE item_name=?";
$stmt = $conn->prepare($statement);
$stmt->bind_param("s", $iname);
$stmt->execute();
$result = $stmt->get_result();
/*grab from table all see if there is an item of same name*/
if($result->num_rows>=1)
{
$value = "duplicate";
$conn->close();
header("Location:add_item.php?item=$value");
}

else
{  
  if(!empty($_FILES["item_pic"]["name"])) 
  { 
    // Get file info 
    $fileName = basename($_FILES["item_pic"]["name"]); 
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
     
    // Allow certain file formats 
    $allowTypes = array('jpg','png','jpeg','jfif','gif'); 
    if(in_array($fileType, $allowTypes))
    { 
        $image = $_FILES['item_pic']['tmp_name']; 
        $imgContent = addslashes(file_get_contents($image)); 
     
        // Insert image content into database 
        $insert = $conn->query("INSERT into item (item_name, item_desc, init_bid, item_pic ,endtime, item_livestream, item_visible) VALUES ('$iname', '$idesc', '$init_bid', '$imgContent', '$endtime' , '$ilivestream', 'TRUE')"); 
         
        if($insert)
        { 
            $status = 'success'; 
            $statusMsg = "Item uploaded successfully."; 
            // echo '<script type ="text/JavaScript">';
            // echo 'alert("Item uploaded successfully!!!")';
            // echo '</script>';
        }
        else
        { 
            $statusMsg = "Item upload failed, please try again."; 
            // echo '<script type ="text/JavaScript">';
            // echo 'alert("Item upload failed, please try again.")';
            // echo '</script>';           
        }  
    }
    else
    { 
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
    } 
  }/*insert into table if item name not duplicate */
  else
  { 
    $statusMsg = 'Please select an image file to upload.'; 
  } 
 echo $statusMsg;
}

}
else
{
header("Location:add_item.php");
}/*verify user not directly accessing */
}

 

?>