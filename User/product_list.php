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

$onHomePage = true;
include("navigation.php");

$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Product Page</title>
        <style>
            body {
                background-color: rgb(255, 255, 255);
            }

            h2 {
                text-align: center;
                color: black;
                font-size: 24px;
                font-weight: bold;
            }

            .table-container {
                max-height: 800px;
                overflow-y: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background-color: #089cfc;
            }

            th,
            td {
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid #ddd;
                color: white;
            }

            th {
                background-color: #475053;
                color: white;
                position: sticky;
                top: 0;
            }

            tr:hover {
                background-color: #23395d;
            }

            .product-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                padding: 10px;
            }

            .product-box {
                background-color: #089cfc;
                padding: 20px;
                margin: 10px;
                border-radius: 5px;
                width: 250px;
                height: 400px;
                text-align: center;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .product-image {
                max-width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 5px;
            }

            .product-info {
                font-size: 15px;
                padding-top: 10px;
            }

            h3 {
                font-size: 20px;
                font-weight: bold;
            }

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
    </head>

    <body>
        <h2>Product Gallery</h2>
        <div class="product-container">
            <?php
            // Fetch products with images
            $galleryQuery = "SELECT ProductName, Quantity, ImageURL FROM product";
            $galleryResult = $conn->query($galleryQuery);

            if ($galleryResult->num_rows > 0) {
                while ($row = $galleryResult->fetch_assoc()) {
                    $productName = htmlspecialchars($row['ProductName']);
                    $quantity = (int)$row['Quantity'];

                    // Get image from images folder using the file name only
                    $imageFileName = basename($row['ImageURL']); // safely get the file name
                    $imgSrc = 'images/' . $imageFileName;

                    echo '<div class="product-box">';
                    echo "<img src='$imgSrc' alt='$productName' class='product-image'>";
                    echo "<div class='product-info'>";
                    echo "<h3>$productName</h3>";
                    //echo "<p>Available: $quantity</p>";
                    echo "</div></div>";
                }
            } else {
                echo "<p style='color:white;'>No products available in the gallery.</p>";
            }
            ?>
        </div>


        <h2>Product Details</h2>
        <?php
        $sql = "SELECT ProductName, ProductType, Color, Description, Quantity, Price FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="table-container">';
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Product Name</th>';
            echo '<th>Product Type</th>';
            echo '<th>Color</th>';
            echo '<th>Description</th>';
            echo '<th>Quantity</th>';
            echo '<th>Price</th>';
            echo '</tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['ProductName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['ProductType']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Color']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Description']) . '</td>';
                echo '<td>' . (int)$row['Quantity'] . '</td>';
                echo '<td>₱' . number_format($row['Price'], 2, '.', ',') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p style="color:white;">No products available.</p>';
        }
        ?>

        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to Archive this product?");
            }

            function displayAlert(type, message) {
                var alertContainer = document.getElementById("alert-container");
                var alertElement = document.createElement("div");
                alertElement.className = "alert alert-" + type + " alert-dismissible show";
                alertElement.innerHTML = `
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}.
                `;
                alertContainer.appendChild(alertElement);
            }

            document.getElementById("enterButton")?.addEventListener("click", function(event) {
                var serverResponse = true;
                if (serverResponse) {
                    displayAlert("success", "Added Successfully!");
                } else {
                    displayAlert("danger", "Error adding data.");
                }
                event.preventDefault();
            });
        </script>
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <div class="alert-container" id="alert-container"></div>
    </body>

    </html>
</div>