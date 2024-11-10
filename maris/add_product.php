<?php
include('db_connect.php'); // Include the database connection

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id']; // Category selection from the form
    $stock_level = $_POST['stock_level'];
    $price = $_POST['price'];

    // Insert query for adding a product
    $sql = "INSERT INTO Products (name, category_id, stock_level, price) 
            VALUES ('$name', $category_id, $stock_level, $price)";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the View Products page after successful insertion
        header("Location: view_products.php");
        exit(); // Ensure the script stops executing after the redirect
    } else {
        echo "<p style='color:red;'>Error adding product: " . $conn->error . "</p>";
    }
}

// Fetch categories for dropdown
$category_sql = "SELECT * FROM Categories";
$category_result = $conn->query($category_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
        input[type="text"], input[type="number"], select, input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Add New Product</h2>

    <div class="form-container">
        <form method="POST" action="add_product.php">
            <input type="text" name="name" placeholder="Product Name" required>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php
                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
            <input type="number" name="stock_level" placeholder="Stock Level" required>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="submit" name="add_product" value="Add Product">
        </form>
    </div>
</body>
</html>
