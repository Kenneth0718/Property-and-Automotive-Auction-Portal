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
        <link rel="stylesheet" type="text/css" href="CSS/display.css">
    </head>
    <body>
    <?php
        session_start();

        if(!isset($_SESSION["username"])) //prevent directly access
        {  
            header("Location:adminlogin.php");
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
          <li> 
              <form action="itemdisplay.php" class="fas fa-stream" method="POST">
              <label for="id" class="id"> ID to search: </label><br>
              <input type="text" name="keyword" placeholder="ID or item name"id="patient_id"><br>
              <input type="submit" class="btn btn-white btn-animate" name="search" value="search">
              </form> 
         </li>
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
        <div class="my-wrapper">
        <h1>Item Information </h1>
        <br>
        <div class="my-scroller">
        <table class="table-container">
    
        <thead>
          <tr>
               <th class="my-sticky-col"> ID </th>
               <th> Item Name </th>
               <th> Description </th>
               <th> Initial Bid </th>
               <th> EndTime </th>
               <th> Number of Bid </th>
               <th> Current Bid </th>
               <th> Livestream Link </th>
               <th> Item Visible</th>
               <th></th>
          </tr>
         <thead>
          <?php
         //incldue database connection
         $servername = "localhost";
         $username ="kennethc";
         $password = "kenneth0718";
         $database = "bid4u_system_db";
       
         $conn = mysqli_connect($servername, $username, $password, $database);



            if(isset($_POST["search"]))
            {
              $is_keyword = $_POST["keyword"];
             $sql = "SELECT item_id, item_name, item_desc, init_bid, endtime, bid_num, current_bid, item_livestream, item_visible FROM item WHERE item_id='$is_keyword ' OR  item_name = '$is_keyword'";
                
            }
            else
            {
             //write query to retrieve data
              $sql = "SELECT item_id, item_name, item_desc, init_bid, endtime, bid_num, current_bid, item_livestream, item_visible FROM item";
            }
        
         //execute the query to retrive data
         $results = mysqli_query($conn,$sql);   
         //check whether there is results
         if(mysqli_num_rows($results) > 0)
         {
         //fetch data of each row
            echo"<tbody>";
 
                 while($row = mysqli_fetch_array($results))
                 {  
                  //display the data of each row
                
                  echo "<tr><td>".$row["item_id"]."</td><td>". $row["item_name"]."</td><td>".$row["item_desc"]."</td><td>".$row["init_bid"]."</td><td>".$row["endtime"]."</td><td>".$row["bid_num"]."</td><td>".$row["current_bid"]."</td><td>".$row["item_livestream"]."</td><td>".$row["item_visible"];
                  echo"<td>"; ?> <a href="item_edit.php?item_id=<?php echo $row["item_id"]; ?>"><button type="button"  name='edit' value="Edit" >Edit</button></a> 
                                 <a href="item_delete.php?item_id=<?php echo $row["item_id"]; ?>"><button type='submit' name='delete' value='Delete'> Delete</button></a> <?php echo"</td>";
                  echo"</tr>";
                  }

            echo"</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</div>";
                            
         }          
             
                
         else
         {
             echo " No results.";
         } 




            $conn-> close();
        }  
          ?>
        <script src="" async defer></script>
    </body>
</html>