<?php
include("navigation.php");
?>

<style>
    body {
        background-color: rgb(255, 255, 255);
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
        color: black;
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

    .search-container button {
        background-color: #475053;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
</style>

<?php
// Database connection parameters
$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "zenfinityaccount";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Inventory</h2>

    <!-- Search bar for ProductID -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search by ProductID...">
        <button onclick="searchInventory()">Search</button>
    </div>

    <div class="table-container">
        <?php
        // Check if a search query is provided
        if (isset($_GET['criteria']) && isset($_GET['query'])) {
            $searchCriteria = $_GET['criteria'];
            $searchQuery = $_GET['query'];

            if ($searchCriteria === 'EntryTimestamp') {
                $sql = "SELECT * FROM theinventory WHERE DATE(EntryTimestamp) LIKE '%$searchQuery%' ORDER BY EntryTimestamp DESC";
            } else {
                $sql = "SELECT * FROM theinventory WHERE $searchCriteria LIKE '%$searchQuery%' ORDER BY EntryTimestamp DESC";
            }
        } else {
            $sql = "SELECT * FROM theinventory ORDER BY EntryTimestamp DESC";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ProductID</th><th>ProductName</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>EntryDate</th><th>EntryTime</th></tr>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ProductID'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>₱" . number_format($row['Price'], 2, '.', ',') . "</td>";

                $entryTimestamp = strtotime($row['EntryTimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp);
                $entryTime = date("h:i A", $entryTimestamp);

                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<p>No data available in theinventory table.</p>";
        }
        ?>
    </div>
</div>

<script>
    function searchInventory() {
        var searchInput = document.getElementById("searchInput").value.trim();
        var searchCriteria = 'ProductID';

        // Reload the page with search parameters
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