<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

$userType = $_SESSION['type'];
if ($userType !== 'customer' && $userType !== 'admin') {
    echo "<div style='color: red; font-size: 18px; text-align: center; padding: 20px;'>Error: Unauthorized access</div>";
    echo "<img src='Stop.png' alt='Stop Image' style='display: block; margin: 0 auto;'>";
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ProductName, Quantity, ImageURL FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Gallery</title>
    <style>
        body {
            background-color: #f0f7ff;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #0077cc;
            margin-top: 20px;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            background-color: white;
            border: 1px solid #ccc;
            margin: 15px;
            width: 220px;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .product-quantity {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>Product Gallery</h2>
    <div class="gallery-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imgSrc = htmlspecialchars($row['ImageURL']);
                $productName = htmlspecialchars($row['ProductName']);
                $quantity = (int)$row['Quantity'];
                echo "
                <div class='product-card'>
                    <img src='$imgSrc' alt='$productName'>
                    <div class='product-info'>
                        <div class='product-name'>$productName</div>
                        <div class='product-quantity'>Available: $quantity</div>
                    </div>
                </div>";
            }
        } else {
            echo "<p style='text-align:center;'>No products available.</p>";
        }
        ?>
    </div>
</body>

</html>