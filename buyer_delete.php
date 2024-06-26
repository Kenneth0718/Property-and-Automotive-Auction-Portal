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
    $password = $_POST["password"];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $statement = "SELECT * FROM buyer WHERE username=?";
    $stmt = $conn->prepare($statement);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows >= 1) {
        $conn->close();
        header("Location: signup_form.php?error=existing");
        exit();
    } else {
        $statement = "INSERT INTO buyer(username, password) VALUES(?, ?)";
        $stmt = $conn->prepare($statement);
        $stmt->bind_param("ss", $username, $hashed);
        $stmt->execute();

        $conn->close();
        header("Location: display_items.php");
        exit();
    }
} else {
    header("Location: add_buyer.php");
    exit();
}
?>
