<?php
$servername = "localhost";
$username = "sicki_yrs";
$database = "sickie_yrs";
$password = "yrsyrs1";

// Create connection
$conn = new mysqli($servername, $database, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";


?>