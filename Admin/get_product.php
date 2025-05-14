<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    $productId = intval($_POST["product_id"]);
    $sql = "SELECT * FROM product WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
}
?>