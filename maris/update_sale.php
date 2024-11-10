<?php
include('db_connect.php'); // Include the database connection

// Handle sale update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_sale'])) {
    $sale_id = $_POST['sale_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product price from Products table
    $product_sql = "SELECT price FROM Products WHERE product_id = $product_id";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();
    $price = $product['price'];

    // Calculate total price
    $total_price = $price * $quantity;

    // Update sale in Sales table
    $sql = "UPDATE Sales SET product_id = $product_id, quantity = $quantity, total_price = $total_price 
            WHERE sale_id = $sale_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the View Sales page after successful update
        header("Location: view_sales.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error updating sale: " . $conn->error . "</p>";
    }
}

// Fetch sale details based on sale_id
if (isset($_GET['id'])) {
    $sale_id = $_GET['id'];
    $sale_sql = "SELECT * FROM Sales WHERE sale_id = $sale_id";
    $sale_result = $conn->query($sale_sql);
    $sale = $sale_result->fetch_assoc();

    // Fetch products for the dropdown menu
    $product_sql = "SELECT * FROM Products";
    $product_result = $conn->query($product_sql);
} else {
    header("Location: view_sales.php"); // Redirect if sale_id is not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Sale</title>
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
    <h2 style="text-align:center;">Update Sale</h2>

    <div class="form-container">
        <form method="POST" action="update_sale.php">
            <input type="hidden" name="sale_id" value="<?php echo $sale['sale_id']; ?>">
            <select name="product_id" required>
                <?php
                while ($row = $product_result->fetch_assoc()) {
                    $selected = ($row['product_id'] == $sale['product_id']) ? 'selected' : '';
                    echo "<option value='" . $row['product_id'] . "' $selected>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <input type="number" name="quantity" value="<?php echo $sale['quantity']; ?>" placeholder="Quantity Sold" required>
            <input type="submit" name="update_sale" value="Update Sale">
        </form>
    </div>
</body>
</html>
