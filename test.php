<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
print_r($_SERVER);
setcookie("test","sdfsdfsdfsfsdf",time()+(3600*24*365)); //Valid for 1 year
?>

<?php
require_once("templates/footer.php");
?>