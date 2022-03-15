<?php
require_once("php/functions.php");
$user = check_user();
print_r(1 . $user);
require_once("templates/header.php");
print_r(2 . $user);
$user = check_user();
print_r(3 . $user);
?>