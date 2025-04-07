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

// Fetch user's orders
$sql = "SELECT * FROM sales WHERE CustomerName = '{$_SESSION['username']}' ORDER BY OrderTimestamp DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Extracted CSS Styling */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            color: #007bff;
            font-size: 24px;
            font-weight: bold;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        table.table-striped tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        .no-orders {
            text-align: center;
            font-size: 18px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Order History</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['SalesID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ProductName']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Quantity']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['TotalAmount']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['OrderTimestamp']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="no-orders">No orders found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>