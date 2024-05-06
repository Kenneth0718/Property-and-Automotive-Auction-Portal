<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login Form</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="CSS/loginsignup.css">
</head>
<body>
    <div class="blur"></div>
    <div class="formContent blur">
        <h2>Admin Login Form</h2>
        <form action="check_adminlogin.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter Username" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" name="submit" value="Login">
        </form>
        <div class="signup"> Don't have an account? <a href="add_admin.php">Sign up</a> </div>
        <a href="../mainlogin.php"><button> Back </button></a>
    </div>
    <script>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === "1") {
            echo 'alert("Wrong username or password!");';
        }
        ?>
    </script>
    <script src="" async defer></script>
</body>
</html>
