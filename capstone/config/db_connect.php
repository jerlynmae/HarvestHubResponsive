<?php
// Database configuration
$host = "localhost";    
$user = "root";          
$pass = "";             
$db   = "project";      

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set character set to UTF-8
$conn->set_charset("utf8");
?>
