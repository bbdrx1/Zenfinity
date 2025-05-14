<?php
include("navigation.php");
?>
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<style>
    body {
        background-color: rgb(255, 255, 255);
    }

    .chart-container {
        margin-top: -30px;
        padding-bottom: 0px;
        width: 100%;
    }

    h2 {
        text-align: center;
        color: black;
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
    }

    /* New styles for real-time stock section */
    .stock-table-container {
        margin-top: 30px;
    }

    .stock-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .stock-table th,
    .stock-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .stock-table th {
        background-color: #089cfc;
        color: white;
    }

    .low-stock {
        background-color: #ffc107 !important; /* Yellow */
    }

    .very-low-stock {
        background-color: #dc3545 !important; /* Red */
        color: white !important;
    }

    .in-stock {
        background-color: #28a745;
        color: white;
    }
</style>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Existing Dashboard Cards -->
    <?php
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Total Earnings This Year
    $sql = "SELECT SUM(500 * Quantity) as total_earnings FROM transaction";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalEarnings = $row['total_earnings'] ?? 0;

    // Earnings This Month
    $sql = "SELECT SUM(500 * Quantity) as total_earnings FROM transaction WHERE MONTH(EntryTimestamp) = $currentMonth AND YEAR(EntryTimestamp) = $currentYear";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $monthlyEarnings = $row['total_earnings'] ?? 0;

    // Product Sold This Year
    $sql = "SELECT SUM(Quantity) as total_quantity_sold FROM transaction WHERE YEAR(EntryTimestamp) = $currentYear";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalSold = $row['total_quantity_sold'] ?? 0;

    // Transactions
    $sql = "SELECT COUNT(DISTINCT TransactionNumber) as total_transactions FROM transaction WHERE YEAR(EntryTimestamp) = $currentYear";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $transactions = $row['total_transactions'] ?? 0;
    ?>

    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (This Year)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($totalEarnings, 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (This Month)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($monthlyEarnings, 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product Sold (THIS YEAR)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $totalSold; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: <?= min(100, max(0, ($totalSold / 1000) * 100)); ?>%"
                                            aria-valuenow="<?= $totalSold; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Transactions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $transactions; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-Time Product Stock Table -->
    <div class="stock-table-container">
        <h3>Product Stock Levels</h3>
        <table class="stock-table" id="stockTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Product Type</th>
                    <th>Color</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT ProductID, ProductName, ProductType, Color, Description, Quantity FROM product ORDER BY Quantity ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $quantity = $row['Quantity'];
                        if ($quantity == 0) {
                            $status = "No Stocks";
                            $class = "no-stock";
                        } elseif ($quantity <= 5) {
                            $status = "Very Low";
                            $class = "very-low-stock";
                        } elseif ($quantity <= 20) {
                            $status = "Low Stock";
                            $class = "low-stock";
                        } else {
                            $status = "In Stock";
                            $class = "in-stock";
                        }
                ?>
                <tr class="<?= $class ?>">
                    <td><?= htmlspecialchars($row['ProductName']) ?></td>
                    <td><?= $row['ProductID'] ?></td>
                    <td><?= htmlspecialchars($row['ProductType']) ?></td>
                    <td><?= htmlspecialchars($row['Color']) ?></td>
                    <td><?= htmlspecialchars($row['Description']) ?></td>
                    <td><?= $quantity ?></td>
                    <td><?= $status ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="7">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bar Chart Section -->
    <?php
    $sql = "SELECT ProductName, MONTH(EntryTimestamp) AS month, SUM(Quantity) as total_quantity FROM transaction GROUP BY ProductName, month";
    $result = $conn->query($sql);
    $salesData = [];

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            $productName = $row['ProductName'];
            $month = $row['month'] - 1;

            if (!isset($salesData[$productName])) {
                $salesData[$productName] = ['productName' => $productName, 'monthlyQuantities' => array_fill(0, 12, 0)];
            }

            $salesData[$productName]['monthlyQuantities'][$month] = $row['total_quantity'];
        endwhile;
    endif;

    $jsSalesData = json_encode(array_values($salesData));
    ?>

    <div class="container d-flex flex-column justify-content-center my-4">
        <div class="row my-2">
            <div class="col-md-12">
                <div class="card chart-container">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col text-center mt-4">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    SOLD ITEM EVERY MONTH
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chBar" height="125"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Chart.js -->
<script src="vendor/chart.js/Chart.min.js"></script>

<script>
    var colors = ['#007bff', '#28a745', '#444444', '#c3e6cb', '#dc3545', '#6c757d'];

    // Fetch sales data from PHP
    var salesData = <?= $jsSalesData ?>;
    var chartData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: []
    };

    // Map each product to its dataset
    salesData.forEach((item, index) => {
        chartData.datasets.push({
            label: item.productName,
            data: item.monthlyQuantities,
            backgroundColor: colors[index % colors.length],
            borderWidth: 1
        });
    });

    // Initialize Chart
    var chBar = document.getElementById("chBar");
    if (chBar) {
        new Chart(chBar, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    xAxes: [{
                        barPercentage: 0.4,
                        categoryPercentage: 0.5
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        });
    }

    // Optional: Auto-refresh stock table every 30 seconds
    function refreshStockTable() {
        $.ajax({
            url: 'get_stock_data.php',
            success: function(data) {
                $('#stockTable tbody').html(data);
            },
            dataType: 'html'
        });
    }

    setInterval(refreshStockTable, 30000); // Refresh every 30 seconds
</script>

</body>
</html>