<?php
include("navigation.php");
?>
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add to Inventory</h2>

    <!-- Add Item Button -->
    <button id="addItemButton">Add Item to Inventory</button>
    <br><br>

    <!-- Transfer Form -->
    <form method="POST" action="transfer_data.php" id="transferForm">
        <button id="transferButton" type="submit" name="transfer_data">Transfer to TheInventory</button>
    </form>
    <br>

    <!-- Popup Form for Adding Items -->
    <div id="popupForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Add New Item</h3>
        <form method="POST" id="manualAddForm">
            <label for="product_id">Product ID:</label>
            <input type="text" name="product_id" id="product_id" required><br><br>

            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required><br><br>

            <label for="product_type">Product Type:</label>
            <input type="text" name="product_type" id="product_type" required><br><br>

            <label for="color">Color:</label>
            <input type="text" name="color" id="color" required><br><br>

            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required><br><br>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br><br>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required><br><br>

            <label for="entry_date">Entry Date:</label>
            <input type="date" name="entry_date" id="entry_date" required><br><br>

            <label for="entry_time">Entry Time:</label>
            <input type="time" name="entry_time" id="entry_time" required><br><br>

            <button type="submit" name="add_item">Save</button>
            <button type="button" id="cancelButton">Cancel</button>
        </form>
    </div>

    <!-- Popup Form for Editing Items -->
    <div id="editPopupForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Edit Product Details</h3>
        <form method="POST" id="editForm">
            <input type="hidden" name="inventory_id" id="edit_inventory_id">
            <label for="edit_product_id">Product ID:</label>
            <input type="text" name="product_id" id="edit_product_id" required><br><br>

            <label for="edit_product_name">Product Name:</label>
            <input type="text" name="product_name" id="edit_product_name" required><br><br>

            <label for="edit_product_type">Product Type:</label>
            <input type="text" name="product_type" id="edit_product_type" required><br><br>

            <label for="edit_color">Color:</label>
            <input type="text" name="color" id="edit_color" required><br><br>

            <label for="edit_description">Description:</label>
            <input type="text" name="description" id="edit_description" required><br><br>

            <label for="edit_quantity">Quantity:</label>
            <input type="number" name="quantity" id="edit_quantity" required><br><br>

            <label for="edit_price">Price:</label>
            <input type="number" step="0.01" name="price" id="edit_price" required><br><br>

            <button type="submit" name="save_edit">Save Changes</button>
            <button type="button" id="cancelEditButton">Cancel</button>
        </form>
    </div>

    <!-- Overlay for Popup -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    <style>
        body {
            background-color: rgb(255, 255, 255);
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

    // Handle manual form submission (Add Item)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_item"])) {
        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $product_type = $_POST["product_type"];
        $color = $_POST["color"];
        $description = $_POST["description"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];
        $entry_date = $_POST["entry_date"];
        $entry_time = $_POST["entry_time"];

        // Combine date and time into a single timestamp
        $entry_timestamp = $entry_date . " " . $entry_time;

        // Check if ProductID exists in the Product table
        $productQuery = "SELECT * FROM Product WHERE ProductID = '$product_id'";
        $productResult = mysqli_query($conn, $productQuery);

        if (mysqli_num_rows($productResult) > 0) {
            // Insert into Inventory table
            $sql = "INSERT INTO Inventory (InventoryID, ProductID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp)
                    VALUES (NULL, '$product_id', '$product_name', '$product_type', '$color', '$description', '$quantity', '$price', '$entry_timestamp')";
            if (mysqli_query($conn, $sql)) {
                echo '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Info!</strong> Added Successfully!
                      </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Failed to add item.
                      </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> Product is not registered.
                  </div>';
        }
    }

    // Handle edit form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_edit"])) {
        $inventory_id = $_POST["inventory_id"];
        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $product_type = $_POST["product_type"];
        $color = $_POST["color"];
        $description = $_POST["description"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];

        // Update the Inventory table
        $updateQuery = "UPDATE Inventory 
                        SET ProductID = '$product_id', ProductName = '$product_name', ProductType = '$product_type', 
                            Color = '$color', Description = '$description', Quantity = '$quantity', Price = '$price'
                        WHERE InventoryID = '$inventory_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info!</strong> Product updated successfully!
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> Failed to update product.
                  </div>';
        }
    }
    ?>

    <!-- Inventory Table -->
    <div class="table-container">
        <?php
        $sql = "SELECT * FROM Inventory ORDER BY EntryTimestamp DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>InventoryID</th><th>ProductID</th><th>ProductName</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>EntryDate</th><th>EntryTime</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['InventoryID'] . "</td>";
                echo "<td>" . $row['ProductID'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>" . $row['Price'] . "</td>";
                $entryTimestamp = strtotime($row['EntryTimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp);
                $entryTime = date("h:i A", $entryTimestamp);
                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";
                echo '<td><button class="edit-button" data-inventory-id="' . $row['InventoryID'] . '">Edit</button> | <button class="delete-button" data-inventory-id="' . $row['InventoryID'] . '">Delete</button></td>';
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <!-- JavaScript for Popup Forms -->
    <script>
        const addItemButton = document.getElementById("addItemButton");
        const popupForm = document.getElementById("popupForm");
        const overlay = document.getElementById("overlay");
        const cancelButton = document.getElementById("cancelButton");

        // Show Add Item Popup Form
        addItemButton.addEventListener("click", () => {
            popupForm.style.display = "block";
            overlay.style.display = "block";
        });

        // Hide Add Item Popup Form
        cancelButton.addEventListener("click", () => {
            popupForm.style.display = "none";
            overlay.style.display = "none";
        });

        // Edit Button Functionality
        const editPopupForm = document.getElementById("editPopupForm");
        const cancelEditButton = document.getElementById("cancelEditButton");

        document.querySelectorAll(".edit-button").forEach(function(button) {
            button.addEventListener("click", function() {
                var inventoryID = this.getAttribute("data-inventory-id");
                fetch(`get_item_details.php?inventory_id=${inventoryID}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("edit_inventory_id").value = data.InventoryID;
                        document.getElementById("edit_product_id").value = data.ProductID;
                        document.getElementById("edit_product_name").value = data.ProductName;
                        document.getElementById("edit_product_type").value = data.ProductType;
                        document.getElementById("edit_color").value = data.Color;
                        document.getElementById("edit_description").value = data.Description;
                        document.getElementById("edit_quantity").value = data.Quantity;
                        document.getElementById("edit_price").value = data.Price;

                        editPopupForm.style.display = "block";
                        overlay.style.display = "block";
                    });
            });
        });

        // Hide Edit Popup Form
        cancelEditButton.addEventListener("click", () => {
            editPopupForm.style.display = "none";
            overlay.style.display = "none";
        });

        // Delete Button Functionality
        document.querySelectorAll(".delete-button").forEach(function(button) {
            button.addEventListener("click", function() {
                var inventoryID = this.getAttribute("data-inventory-id");
                if (confirm("Are you sure you want to delete this item?")) {
                    var form = document.createElement("form");
                    form.method = "POST";
                    form.action = "delete_item.php";
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "inventory_id";
                    input.value = inventoryID;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
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