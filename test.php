<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
print_r($_SERVER);
?>

<?php
require_once("templates/footer.php");
?>