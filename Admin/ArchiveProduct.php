<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Product List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS styles -->
</head>
<body>
<?php
include("navigation.php");
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Archived Product List</h2>

    <style>
        body {
            background-color: #66c1ff;
        }

        .posted-data {
            margin-left: 50px;
            margin-right: 50px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap; /* Allow boxes to wrap to the next line */
            justify-content: flex-start; /* Start from left to right */
        }

        .product-box {
            background-color: #089cfc;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            width: 350px; /* Adjust the width as needed */
            height: 410px; /* Adjust the height as needed */
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column; /* Stack the inner elements vertically */
            justify-content: space-between; /* Add space between the inner elements */
        }

        .product-info {
            font-size: 15px; /* Adjust the font size as needed */
            text-align: left; /* Align the text to the left within product-info */
            padding: 5px; /* Add padding to create space around the text */
        }

        .red-border {
            border: 10px solid red;
        }

        .yellow-border {
            border: 10px solid yellow;
        }

        .green-border {
            border: 10px solid green;
        }

        h3 {
            font-size: 20px; /* Adjust the title font size as needed */
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        /* Add CSS for alerts */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .alert {
            position: relative;
            width: 300px;
            margin-bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .alert.show {
            opacity: 1;
        }
    </style>

    <!-- Alert container -->
    <div class="alert-container" id="alert-container"></div>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT ProductID, ProductName, ProductType, Color, Description, Quantity, Price FROM archiveproduct";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="product-container">'; // Start product container
        while ($row = $result->fetch_assoc()) {
            $quantity = (int)$row['Quantity']; // Convert quantity to an integer
            $borderClass = '';

            // Determine the border class based on quantity
            if ($quantity < 21) {
                $borderClass = 'red-border';
            } elseif ($quantity >= 30 && $quantity <= 60) {
                $borderClass = 'yellow-border';
            } else {
                $borderClass = 'green-border';
            }

            echo '<div class="product-box ' . $borderClass . '">';
            echo '<h3>' . $row['ProductName'] . '</h3>';
            echo '<div class="product-info">';
            echo '<p><strong>Product ID:</strong> ' . $row['ProductID'] . '</p>';
            echo '<p>Product Type: ' . $row['ProductType'] . '</p>';
            echo '<p>Color: ' . $row['Color'] . '</p>';
            echo '<p>Description: ' . $row['Description'] . '</p>';
            echo '<p>Quantity: ' . $row['Quantity'] . '</p>';
            echo '<p>Price: ' . $row['Price'] . '</p>';

            // Container for buttons
            echo '<div class="button-container">';
            
            // Create a form for activating the product
            echo '<form action="activate_product.php" method="POST">';
            echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
            echo '<button class="activate-button" type="submit">Activate</button>';
            echo '</form>';
            
            echo '</div>'; // Close button-container
            
            echo '</div>'; // Close product-info
            echo '</div>'; // Close product-box
        }
        echo '</div>'; // Close product container
    } else {
        echo 'No archived data found.';
    }
    ?>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</div>
</body>
</html>
