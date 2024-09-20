<?php
$dbHost = 'mysql.eecs.ku.edu'; // Database host
$dbUser = '447s24_b554s757'; // Database username
$dbPass = 'aef9Uth7'; // Database password
$dbName = '447s24_b554s757'; // Database name

// Create connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
