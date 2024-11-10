<?php
include('db_connect.php'); // Include the database connection

// Fetch products and related categories
$sql = "SELECT p.product_id, p.name, p.category_id, p.stock_level, p.price, c.category_name 
        FROM Products p
        JOIN Categories c ON p.category_id = c.category_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-product-link {
            display: inline-block;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-product-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Product List</h2>

    <!-- Link to Add Product Form -->
    <div class="add-product-link">
        <a href="add_product.php">Add New Product</a>
    </div>

    <!-- View Products Table -->
    <table>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Stock Level</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['product_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['category_name']}</td>
                    <td>{$row['stock_level']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <a href='update_product.php?product_id={$row['product_id']}'>Edit</a> |
                        <a href='delete_product.php?product_id={$row['product_id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
