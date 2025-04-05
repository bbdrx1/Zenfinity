<?php
// Include the database connection code
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST["product_id"];
    
    // Perform the database move operation here
    $sql = "INSERT INTO archiveproduct SELECT * FROM product WHERE ProductID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    
    if ($stmt->execute()) {
        // Now, you have moved the product to the productarchive table
        // You can also choose to delete the product from the original table if needed
        $deleteSql = "DELETE FROM product WHERE ProductID = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $productId);
        
        if ($deleteStmt->execute()) {
            // Redirect back to the product list after successful move
            header("Location: Product.php");
            exit;
        } else {
            echo "Failed to delete product from the original table. Please try again.";
        }
        
        // Close the delete statement
        $deleteStmt->close();
    } else {
        echo "Failed to move product to productarchive. Please try again.";
    }
    
    // Close the statements and the database connection
    $stmt->close();
    $conn->close();
}
?>
