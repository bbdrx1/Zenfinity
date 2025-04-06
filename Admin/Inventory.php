<?php
include("navigation.php");
?>
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add to Inventory</h2>

    <!-- Button to trigger the popup form -->
    <button id="openFormButton">Add Item to Inventory</button>
    <br><br>

    <!-- Popup Form -->
    <div id="popupForm" class="popup-form">
        <div class="form-container">
            <span class="close-button">&times;</span>
            <h3>Add New Item</h3>
            <form method="POST" id="addItemForm">
                <label for="productName">Product Name:</label>
                <input type="text" name="productName" id="productName" placeholder="Enter Product Name" required><br><br>

                <label for="productType">Product Type:</label>
                <input type="text" name="productType" id="productType" placeholder="Enter Product Type" required><br><br>

                <label for="color">Color:</label>
                <input type="text" name="color" id="color" placeholder="Enter Color" required><br><br>

                <label for="description">Description:</label>
                <input type="text" name="description" id="description" placeholder="Enter Description" required><br><br>

                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter Quantity" required><br><br>

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" placeholder="Enter Price" required><br><br>

                <label for="entryDate">Entry Date:</label>
                <input type="date" name="entryDate" id="entryDate" required><br><br>

                <label for="entryTime">Entry Time:</label>
                <input type="time" name="entryTime" id="entryTime" required><br><br>

                <button type="submit" name="addItem">Submit</button>
            </form>
        </div>
    </div>

    <!-- Transfer Data Form -->
    <form method="POST" action="transfer_data.php" id="transferForm">
        <button id="transferButton" type="submit" name="transfer_data">Transfer to TheInventory</button>
    </form>
    <br>

    <style>
        body {
            background-color: #66c1ff;
        }

        .popup-form {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
        }

        .form-container {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 400px;
            text-align: center;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
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

        th,
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: white;
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
        }

        .edit-mode input[type="number"],
        .edit-mode input[type="text"] {
            background-color: #fff;
            border: 1px solid #ccc;
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

    function addDataToDatabase($conn, $productName, $productType, $color, $description, $quantity, $price, $entryDate, $entryTime)
    {
        // Combine entry date and time into a single timestamp
        $entryTimestamp = $entryDate . ' ' . $entryTime;

        // Insert data into the Inventory table
        $sql = "INSERT INTO Inventory (InventoryID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp) 
                VALUES (NULL, '$productName', '$productType', '$color', '$description', '$quantity', '$price', '$entryTimestamp')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function updateDataInDatabase($conn, $inventoryID, $quantity, $price)
    {
        // Update the Quantity and Price in the Inventory table
        $sql = "UPDATE Inventory SET Quantity = '$quantity', Price = '$price' WHERE InventoryID = '$inventoryID'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addItem"])) {
        $productName = $_POST["productName"];
        $productType = $_POST["productType"];
        $color = $_POST["color"];
        $description = $_POST["description"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];
        $entryDate = $_POST["entryDate"];
        $entryTime = $_POST["entryTime"];

        $result = addDataToDatabase($conn, $productName, $productType, $color, $description, $quantity, $price, $entryDate, $entryTime);

        if ($result === true) {
            echo '<div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Info!</strong> Item added successfully.
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Error!</strong> Failed to add item.
                  </div>';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_button"])) {
        $inventoryID = $_POST["inventory_id"];
        $newQuantity = $_POST["edit_quantity"];
        $newPrice = $_POST["edit_price"];

        $result = updateDataInDatabase($conn, $inventoryID, $newQuantity, $newPrice);

        if ($result === true) {
            echo '<div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Info!</strong> Item updated successfully.
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Error!</strong> Failed to update item.
                  </div>';
        }
    }
    ?>

    <div class="table-container">
        <?php
        $sql = "SELECT * FROM Inventory ORDER BY EntryTimestamp DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr>
                    <th>InventoryID</th>
                    <th>ProductName</th>
                    <th>Product Type</th>
                    <th>Color</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>EntryDate</th>
                    <th>EntryTime</th>
                    <th>Action</th>
                  </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['InventoryID'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo '<td>
                        <form method="POST" action="">
                            <input type="hidden" name="inventory_id" value="' . $row['InventoryID'] . '">
                            <input type="number" name="edit_quantity" value="' . $row['Quantity'] . '" disabled>
                        </form>
                      </td>';
                echo '<td>
                        <form method="POST" action="">
                            <input type="hidden" name="inventory_id" value="' . $row['InventoryID'] . '">
                            <input type="number" name="edit_price" value="' . $row['Price'] . '" disabled>
                        </form>
                      </td>';
                $entryTimestamp = strtotime($row['EntryTimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp); // Format date
                $entryTime = date("h:i A", $entryTimestamp); // Format time in 12-hour
                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";
                echo '<td>
                        <button class="edit-button" data-inventory-id="' . $row['InventoryID'] . '">Edit</button>
                        <button class="save-button" style="display: none;" data-inventory-id="' . $row['InventoryID'] . '">Save</button>
                      </td>';
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items in the inventory.</p>";
        }
        ?>
    </div>

    <script>
        // Open the popup form
        document.getElementById("openFormButton").addEventListener("click", function() {
            document.getElementById("popupForm").style.display = "block";
        });

        // Close the popup form
        document.querySelector(".close-button").addEventListener("click", function() {
            document.getElementById("popupForm").style.display = "none";
        });

        // Close the popup form if the user clicks outside of it
        window.addEventListener("click", function(event) {
            var popup = document.getElementById("popupForm");
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });

        // Enable Edit Mode
        document.querySelectorAll(".edit-button").forEach(function(button) {
            button.addEventListener("click", function() {
                var inventoryID = this.getAttribute("data-inventory-id");
                var row = this.closest("tr");

                // Enable input fields
                row.querySelector("input[name='edit_quantity']").disabled = false;
                row.querySelector("input[name='edit_price']").disabled = false;

                // Show the Save button and hide the Edit button
                row.querySelector(".save-button").style.display = "inline-block";
                this.style.display = "none";
            });
        });

        // Save Changes
        document.querySelectorAll(".save-button").forEach(function(button) {
            button.addEventListener("click", function() {
                var inventoryID = this.getAttribute("data-inventory-id");
                var row = this.closest("tr");

                // Get updated values
                var newQuantity = row.querySelector("input[name='edit_quantity']").value;
                var newPrice = row.querySelector("input[name='edit_price']").value;

                // Submit the form
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "";

                var input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "inventory_id";
                input1.value = inventoryID;

                var input2 = document.createElement("input");
                input2.type = "hidden";
                input2.name = "edit_quantity";
                input2.value = newQuantity;

                var input3 = document.createElement("input");
                input3.type = "hidden";
                input3.name = "edit_price";
                input3.value = newPrice;

                form.appendChild(input1);
                form.appendChild(input2);
                form.appendChild(input3);
                document.body.appendChild(form);
                form.submit();
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