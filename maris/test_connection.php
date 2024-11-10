<?php
include('db_connect.php');  // Include the database connection

// Check if the connection was successful
if ($conn) {
    echo "Database connection is working!";
} else {
    echo "Database connection failed.";
}
?>
