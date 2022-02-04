<?php 
session_start();
session_destroy();
unset($_SESSION['userid']);

//Remove Cookies
setcookie("identifier","",time()-(3600*24*365)); 
setcookie("securitytoken","",time()-(3600*24*365)); 

require_once("php/mysql.php");
require_once("php/functions.php");

header("location: index.php");
exit();
?>
