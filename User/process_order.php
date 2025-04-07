<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process the order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert order details into the database
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity_') === 0) {
            $product_id = substr($key, strlen('quantity_'));
            $quantity = intval($value);
            if ($quantity > 0) {
                // Insert order into the database
                $sql = "INSERT INTO orders (UserID, ProductID, Quantity, TotalPrice) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiid", $_SESSION['user_id'], $product_id, $quantity, $total_price);
                $stmt->execute();
            }
        }
    }

    header("Location: HomePage.php");
    exit;
}
