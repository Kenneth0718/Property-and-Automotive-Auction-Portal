<?php
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $servername = "localhost";
    $username = "kennethc";
    $password = "kenneth0718";
    $database = "bid4u_system_db";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed!" . $conn->connect_error);
    }

    $username = $_POST["username"];
    $statement = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($statement);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $hash = $row["password"];

    if (password_verify($_POST["password"], $hash)) {
        session_start();
        $_SESSION["username"] = $_POST["username"];
        $conn->close();
        header("Location: itemdisplay.php");
    } else {
        $conn->close();
        header("Location: adminlogin.php?error=1");
    }/*verifies if user has entered correct password*/
} else {
    header("Location: adminlogin.php");
} /*verify user not directly accessing this page */
?>
