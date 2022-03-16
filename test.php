<?php
require_once("php/functions.php");
$user = check_user();
print(1);
print_r($user);
require_once("templates/header.php");
print(2);
print_r($user);
?>