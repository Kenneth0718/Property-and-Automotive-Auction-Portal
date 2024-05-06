<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Form</title>
    <meta name="google-signin-client_id" content="56071966215-ao2n2ocn1h3uumqolfp4f6264asj37fo.apps.googleusercontent.com">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" type="text/css" href="CSS/loginsignup.css">
</head>
<body>
    <div class="blur"></div>
    <div class="formContent blur">
        <h2>Login Form</h2>
        <form action="check_login.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter Username" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" name="submit" value="Login">
            <div class="remember">
                <div class="login"><div class="Oroption">OR</div></div>
                <div class="signup"> Don't have account? <a href="add_buyer.php">Sign up</a> </div>
            </div>
        </form>
        <a href="mainlogin.php"><button> Back </button></a>
    </div>
    <script>
        function onSignIn(googleUser) {
            console.log(googleUser.getBasicProfile());
        }

        // Display pop-up error messages
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] === "1") {
                echo 'alert("Wrong username or password!");';
            } elseif ($_GET['error'] === "2") {
                echo 'alert("User not found!");';
            }
        }
        ?>
    </script>
    <script src="" async defer></script>
</body>
</html>
