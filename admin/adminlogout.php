<html>
<head><title></title> 
<link href="style.css" rel="stylesheet" type="text/css">
	
</head> 
<body>
	

<?php
session_start();
if(isset($_SESSION["username"]))
{
 
 
$_SESSION = array();
 
session_destroy();
 
echo '<script type ="text/JavaScript">';
echo 'alert("Log out Successfull!!!")';
echo '</script>';

header("Location:../mainlogin.php");

 
}
else
{
header("Location:adminlogin.php");
}
?>


</body>
</html>