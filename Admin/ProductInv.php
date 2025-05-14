<?php
include("navigation.php");
?>

<style>
    body {
        background-color: #f8f9fa;
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
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        color: white;
    }

    th {
        background-color: #475053;
        color: white;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    tr:hover {
        background-color: #23395d;
    }

    h2 {
        text-align: center;
        color: black;
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
    }

    .search-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .search-container input[type="text"],
    .search-container input[type="date"] {
        width: 200px;
        margin-right: 10px;
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .search-container button {
        background-color: #475053;
        color: white;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
    }

    .search-container select {
        padding: 6px;
        margin-right: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .export-btn {
        margin-left: 10px;
        background-color: #28a745;
    }

    .export-btn:hover {
        background-color: #218838;
    }
</style>

<?php
// Database connection parameters
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
    <h2 class="mb-4">Inventory History</h2>

    <!-- Search bar -->
    <div class="search-container">
        <select id="searchCriteria">
            <option value="ProductID">Product ID</option>
            <option value="ProductName">Product Name</option>
            <option value="EntryTimestamp">Date</option>
        </select>
        <input type="text" id="searchInput" placeholder="Search...">
        <button onclick="searchInventory()">Search</button>
        <!-- <button class="export-btn" onclick="exportToCSV()">Export CSV</button> -->
    </div>

    <div class="table-container">
        <?php
        // Build SQL query based on criteria
        if (isset($_GET['criteria']) && isset($_GET['query'])) {
            $searchCriteria = mysqli_real_escape_string($conn, $_GET['criteria']);
            $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

            if ($searchCriteria === 'EntryTimestamp') {
                $sql = "SELECT * FROM theinventory WHERE DATE(EntryTimestamp) LIKE '%$searchQuery%' ORDER BY EntryTimestamp DESC";
            } else {
                $sql = "SELECT * FROM theinventory WHERE `$searchCriteria` LIKE '%$searchQuery%' ORDER BY EntryTimestamp DESC";
            }
        } else {
            $sql = "SELECT * FROM theinventory ORDER BY EntryTimestamp DESC";
        }

        $result = mysqli_query($conn, $sql);
        ?>
        <table border='1'>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Color</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Entry Date</th>
                <th>Entry Time</th>
            </tr>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ProductID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ProductName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ProductType']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Color']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                        echo "<td>₱" . number_format($row['Price'], 2, '.', ',') . "</td>";

                        $entryTimestamp = strtotime($row['EntryTimestamp']);
                        $entryDate = date("Y-m-d", $entryTimestamp);
                        $entryTime = date("h:i A", $entryTimestamp);

                        echo "<td>$entryDate</td>";
                        echo "<td>$entryTime</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchInventory() {
        var searchInput = document.getElementById("searchInput").value.trim();
        var searchCriteria = document.getElementById("searchCriteria").value;

        window.location.href = "?criteria=" + encodeURIComponent(searchCriteria) + "&query=" + encodeURIComponent(searchInput);
    }

    function exportToCSV() {
        var csv = "ProductID,ProductName,ProductType,Color,Description,Quantity,Price,EntryDate,EntryTime\n";

        var rows = document.querySelectorAll("table tr");

        for (var i = 1; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td");

            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText.trim());
            }

            csv += row.join(",") + "\n";
        }

        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "inventory_export.csv";
        link.click();
    }
</script>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>