<?php
include('db_connect.php'); // Include the database connection

// Handle sale deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM Sales WHERE sale_id = $delete_id";
    $conn->query($delete_sql);
    header("Location: view_sales.php"); // Redirect after deletion
    exit();
}

// Fetch sales details along with product names
$sql = "SELECT s.sale_id, p.name AS product_name, s.quantity, s.total_price, s.sale_date
        FROM Sales s
        JOIN Products p ON s.product_id = p.product_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Sales</title>
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
        .add-sale-link, .edit-sale-link, .delete-sale-link {
            display: inline-block;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-sale-link:hover, .edit-sale-link:hover, .delete-sale-link:hover {
            background-color: #45a049;
        }
        .delete-sale-link {
            background-color: #f44336; /* Red for delete */
        }
        .delete-sale-link:hover {
            background-color: #d32f2f; /* Darker red */
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Sales List</h2>

    <!-- Link to Add Sale Form -->
    <div class="add-sale-link">
        <a href="add_sale.php">Add New Sale</a>
    </div>

    <!-- View Sales Table -->
    <table>
        <tr>
            <th>Sale ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Sale Date</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['sale_id']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['total_price']}</td>
                    <td>{$row['sale_date']}</td>
                    <td>
                        <a class='edit-sale-link' href='update_sale.php?id={$row['sale_id']}'>Edit</a>
                        <a class='delete-sale-link' href='view_sales.php?delete_id={$row['sale_id']}' onclick='return confirm(\"Are you sure you want to delete this sale?\");'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
