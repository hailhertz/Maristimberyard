<?php
include('db_connect.php'); // Include the database connection

// Check if the report is being requested
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_type = $_POST['report_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    // Set up the SQL query based on the report type
    if ($report_type == 'sales') {
        $report_sql = "SELECT sale_date, product_id, quantity, total_price FROM Sales WHERE sale_date BETWEEN '$start_date' AND '$end_date'";
    } elseif ($report_type == 'products') {
        $report_sql = "SELECT p.name, p.quantity_in_stock FROM Products p";
    }
    
    $report_result = $conn->query($report_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Report - Maris Timber Yard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            margin: 20px auto;
            width: 300px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
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
    </style>
</head>
<body>
    <h2 style="text-align:center;">Generate Report</h2>
    
    <form method="POST" action="">
        <label for="report_type">Select Report Type:</label>
        <select name="report_type" id="report_type" required>
            <option value="sales">Sales Report</option>
            <option value="products">Product Report</option>
        </select>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>

        <input type="submit" value="Generate Report">
    </form>

    <?php if (isset($report_result) && $report_result->num_rows > 0) { ?>
        <h3>Report Results</h3>
        <table>
            <tr>
                <?php if ($report_type == 'sales') { ?>
                    <th>Sale Date</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                <?php } elseif ($report_type == 'products') { ?>
                    <th>Product Name</th>
                    <th>Quantity in Stock</th>
                <?php } ?>
            </tr>
            <?php while ($row = $report_result->fetch_assoc()) { ?>
                <tr>
                    <?php if ($report_type == 'sales') { ?>
                        <td><?php echo $row['sale_date']; ?></td>
                        <td><?php echo $row['product_id']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                    <?php } elseif ($report_type == 'products') { ?>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['quantity_in_stock']; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    <?php } elseif (isset($report_result)) { ?>
        <p>No results found for the selected criteria.</p>
    <?php } ?>
</body>
</html>
