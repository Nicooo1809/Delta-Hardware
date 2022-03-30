<?php
require_once("php/mysql.php");
// Name of the file
$filename = 'hidden/database.sql';
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    $stmt = $pdo->prepare($templine);
    $stmt->execute();
    // Reset temp variable to empty
    $templine = '';
}
}
 echo "Tables imported successfully";
?>
