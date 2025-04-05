<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set
    if (isset($_POST['productName'], $_POST['row'], $_POST['col'])) {
        $productName = $_POST['productName'];
        $row = $_POST['row'];
        $col = $_POST['col'];

        // Assuming 'locator' is the name of your table
        $sql = "UPDATE locator SET ProductName='$productName' WHERE `Row`='$row' AND `Column`='$col'";


        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "One or more form fields are not set.";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
?>
