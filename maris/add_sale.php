<?php
include('db_connect.php'); // Include the database connection

// Handle sale addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sale'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product price from Products table
    $product_sql = "SELECT price FROM Products WHERE product_id = $product_id";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();
    $price = $product['price'];

    // Calculate total price
    $total_price = $price * $quantity;

    // Insert sale into Sales table
    $sql = "INSERT INTO Sales (product_id, quantity, total_price) 
            VALUES ($product_id, $quantity, $total_price)";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the View Sales page after successful insertion
        header("Location: view_sales.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error adding sale: " . $conn->error . "</p>";
    }
}

// Fetch products for the dropdown menu
$product_sql = "SELECT * FROM Products";
$product_result = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Sale</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        input[type="number"], select, input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Add New Sale</h2>

    <div class="form-container">
        <form method="POST" action="add_sale.php">
            <select name="product_id" required>
                <option value="">Select Product</option>
                <?php
                while ($row = $product_result->fetch_assoc()) {
                    echo "<option value='" . $row['product_id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <input type="number" name="quantity" placeholder="Quantity Sold" required>
            <input type="submit" name="add_sale" value="Add Sale">
        </form>
    </div>
</body>
</html>
