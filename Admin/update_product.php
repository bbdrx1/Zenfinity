<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["product_id"];
    $newProductName = $_POST["edit-product-name"];
    $newProductType = $_POST["edit-product-type"];
    $newColor = $_POST["edit-color"];
    $newDescription = $_POST["edit-description"];
    $newPrice = $_POST["edit-price"];

    // Database connection code (similar to your previous code)
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement with placeholders for all the fields
    $sql = "UPDATE product SET ProductName = ?, ProductType = ?, Color = ?, Description = ?, Price = ? WHERE ProductID = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in prepared statement: " . $conn->error);
    }

    // Bind parameters and execute the query
    $stmt->bind_param("ssssdi", $newProductName, $newProductType, $newColor, $newDescription, $newPrice, $productId);

    if ($stmt->execute()) {
        // Query executed successfully
        echo "Product details updated successfully!";
        header("Location: Product.php");
        exit();
    } else {
        // Query execution failed
        echo "Error updating product details: " . $stmt->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>
