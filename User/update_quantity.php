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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_button"])) {
    $inventory_id = $_POST["inventory_id"];
    $new_quantity = $_POST["edit_quantity"];

    // Update the quantity in the database (assuming $conn is available from your main script)
    $sql = "UPDATE Inventory SET Quantity = '$new_quantity' WHERE InventoryID = '$inventory_id'";
    
    if (mysqli_query($conn, $sql)) {

        header("Location: inventory.php");
        exit;
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
} else {
     
}
?>