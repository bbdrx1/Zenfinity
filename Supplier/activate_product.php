<?php
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
    
    // Retrieve the product data from the archiveproduct table
    $sql = "SELECT * FROM archiveproduct WHERE ProductID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Insert the product data into the product table
            $insertSql = "INSERT INTO product (ProductID, ProductName, ProductType, Color, Description, Quantity, Price) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("isssidi", $row["ProductID"], $row["ProductName"], $row["ProductType"], $row["Color"], $row["Description"], $row["Quantity"], $row["Price"]);
            
            if ($insertStmt->execute()) {
                // Product activated successfully, you can add a success message if needed
            } else {
                echo "Failed to activate product. Please try again.";
            }
            
            // Close the insert statement
            $insertStmt->close();
        } else {
            echo "Product not found in the archive.";
        }
    } else {
        echo "Failed to retrieve product from the archive. Please try again.";
    }
    
    // Optionally, you can delete the record from the archiveproduct table
    $deleteSql = "DELETE FROM archiveproduct WHERE ProductID = ?";
    
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $productId);
    
    if ($deleteStmt->execute()) {
        // Record deleted from the archiveproduct table
    } else {
        echo "Failed to delete the record from the archive. Please try again.";
    }
    
    // Close the delete statement and the database connection
    $deleteStmt->close();
    $conn->close();
}

// Redirect back to ArchiveProduct.php
header("Location: ArchiveProduct.php");
exit();
?>
