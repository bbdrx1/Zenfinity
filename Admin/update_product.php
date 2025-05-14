<?php
session_start(); // Start session for flash messages

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get product ID and editable fields
    $productId = intval($_POST["product_id"]);
    $newProductName = $_POST["edit-product-name"];
    $newProductType = $_POST["edit-product-type"];
    $newColor = $_POST["edit-color"];
    $newQuantity = intval($_POST["edit-Quantity"]); 
    $newPrice = floatval($_POST["edit-price"]);

    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch current Description from the database
    $stmtFetch = $conn->prepare("SELECT Description FROM product WHERE ProductID = ?");
    $stmtFetch->bind_param("i", $productId);
    $stmtFetch->execute();
    $stmtFetch->bind_result($currentDescription);
    $stmtFetch->fetch();
    $stmtFetch->close();

    // Update main `product` table
    $sql = "UPDATE product SET 
                ProductName = ?, 
                ProductType = ?, 
                Color = ?, 
                Quantity = ?, 
                Price = ? 
            WHERE ProductID = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error in prepared statement for product'];
        header("Location: Product.php");
        exit();
    }

    $stmt->bind_param(
        "ssiddi", 
        $newProductName, 
        $newProductType, 
        $newColor, 
        $newQuantity, 
        $newPrice, 
        $productId
    );

    if (!$stmt->execute()) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error updating product details: ' . $stmt->error];
        $stmt->close();
        $conn->close();
        header("Location: Product.php");
        exit();
    }
    $stmt->close();

    // Now update `theinventory` table with same logic
    $sql_inventory = "UPDATE theinventory SET
                        ProductName = ?, 
                        ProductType = ?, 
                        Color = ?, 
                        Quantity = ?, 
                        Price = ?
                      WHERE ProductID = ?";

    $stmt_inventory = $conn->prepare($sql_inventory);

    if ($stmt_inventory === false) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error preparing inventory update'];
        $conn->close();
        header("Location: Product.php");
        exit();
    }

    $stmt_inventory->bind_param(
        "ssiddi",
        $newProductName,
        $newProductType,
        $newColor,
        $newQuantity,
        $newPrice,
        $productId
    );

    if (!$stmt_inventory->execute()) {
        $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Inventory not updated: ' . $stmt_inventory->error];
    } else {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Product and Inventory updated successfully'];
    }

    $stmt_inventory->close();
    $conn->close();

    // Redirect back
    header("Location: Product.php");
    exit();
}
?>