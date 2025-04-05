<?php
include("navigation.php");
?>

<style>
    body {
        background-color: #66c1ff;
        margin: 0; /* Remove default body margin */
    }

    .posted-data {
        margin-left: 50px;
        margin-right: 50px;
    }

    .table-container {
        max-height: 800px;
        overflow-y: auto;
        margin-top: 20px;
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

    .search-container {
        display: flex;
        align-items: center; /* Vertically center the search elements */
        margin-bottom: 10px; /* Reduce bottom margin */
    }

    .search-container input[type="text"] {
        width: 200px;
        margin right: 10px; /* Add spacing between input and dropdown */
        padding: 5px; /* Add padding for input */
    }

    .search-dropdown select {
        margin-right: 10px;
        padding: 5px; /* Add padding for dropdown */
    }

    .search-container button {
        background-color: #475053;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
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
	
	include("navigation.php");
}

?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Transaction History</h2>

    <!-- Search bar and dropdown -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search...">
        <div class="search-dropdown">
            <select id="searchCriteria">
                <option value="TransactionNumber">Transaction Number</option>
                <option value="SoldTo">Sold To</option>
                <option value="EntryDate">Entry Date</option>
                <option value="EntryTime">Entry Time</option>
            </select>
        </div>
        <button onclick="searchTransaction()">Search</button>
    </div>

    <div class="table-container">
        <?php
		$totalQty=$totalAmount=0;
        // Check if a search query is provided
        if (isset($_GET['criteria']) && isset($_GET['query'])) {
            $searchCriteria = $_GET['criteria'];
            $searchQuery = $_GET['query'];

            if ($searchCriteria === 'EntryDate') {
                $sql = "SELECT *, DATE(Entrytimestamp) AS EntryDate, TIME(Entrytimestamp) AS EntryTime FROM transaction WHERE DATE(Entrytimestamp) LIKE '%$searchQuery%' ORDER BY Entrytimestamp DESC";
            } else {
                $sql = "SELECT *, DATE(Entrytimestamp) AS EntryDate, TIME(Entrytimestamp) AS EntryTime FROM transaction WHERE $searchCriteria LIKE '%$searchQuery%' ORDER BY Entrytimestamp DESC";
            }
        } else {
            $sql = "SELECT *, DATE(Entrytimestamp) AS EntryDate, TIME(Entrytimestamp) AS EntryTime FROM transaction ORDER BY Entrytimestamp DESC";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Transaction Number</th><th>Sold To</th><th>Address</th><th>Product Name</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>Entry Date</th><th>Entry Time</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $entryTimestamp = strtotime($row['Entrytimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp);
                $entryTime = date("h:i A", $entryTimestamp);

                echo "<tr>";
                echo "<td>" . $row['TransactionNumber'] . "</td>";
                echo "<td>" . $row['SoldTo'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
				$totalQty=$totalQty+$row['Quantity'];
                echo "<td>₱" . number_format($row['Price'], 2) . "</td>";
          
				$amount=$row['Quantity']*$row['Price'];
				$totalAmount=$totalAmount+$amount;
                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<p>No data available in the transaction table.</p>";
        }
	echo "<tr>";
               
                echo "<td colspan='7' style='text-align:right;'> Total Quantity</td>";
                echo "<td colspan=''>" .$totalQty. "</td>";
				echo "<td colspan=''>Total Amount</td>";
                echo "<td colspan='4'>₱" . number_format($totalAmount, 2) . "</td>";
   
                echo "</tr>";
        ?>
    </div>
</div>



<script>
    function searchTransaction() {
        var searchInput = document.getElementById("searchInput").value.trim();
        var searchCriteria = document.getElementById("searchCriteria").value;

        window.location.href = "?criteria=" + searchCriteria + "&query=" + searchInput;
    }
</script>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/main.js"></script>

</div>
</body>
</html>
