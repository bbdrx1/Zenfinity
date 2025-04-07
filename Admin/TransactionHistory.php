<?php
include("navigation.php");
?>

<style>
    body {
        background-color: #66c1ff;
        margin: 0;
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

    th,
    td {
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
        margin: 20px 0;
    }

    .search-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .search-container input[type="text"] {
        width: 200px;
        margin-right: 10px;
        padding: 5px;
    }

    .search-dropdown select {
        margin-right: 10px;
        padding: 5px;
    }

    .search-container button {
        background-color: #475053;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    #GFG>div>div:nth-child(2) {
        margin-top: 10px;
        margin-left: 10px;
    }

    #GFG>div>div:nth-child(4) {
        margin-top: 10px;
        margin-left: 10px;
    }
</style>
<script>
    function printDiv() {
        var divContents = document.getElementById("GFG").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<head>');
        a.document.write('<style>');
        a.document.write('body { font-family: Arial, sans-serif; }');
        a.document.write('h1 { color: #333; font-size: 18px; display: flex; align-items: center; }');
        a.document.write('img { margin-right: 5px; }');
        a.document.write('p { font-size: 12px; margin: 5px 0; }');
        a.document.write('table { border-collapse: collapse; width: 100%; }');
        a.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
        a.document.write('</style>');
        a.document.write('</head>');
        a.document.write('<body>');
        a.document.write('<h1><img src="Zenfinity Logo.ico" alt="Logo" />ZENFINITY TRADING ENTERPRISES</h1>');
        a.document.write('<p>Address: Blk 10a lot 11 England st. Pacita Complex 1 San Francisco Biñan Laguna, San Pedro, Philippines</p>');
        a.document.write('<p>Contact Number: 0995 136 5404</p>');
        a.document.write('<p>Email: zenfinitytrading@hotmail.com</p>');
        a.document.write('<h1>Transaction Paper</h1>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();

        setTimeout(function() {
            a.print();
            a.close();
        }, 1000);
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
    include("navigation.php");
}
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Transaction History</h2>

    <!-- Search bar for Entry Date -->
    <div class="search-container">
        <input type="date" id="entryDateInput">
        <button onclick="searchTransactionByEntryDate()">Search</button>
    </div>

    <!-- Add spacing between the search and print elements -->
    <div style="margin-top: 10px;"></div>

    <!-- Search bar for Transaction Number -->
    <div class="search-container" style="margin-left: 10px;">
        <input type="text" id="transactionNumberInput" placeholder="Transaction Number...">
        <button onclick="searchTransactionByTransactionNumber()">Search</button>
    </div>

    <!-- Add spacing between the search and print elements -->
    <div style="margin-top: 10px; margin-left: 10px;">
        <input type="button" value="PRINT" onclick="printDiv()">
    </div>

    <div id="GFG">
        <div class="table-container">
            <?php
            $totalQty = $totalAmount = 0;

            if (isset($_GET['transactionNumber'])) {
                $transactionNumber = $_GET['transactionNumber'];
                $sql = "SELECT *, DATE_FORMAT(Entrytimestamp, '%m/%d/%Y') AS EntryDate, TIME(Entrytimestamp) AS EntryTime, SoldTo FROM transaction WHERE TransactionNumber = '$transactionNumber' ORDER BY Entrytimestamp DESC";
            } elseif (isset($_GET['entryDate'])) {
                $entryDate = $_GET['entryDate'];
                $sql = "SELECT *, DATE_FORMAT(Entrytimestamp, '%m/%d/%Y') AS EntryDate, TIME(Entrytimestamp) AS EntryTime, SoldTo FROM transaction WHERE DATE(Entrytimestamp) = '$entryDate' ORDER BY Entrytimestamp DESC";
            } else {
                $sql = "SELECT *, DATE_FORMAT(Entrytimestamp, '%m/%d/%Y') AS EntryDate, TIME(Entrytimestamp) AS EntryTime, SoldTo FROM transaction ORDER BY Entrytimestamp DESC";
            }

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                echo "<tr><th>Transaction Number</th><th>Address</th><th>Product Name</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>Entry Date</th><th>Entry Time</th><th>Buyer Name</th></tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    $entryTimestamp = strtotime($row['Entrytimestamp']);
                    $entryDate = date("n/j/Y", $entryTimestamp);
                    $entryTime = date("h:i A", $entryTimestamp);

                    echo "<tr>";
                    echo "<td>" . $row['TransactionNumber'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['ProductName'] . "</td>";
                    echo "<td>" . $row['ProductType'] . "</td>";
                    echo "<td>" . $row['Color'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>" . $row['Quantity'] . "</td>";
                    $totalQty = $totalQty + $row['Quantity'];
                    echo "<td>₱" . number_format($row['Price'], 2) . "</td>";
                    $totalAmount = $totalAmount + $row['Price'];
                    echo "<td>" . $entryDate . "</td>";
                    echo "<td>" . $entryTime . "</td>";
                    echo "<td>" . $row['SoldTo'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<p>No data available in the transaction table.</p>";
            }

            echo "<tr>";
            echo "<td colspan='6' style='text-align:right;'> Total Quantity</td>";
            echo "<td colspan=''>" . $totalQty . "</td>";
            echo "<td colspan=''>Total Amount</td>";
            echo "<td colspan='3'>₱" . number_format($totalAmount, 2) . "</td>";
            echo "</tr>";
            ?>
        </div>
    </div>
</div>

<script>
    function searchTransactionByTransactionNumber() {
        var transactionNumber = document.getElementById("transactionNumberInput").value.trim();
        window.location.href = "?transactionNumber=" + transactionNumber;
    }

    function searchTransactionByEntryDate() {
        var entryDate = document.getElementById("entryDateInput").value;
        window.location.href = "?entryDate=" + entryDate;
    }
</script>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</div>
</body>

</html>