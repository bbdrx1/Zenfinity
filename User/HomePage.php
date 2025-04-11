<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

$userType = $_SESSION['type'];

if ($userType !== 'customer') {
    if ($userType !== 'admin') {
        echo "<div style='color: red; font-size: 18px; text-align: center; padding: 20px;'>Error: Unauthorized access</div>";
        echo "<img src='Stop.png' alt='Stop Image' style='display: block; margin: 0 auto;'>";
        exit();
    }
    exit();
}

$onHomePage = true; // Set this to true if you are on the home page
include("navigation.php");

$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Customer Page Title</title>

    <style>
        body {
            background-color: rgb(252, 252, 252);
        }

        .image-container {
            text-align: center;
        }

        .custom-image {
            width: 900px;
            height: 650px;
            display: block;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 45px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Welcome to Sales and Inventory System of<br>Zenfinity Trading Enterprises </h2>
        <img src="System Icon.png" alt="Image Description" class="custom-image">
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>