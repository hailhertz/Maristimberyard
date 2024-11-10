<?php
include('db_connect.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // Insert into Categories table
    $sql = "INSERT INTO Categories (category_name) VALUES ('$category_name')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Category added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error adding category: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
</head>
<body>
    <h2>Add Category</h2>
    <form method="POST" action="add_category.php">
        <input type="text" name="category_name" placeholder="Category Name" required>
        <input type="submit" name="add_category" value="Add Category">
    </form>
</body>
</html>
