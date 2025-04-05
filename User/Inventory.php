<?php
include("navigation.php");
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add to Inventory</h2>
    <form method="POST" id="qrForm">
        <input type="text" name="qr_data" id="qrData" placeholder="Scan QR Code">
        <button id="enterButton">Add Item to Inventory</button>
    </form>
    <br>
    <form method="POST" action="transfer_data.php" id="transferForm">
        <button id="transferButton" type="submit" name="transfer_data">Transfer to TheInventory</button>
    </form>
    <br>

    <style>
        body {
            background-color: #66c1ff;
        }

        .posted-data {
            margin-left: 50px;
            margin-right: 50px;
        }

        .table-container {
            max-height: 800px;
            overflow-y: auto;
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
            top: 0; /* Fixed position for the table header */
        }

        tr:hover {
            background-color: #23395d;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
    </style>

    <?php
    // Database connection parameters
    $host = "localhost"; // Replace with your database host
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $database = "zenfinityaccount";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function addDataToDatabase($conn, $data) {
        // Split the comma-separated data into an array
        $dataArray = explode(',', $data);

        if (count($dataArray) >= 7) { // Assuming quantity is the 6th element and price is the 7th element in the QR data
            $product_id = $dataArray[0];
            $product_name = $dataArray[1];
            $productType = $dataArray[2];
            $color = $dataArray[3]; // Extract the color
            $description = $dataArray[4];
            $quantity = $dataArray[5]; // Extract the quantity
            $price = $dataArray[6]; // Extract the price

            // Check if the ProductID exists in the Product table
            $productQuery = "SELECT * FROM Product WHERE ProductID = '$product_id'";
            $productResult = mysqli_query($conn, $productQuery);

            if (mysqli_num_rows($productResult) > 0) {
                // ProductID exists, proceed with inserting into Inventory
                // Get the current date and time
                $entryTimestamp = date("Y-m-d H:i:s");

                $sql = "INSERT INTO Inventory (InventoryID, ProductID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp) 
                        VALUES (NULL, '$product_id', '$product_name', '$productType', '$color', '$description', '$quantity', '$price', '$entryTimestamp')";

                if (mysqli_query($conn, $sql)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // ProductID doesn't exist in the Product table
                return "Product is not registered";
            }
        } else {
            return false; // Data does not contain enough values
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["qr_data"])) {
        $qr_data = $_POST["qr_data"];

        if (!empty($qr_data)) {
            $result = addDataToDatabase($conn, $qr_data);
            
            if ($result === true) {
                echo  '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Info!</strong> Added Successfully!.
                        </div>';
            } elseif ($result === "Product is not registered") {
                echo  '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Product is not registered.
                        </div>';
            } else {
                echo "Error adding data.";
            }
        }
    }
    ?>

    <div class="table-container">
        <?php
        $sql = "SELECT * FROM Inventory ORDER BY EntryTimestamp DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>InventoryID</th><th>ProductID</th><th>ProductName</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>EntryDate</th><th>EntryTime</th></tr>";
            echo "<tbody>"; // Start of table body

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['InventoryID'] . "</td>";
                echo "<td>" . $row['ProductID'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>"; // Display Color
                echo "<td>" . $row['Description'] . "</td>"; // Display Description
                // The rest of your table columns...

                echo '<td>
                        <form method="POST" action="update_quantity.php">
                            <input type="hidden" name="inventory_id" value="' . $row['InventoryID'] . '">
                            <input type="number" name="edit_quantity" value="' . $row['Quantity'] . '" disabled>
                        </form>
                      </td>';

                echo "<td>" . $row['Price'] . "</td>";

                $entryTimestamp = strtotime($row['EntryTimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp); // Format date
                $entryTime = date("h:i A", $entryTimestamp); // Format time in 12-hour

                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";

                // Add a "Delete" button for deleting the item
               

                echo "</tr>";
            }
        }
        ?>
    </div>

    <?php
    $success = isset($_GET['success']) ? $_GET['success'] : false;
    $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';

    // Check if the transfer was successful
    if ($success) {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Info!</strong> ' . $message . '.
              </div>';
    }
    ?>

    <script>
        document.getElementById("enterButton").addEventListener("click", function (event) {
            var qrData = document.getElementById("qrData").value.trim(); // Get and trim QR data input

            if (qrData !== "") {
                // Assuming the quantity is included in the QR data, extract it
                var dataArray = qrData.split(',');
                if (dataArray.length >= 7) { // Assuming quantity is the 7th element in the QR data
                    var quantity = dataArray[6]; // Extract the quantity
                    document.getElementById("qrForm").submit();
                } else {
                    event.preventDefault();
                }
            }
        });
    </script>

    <script>
        document.querySelectorAll(".delete-button").forEach(function (button) {
            button.addEventListener("click", function () {
                var inventoryID = this.getAttribute("data-inventory-id"); // Change this to "data-inventory-id"
                console.log("Deleting item with InventoryID: " + inventoryID);

                if (confirm("Are you sure you want to delete this item?")) {

                    var form = document.createElement("form");
                    form.method = "POST";
                    form.action = "delete_item.php"; // Replace with the correct URL

                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "inventory_id"; // Change this to "inventory_id"
                    input.value = inventoryID;

                    form.appendChild(input);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll(".edit-button").forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                // Find the parent form element
                var form = this.closest("form");

                // Enable the quantity input field
                form.querySelector("input[type='number']").disabled = false;

                // Toggle the display of "Edit" and "Save" buttons
                form.querySelector(".edit-button").style.display = "none";
                form.querySelector(".save-button").style.display = "inline-block";
            });
        });
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</div>

</body>
</html>
