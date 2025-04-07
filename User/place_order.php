<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch available products
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $_POST['customer_name'];
    $customerAddress = $_POST['customer_address'];
    $selectedProducts = $_POST['products'];

    // Insert each selected product into the sales table
    foreach ($selectedProducts as $productId => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            // Fetch product details
            $productSql = "SELECT * FROM product WHERE ProductID = $productId";
            $productResult = mysqli_query($conn, $productSql);
            $product = mysqli_fetch_assoc($productResult);

            // Calculate total amount
            $totalAmount = $product['Price'] * $quantity;

            // Insert into sales table
            $insertSql = "INSERT INTO sales (CustomerName, CustomerAddress, ProductID, ProductName, ProductType, Color, Description, Quantity, Price, TotalAmount)
                          VALUES ('$customerName', '$customerAddress', $productId, '{$product['ProductName']}', '{$product['ProductType']}', '{$product['Color']}', '{$product['Description']}', $quantity, {$product['Price']}, $totalAmount)";
            mysqli_query($conn, $insertSql);

            // Update inventory (reduce quantity)
            $updateSql = "UPDATE product SET Quantity = Quantity - $quantity WHERE ProductID = $productId";
            mysqli_query($conn, $updateSql);
        }
    }

    echo "<script>alert('Order placed successfully!');</script>";
}
?>

<div id="content" class="p-4 p-md-5 pt-5">

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Place Order</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            /* Extracted CSS Styling */
            body {
                background-color: #f8f9fa;
                font-family: Arial, sans-serif;
            }

            .product-box {
                background-color: #089cfc;
                padding: 20px;
                margin: 10px;
                border-radius: 5px;
                width: 350px;
                height: 410px;
                text-align: center;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .product-info {
                font-size: 15px;
                text-align: left;
                padding: 5px;
            }

            h3 {
                font-size: 20px;
                font-weight: bold;
            }

            .button-container {
                display: flex;
                justify-content: space-between;
            }

            /* Alerts */
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

            /* Table Styling */
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05);
            }

            .table-striped tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.1);
            }

            /* Form Styling */
            .form-group {
                margin-bottom: 1rem;
            }

            label {
                font-weight: bold;
            }

            input[type="number"] {
                width: 100%;
                padding: 0.5rem;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            button[type="submit"] {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px;
            }

            button[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h2>Place Order</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="customer_address">Customer Address:</label>
                    <input type="text" name="customer_address" id="customer_address" class="form-control" required>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['ProductName']) . '</td>';
                                echo '<td><input type="number" name="products[' . $row['ProductID'] . ']" min="0" value="0"></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<p>No products available.</p>';
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

        <div class="alert-container" id="alert-container"></div>
    </body>

    </html>