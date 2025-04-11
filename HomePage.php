<?php
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

// SQL query to retrieve product data
$sql = "SELECT ProductName, Quantity FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>

    <style>
        body {
            background-color: white;
            /* Changed background color to white */
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
            /* Adjusted text color for better contrast against white background */
            font-size: 45px;
            font-weight: bold;
        }

        .low-stock-alert {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background-color: transparent;
            padding: 20px;
            border: none;
            z-index: 9999;
            display: none;
        }

        .alert-content {
            background-color: #f8d7da;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        /* Style for the close button */
        .close-button {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            background-color: gray;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
            z-index: 1;
        }

        /* Hover style for the close button */
        .close-button:hover {
            background-color: black;
            color: gray;
        }

        /* Style for the alert text */
        .alert-text {
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Welcome to Sales and Inventory System of<br>Zenfinity Trading Enterprises </h2>
        <img src="System Icon.png" alt="Image Description" class="custom-image">
    </div>

    <?php
    $alertCounter = 0; // Counter to create unique identifiers for alerts
    $alertSpacing = 120; // Adjust the spacing between alerts

    while ($row = $result->fetch_assoc()) {
        $productName = $row["ProductName"];
        $quantity = $row["Quantity"];

        if ($quantity < 50) {
            $alertCounter++; // Increment the counter to create a unique identifier
            $topPosition = $alertCounter * $alertSpacing; // Calculate the top position
            $alertId = "alert" . $alertCounter; // Generate a unique alert ID
            echo "<div class='low-stock-alert' id='$alertId' style='top: {$topPosition}px;'>";
            echo "<span class='close-button'>&times;</span>"; // Close button
            echo "<div class='alert-content'>";
            echo "<p class='alert alert-danger alert-text' role='alert'>";
            echo "Low stock alert: Product <b>'$productName'</b> has a quantity of $quantity, contact the supplier as soon as possible for replenishing of stock";
            echo "</p>";
            echo "</div>";
            echo "</div>";
        }
    }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            // Check if you are on the home page and if there are any products with a quantity below 50
            if ($onHomePage && $result->num_rows > 0) {
                echo "var lowStockAlerts = document.querySelectorAll('.low-stock-alert');";
                echo "lowStockAlerts.forEach(function(alert) { alert.style.display = 'block'; });";
            }
            ?>

            var closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    var alert = event.target.closest('.low-stock-alert');
                    if (alert) {
                        alert.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>