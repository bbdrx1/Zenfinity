<?php
include("navigation.php");
?>

<style>
    body {
        background-color: #66c1ff;
        margin: 0; /* Remove default body margin */
    }

    .table-container {
        max-height: 800px;
        overflow-y: auto;
        margin-top: 20px;
    }

    .month-table {
        margin-bottom: 20px; /* Add space between month tables */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #089cfc;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: white;
        text-align: center;
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

    h2 {
        text-align: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0; /* Adjust top and bottom margin */
    }
</style>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Sales Report</h2>

    <div class="table-container">
        <?php
        $grandTotalRevenue = 0; // New variable for grand total revenue

        // Select sales data grouped by month using Entrytimestamp
        $sql = "SELECT 
            DATE_FORMAT(Entrytimestamp, '%M %Y') AS MonthYear,
            ProductName,
            SUM(Quantity) AS TotalQuantity,
            SUM(Price) AS TotalPrice 
            FROM transaction 
            GROUP BY MonthYear, ProductName";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $months = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $totalQuantity = $row['TotalQuantity'];
                $unitRevenue = 500; // Assuming fixed revenue per product is P500
                $totalRevenueForProduct = $unitRevenue * $totalQuantity;
                $grandTotalRevenue += $totalRevenueForProduct; // Accumulate grand total revenue

                $monthYear = $row['MonthYear'];
                $productName = $row['ProductName'];

                if (!in_array($monthYear, $months)) {
                    $months[] = $monthYear;
                }
            }

            foreach ($months as $month) {
                echo "<table border='1' class='month-table'>";
                echo "<tr>";
                echo "<th colspan='4'>$month</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Product Name</th><th>Total Quantity Sold</th><th>Unit Revenue</th><th>Total Revenue</th>";
                echo "</tr>";

                mysqli_data_seek($result, 0); // Reset the result set

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['MonthYear'] == $month) {
                        $productName = $row['ProductName'];
                        $totalQuantity = $row['TotalQuantity'];
                        $unitRevenue = 500; // Assuming fixed revenue per product is P500
                        $totalRevenueForProduct = $unitRevenue * $totalQuantity;

                        echo "<tr>";
                        echo "<td>{$productName}</td>";
                        echo "<td>{$totalQuantity}</td>";
                        echo "<td>₱" . number_format($unitRevenue, 2) . "</td>";
                        echo "<td>₱" . number_format($totalRevenueForProduct, 2) . "</td>";
                        echo "</tr>";
                    }
                }

                echo "<tr>";
                echo "<th>Total</th>";
                $monthTotalQuantity = 0;
                $monthTotalRevenue = 0;

                mysqli_data_seek($result, 0); // Reset the result set

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['MonthYear'] == $month) {
                        $monthTotalQuantity += $row['TotalQuantity'];
                        $unitRevenue = 500; // Assuming fixed revenue per product is P500
                        $monthTotalRevenue += $unitRevenue * $row['TotalQuantity'];
                    }
                }

                echo "<td>{$monthTotalQuantity}</td>";
                echo "<td></td>"; // Empty cell for unit revenue total
                echo "<td>₱" . number_format($monthTotalRevenue, 2) . "</td>";
                echo "</tr>";
                echo "</table>";
            }

           
        } else {
            echo "<p>No sales data available.</p>";
        }
        ?>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</div>
</body>
</html>
