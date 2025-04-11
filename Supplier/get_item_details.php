<?php
// get_item_details.php

$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["inventory_id"])) {
    $inventory_id = $_GET["inventory_id"];
    $sql = "SELECT * FROM Inventory WHERE InventoryID = '$inventory_id'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
