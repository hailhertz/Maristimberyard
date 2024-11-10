<?php
include('db_connect.php'); // Include database connection

// Check if a product ID was provided
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // Fetch product details
    $sql = "SELECT * FROM Products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    // Check if product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "No product ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        /* Basic styling for the form */
        .form-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Product</h2>
        <form action="update_product.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>

            <label for="category_id">Category ID:</label>
            <input type="number" id="category_id" name="category_id" value="<?php echo $product['category_id']; ?>" required>

            <label for="stock_level">Stock Level:</label>
            <input type="number" id="stock_level" name="stock_level" value="<?php echo $product['stock_level']; ?>" required>

            <label for="price">Price per Unit:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['price']; ?>" required>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>
