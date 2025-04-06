<?php
include("navigation.php");
?>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$sql = "SELECT SUM(500 * Quantity) as total_earnings FROM transaction";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $earnings = $row['total_earnings'];
} else {
    $earnings = 0; // Default value if no records are found
}
?>

<style>
    body {
        background-color: #66c1ff;
    }
	
	.chart-container {
            margin-top: -30px;
            padding-bottom: 0px;
			width: 100%;
        }
		
	 h2 {
        text-align: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0; /* Adjust top and bottom margin */
    }
</style>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (This Year)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?php echo number_format($earnings, 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    


<?php
$currentMonth = date('m');
$currentYear = date('Y');

$sql = "SELECT SUM(500 * Quantity) as total_earnings FROM transaction WHERE MONTH(EntryTimestamp) = $currentMonth AND YEAR(EntryTimestamp) = $currentYear";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $earnings = $row['total_earnings'];
} else {
    $earnings = 0; // Default value if no records are found
}
?>

                       <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Earnings (This Month)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        ₱<?php echo number_format($earnings, 2); ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

 
<?php
$sql = "SELECT SUM(Quantity) as total_quantity_sold FROM transaction WHERE YEAR(EntryTimestamp) = $currentYear";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalQuantitySold = $row['total_quantity_sold'];
} else {
    $totalQuantitySold = 0; // Default value if no records are found
}

// Calculate the percentage based on a total goal quantity (adjust as needed)
$totalGoalQuantity = 1000; // Change this value to your desired total goal quantity
$percentage = ($totalQuantitySold / $totalGoalQuantity) * 100;
?>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product Sold (THIS YEAR)</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalQuantitySold; ?></div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $percentage; ?>%" aria-valuenow="<?php echo $percentage; ?>"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$sql = "SELECT COUNT(DISTINCT TransactionNumber) as total_transactions FROM transaction WHERE YEAR(EntryTimestamp) = $currentYear";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalTransactions = $row['total_transactions'];
} else {
    $totalTransactions = 0; // Default value if no records are found
}
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Transaction</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalTransactions; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

           <!-- "                                                          "-->    


<?php
// Assuming your "transaction" table has columns named "ProductName," "Quantity," and "EntryTimestamp"
$sql = "SELECT ProductName, MONTH(EntryTimestamp) AS month, SUM(Quantity) as total_quantity FROM transaction GROUP BY ProductName, month";
$result = $conn->query($sql);

$salesData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['ProductName'];
        $month = $row['month'] - 1; // Adjust month to be zero-based for JavaScript array
        $totalQuantity = $row['total_quantity'];

        if (!isset($salesData[$productName])) {
            $salesData[$productName] = [
                'productName' => $productName,
                'monthlyQuantities' => array_fill(0, 12, 0) // Initialize with zeros for all months
            ];
        }

        $salesData[$productName]['monthlyQuantities'][$month] = $totalQuantity;
    }
}

$jsSalesData = array_values($salesData);
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
                    

   

        
	
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>


    <script src="js11/sb-admin-2.min.js"></script>


    <script src="vendor/chart.js/Chart.min.js"></script>

    <script src="js11/demo/chart-area-demo.js"></script>
    <script src="js11/demo/chart-pie-demo.js"></script>
	
 <script>
        var colors = ['#007bff', '#28a745', '#444444', '#c3e6cb', '#dc3545', '#6c757d'];

        // Assuming you have the salesData array from PHP
        var salesData = <?php echo json_encode(array_values($salesData)); ?>;

        // Simplified number_format function
        function number_format(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        var chBar = document.getElementById("chBar");
        var chartData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: salesData.map((item, index) => ({
                label: item.productName,
                data: item.monthlyQuantities,
                backgroundColor: colors[index % colors.length], // Use different color for each product
                borderWidth: 1 // Add border width to show the bar lines
            }))
        };

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
                                callback: function (value, index, values) {
                                    return number_format(value);
                                }
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            });
        }
    </script>
	
		<script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
	
    </body>
</html>
