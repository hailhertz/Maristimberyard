<?php
$servername = "localhost";  // Default server
$username = "root";         // Default username in XAMPP
$password = "";             // Default password for root is empty
$dbname = "maris_timber_yard"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
