<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="CSS/display.css">
    <script type="text/javascript">
        function showPopup(message) {
            alert(message);
        }
    </script>
</head>
<body>
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
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <?php
    $servername = "localhost";
    $username ="kennethc";
    $password = "kenneth0718";
    $database = "bid4u_system_db";
    
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed!" . $conn->connect_error);
    }

    if (!isset($_POST["item_id"])) {
        header("Location: display_items.php");
    } else {
        session_start();
        $item_id = $_POST["item_id"];
        $statement = "SELECT * FROM bid WHERE item_id=?";
        $stmt = $conn->prepare($statement);
        $stmt->bind_param("s", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row and assign it to $row if exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            // No bids made for this item yet
            echo "<script>showPopup('Bid Successfully');</script>";
            $row = null;
        }

        if ($row !== null && $_SESSION["username"] == $row["username"]) {
            echo "You are already the highest bidder";
            $statement = "SELECT * FROM item WHERE item_id = '$item_id'";
            $result = $conn->query($statement);
            $row = $result->fetch_assoc();
            $endtime = $row["endtime"];

            date_default_timezone_set("Asia/Kuala_Lumpur");
            $currentDateTime = date('Y-m-d H:i:s');
            $strcurrenttime = strtotime($currentDateTime);
            $strsettime = strtotime($endtime);
            if ($strcurrenttime > $strsettime) {
                $sql = "UPDATE item SET item_visible ='FALSE' WHERE item_id = '$item_id'";
                $results = mysqli_query($conn, $sql);
            }
            $winner = "winner";
            header("Location:display_items.php?user=$winner");
        } else {
            $statement = "SELECT * FROM item WHERE item_id=?";
            $stmt = $conn->prepare($statement);
            $stmt->bind_param("s", $item_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $bid = $_POST["bid"];
            $username = $_SESSION["username"];

            if ($bid > $row["current_bid"]) {
                $statement = "UPDATE item SET current_bid=? WHERE item_id=?";
                $stmt = $conn->prepare($statement);
                $stmt->bind_param("dd", $bid, $item_id);
                $stmt->execute();

                $statement = "UPDATE item SET bid_num=bid_num+1 WHERE item_id=?";
                $stmt = $conn->prepare($statement);
                $stmt->bind_param("d", $item_id);
                $stmt->execute();

                $statement = "INSERT INTO bid(username, item_id, bid_price) VALUES(?, ?, ?)";
                $stmt = $conn->prepare($statement);
                $stmt->bind_param("sid", $username, $item_id, $bid);
                $stmt->execute();

                $statement = "DELETE FROM bid WHERE bid_price<? AND item_id=?";
                $stmt = $conn->prepare($statement);
                $stmt->bind_param("dd", $bid, $item_id);
                $stmt->execute();

                echo "<script>showPopup('Congratulations, the current bid value is $" . $bid . " and you currently are the highest bidder');</script>";

                $stmt->close();
            } else {
                echo "<script>showPopup('Your bid must be greater than the current bid price.');</script>";
            }
        }
        $conn->close();
    }
    ?>
</body>
</html> 