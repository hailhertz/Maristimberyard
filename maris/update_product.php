<?php
include('db_connect.php'); // Include the database connection

// Handle product update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $product_id = (int)$_POST['product_id'];
    $name = $_POST['name'];
    $category_id = (int)$_POST['category_id'];
    $stock_level = (int)$_POST['stock_level'];
    $price = (float)$_POST['price'];

    // Update query
    $sql = "UPDATE Products SET 
            name = '$name', 
            category_id = $category_id, 
            stock_level = $stock_level, 
            price = $price 
            WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Product updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error updating product: " . $conn->error . "</p>";
    }
}

// Retrieve product details for editing
$product_id = (int)$_GET['product_id'];
$sql = "SELECT * FROM Products WHERE product_id = $product_id";
$product_result = $conn->query($sql);
$product = $product_result->fetch_assoc();

// Fetch categories for the dropdown
$category_sql = "SELECT * FROM Categories";
$category_result = $conn->query($category_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        input[type="text"], input[type="number"], select, input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container {
            width: 60%;
            margin: 20px auto;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Edit Product</h2>

    <div class="form-container">
        <form action="update_product.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            <select name="category_id" required>
                <option value="">Select a Category</option>
                <?php
                while($category_row = $category_result->fetch_assoc()) {
                    $selected = ($product['category_id'] == $category_row['category_id']) ? 'selected' : '';
                    echo "<option value='" . $category_row["category_id"] . "' $selected>" . $category_row["category_name"] . "</option>";
                }
                ?>
            </select>
            <input type="number" name="stock_level" value="<?php echo $product['stock_level']; ?>" required>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            <input type="submit" name="update_product" value="Update Product">
        </form>
    </div>
</body>
</html>
