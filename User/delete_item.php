<?php
// Database connection parameters
$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "zenfinityaccount";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inventory_id"])) {
    $inventoryID = $_POST["inventory_id"]; // Change this to "inventory_id"

    $sql = "DELETE FROM Inventory WHERE InventoryID = '$inventoryID'"; // Change "TransactionNo" to "InventoryID"
    if (mysqli_query($conn, $sql)) {
        // Redirect back to inventory.php
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

// Close the database connection
mysqli_close($conn);
?>