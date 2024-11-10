<?php
include('db_connect.php'); // Include database connection

// Check if product_id is set
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // SQL query to delete the product
    $sql = "DELETE FROM Products WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    echo "No product ID provided";
}

// Close the connection and redirect back to view_products.php
$conn->close();
header("Location: view_products.php");
exit();
?>
