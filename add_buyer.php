<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign up Form</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="CSS/loginsignup.css">
</head>
<body>
    <div class="blur"></div>
    <div class="formContent blur">
        <h2>Sign up Form</h2>
        <form action="check_buyer.php" class="login_form" method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter Username" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" name="submit" value="Sign up">
        </form>
    </div>
    <script>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === "existing") {
            echo 'alert("Username already exists!");';
        }
        ?>
    </script>
    <script src="" async defer></script>
</body>
</html>