<?php
require_once("php/functions.php");
$test = 'sgsgdfgdfgd';
$user = check_user();
print($test);
print(1);
print_r($user);
require_once("templates/header.php");
print($test);
print(2);
print_r($user);
$user = check_user();
print(3);
print_r($user);
?>