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

    .filter-container {
        margin-bottom: 10px;
    }
</style>

<script> 
function printDiv() { 
    var divContents = document.getElementById("GFG").innerHTML; 
    var a = window.open('', '', 'height=500, width=500'); 
    a.document.write('<html>'); 
    a.document.write('<head>');
    a.document.write('<style>');
    // Add your print styles here
    a.document.write('body { font-family: Arial, sans-serif; }');
    a.document.write('h1 { color: #333; font-size: 18px; display: flex; align-items: center; }'); // Adjust the font size for h1
    a.document.write('img { margin-right: 5px; }'); // Add styles for the image
    a.document.write('p { font-size: 12px; margin: 5px 0; }'); // Adjust the font size and margin for paragraphs
    a.document.write('table { border-collapse: collapse; width: 100%; }');
    a.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    // Add more styles as needed
    a.document.write('</style>');
    a.document.write('</head>');
    a.document.write('<body>');
    a.document.write('<h1><img src="Zenfinity Logo.ico" alt="Logo" />ZENFINITY TRADING ENTERPRISES</h1>');
    a.document.write('<p>Address: Blk 10a lot 11 England st. Pacita Complex 1 San Francisco Biñan Laguna, San Pedro, Philippines</p>');
    a.document.write('<p>Contact Number: 0995 136 5404</p>');
    a.document.write('<p>Email: zenfinitytrading@hotmail.com</p>');
	 a.document.write('<h1>Sales Report</h1>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    
    // Delay the print operation
    setTimeout(function() {
        a.print(); 
        a.close();
    }, 1000); // Adjust the delay time (in milliseconds) as needed
}
</script> 

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
    <div class="filter-container">
       
        <select id="monthSelect" onchange="filterTable()">
            <option value="all">All</option>
            <?php
            $sql = "SELECT DISTINCT DATE_FORMAT(Entrytimestamp, '%M %Y') AS MonthYear FROM transaction";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['MonthYear'] . '">' . $row['MonthYear'] . '</option>';
                }
            }
            ?>
			 <input type="button" value="PRINT" onclick="printDiv()"> 
        </select>
    </div>
    <div id="GFG"> 
        

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
                    echo "<table border='1' class='month-table' id='table-$month'>";
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
</div>

<script>
    function filterTable() {
        var selectedMonth = document.getElementById("monthSelect").value;
        var tables = document.getElementsByClassName("month-table");
        
        for (var i = 0; i < tables.length; i++) {
            tables[i].style.display = "none";
        }

        if (selectedMonth === "all") {
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = "table";
            }
        } else {
            var selectedTable = document.getElementById("table-" + selectedMonth);
            if (selectedTable) {
                selectedTable.style.display = "table";
            }
        }
    }
</script>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
