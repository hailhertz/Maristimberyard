<?php
include('db_connect.php'); // Include the database connection

// Handle category addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // SQL query to insert a new category
    $sql = "INSERT INTO Categories (category_name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Category added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error adding category: " . $conn->error . "</p>";
    }
}

// Fetch all categories from the database
$sql = "SELECT * FROM Categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <style>
        /* Basic styling for the table and forms */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
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
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Manage Categories</h2>

    <div class="form-container">
        <h3>Add New Category</h3>
        <form action="manage_categories.php" method="post">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <input type="submit" name="add_category" value="Add Category">
        </form>
    </div>

    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["category_id"] . "</td>
                        <td>" . $row["category_name"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No categories found</td></tr>";
        }
        $conn->close(); // Close the database connection
        ?>
    </table>
</body>
</html>
