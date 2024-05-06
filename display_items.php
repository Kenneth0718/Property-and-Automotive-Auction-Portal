<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/display.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript">
        function showPopup(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                    <li><a href="ReviewPage.php">Testimonial</a></li>
                    <li><a href="display_items.php">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="#"> Hello <?php echo $_SESSION["username"]?> </a></li>  
                    <li><a href="logout.php" >Logout </a></li>
                </ul>
            </nav>
        </div>
        <div class="container mt-4">
            <form method="get">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search by item name">
                    </div>
                    <div class="col-md-6">
                        <select name="filter" class="form-control">
                            <option value="">Filter by bid amount</option>
                            <option value="low_to_high">Low to High</option>
                            <option value="high_to_low">High to Low</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Search & Filter</button>
            </form>
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

        $statement = "SELECT item_id, item_name, item_desc, item_pic, current_bid , item_livestream FROM item WHERE item_visible = 'TRUE' ";
        $result = $conn->query($statement);

        $statement1 = "SELECT item_id, item_name, item_desc, item_pic, current_bid , item_livestream FROM item WHERE item_visible = 'FALSE' ";
        $result1 = $conn->query($statement1);
    ?>
    <div class="Items-container row">
    <?php 
    if (isset($_GET['search']) || isset($_GET['filter'])) {
        // If search or filter options are set, show the relevant items based on the criteria
        $search_query = isset($_GET['search']) ? $_GET['search'] : '';
        $filter_option = isset($_GET['filter']) ? $_GET['filter'] : '';

        // Use prepared statements to prevent SQL injection
        $statement = "SELECT item_id, item_name, item_desc, item_pic, current_bid , item_livestream FROM item WHERE item_visible = 'TRUE' ";
        if (!empty($search_query)) {
            $search_query = "%" . $search_query . "%";
            $statement .= " AND (item_id LIKE ? OR item_name LIKE ?)";
        }

        if (!empty($filter_option)) {
            if ($filter_option == "low_to_high") {
                $statement .= " ORDER BY current_bid ASC";
            } elseif ($filter_option == "high_to_low") {
                $statement .= " ORDER BY current_bid DESC";
            }
        }

        $stmt = $conn->prepare($statement);
        if (!empty($search_query)) {
            $stmt->bind_param("ss", $search_query, $search_query);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {  
                $iid = $row["item_id"];
                $iname = $row["item_name"];
                $idesc = $row["item_desc"];
                $ipic = $row["item_pic"];
                $icurrentp = $row["current_bid"];
                $ilivestream = $row["item_livestream"];
                $streaminglink = "livestream.php?item_id=";
                $livestream = $streaminglink.$iid;  
                $link = "item_details.php?item_id=";
                $item_details = $link.$iid;
                ?>
                <div class="col-xs-12 col-md-6">
                    <!-- Product container -->
                    <div class="prod-info-main prod-wrap clearfix">
                        <div class="row">
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="product-image"> 
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["item_pic"]); ?>" class="img-responsive"> 
                                    <span class="tag2 hot">
                                    HOT
                                    </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="product-deatil">
                                <h5 class="name">
                                    <a href="">
                                    <?php echo $row["item_id"] ?>/<?php echo $row["item_name"] ?>
                                    </a>                            
                                </h5>
                                <p class="price-container">
                                    <span> $<?php echo $row["current_bid"] ?> </span>
                                </p>
                                <span class="tag1"></span> 
                            </div>
                            <div class="description">
                                <p><?php echo $row["item_desc"]; ?></p>
                            </div>
                            <div class="product-info smart-form">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <a href="<?php echo $item_details ?>" class="btn btn-info">More info</a>
                                        <a href="<?php echo $livestream ?>" class="btn btn-info">Livestream</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end product -->
                    </div>
                </div>
                </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='status error'>No Items available to Bid now, Stay Tuned for the Update...</p>";
        }
    } else {
        // If search or filter options are not set, show all visible items
        $result = $conn->query($statement);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {  
                $iid = $row["item_id"];
                $iname = $row["item_name"];
                $idesc = $row["item_desc"];
                $ipic = $row["item_pic"];
                $icurrentp = $row["current_bid"];
                $ilivestream = $row["item_livestream"];
                $streaminglink = "livestream.php?item_id=";
                $livestream = $streaminglink.$iid;  
                $link = "item_details.php?item_id=";
                $item_details = $link.$iid;
                ?>
                <div class="col-xs-12 col-md-6">
                    <!-- Product container -->
                    <div class="prod-info-main prod-wrap clearfix">
                        <div class="row">
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="product-image"> 
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["item_pic"]); ?>" class="img-responsive"> 
                                    <span class="tag2 hot">
                                        HOT
                                    </span> 
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="product-deatil">
                                    <h5 class="name">
                                        <a href="">
                                        <?php echo $row["item_id"] ?>/<?php echo $row["item_name"] ?>
                                        </a>                            
                                    </h5>
                                    <p class="price-container">
                                        <span> $<?php echo $row["current_bid"] ?> </span>
                                    </p>
                                    <span class="tag1"></span> 
                                </div>
                                <div class="description">
                                    <p><?php echo $row["item_desc"]; ?></p>
                                </div>
                                <div class="product-info smart-form">
                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <a href="<?php echo $item_details ?>" class="btn btn-info">More info</a>
                                            <a href="<?php echo $livestream ?>" class="btn btn-info">Livestream</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end product -->
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='status error'>No Items available to Bid now, Stay Tuned for the Update...</p>";
        }
    }

    $result->close();
    $statement = "SELECT * FROM bid WHERE item_id=?";
    $stmt = $conn->prepare($statement);
    $stmt->bind_param("s", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc())
    {
        if($_SESSION["username"] ==  $row["username"])
        {
            $statement = "SELECT * FROM item WHERE item_id = '$iid'";
            $result = $conn->query($statement);
            $row = $result->fetch_assoc();
            $endtime = $row["endtime"];

            date_default_timezone_set("Asia/Kuala_Lumpur");
            $currentDateTime = date('Y-m-d H:i:s');
            $strcurrenttime = strtotime($currentDateTime);
            $strsettime = strtotime($endtime);
            if($strcurrenttime > $strsettime)
            {
                $sql = "UPDATE item SET item_visible ='FALSE' WHERE item_id = '$iid'";
                $results = mysqli_query($conn, $sql);
            }
        }
    }

    $conn->close();  
    }

    ?>
    </div>
</body>
</html>