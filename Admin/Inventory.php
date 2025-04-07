<?php
include("navigation.php");
?>
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add to Inventory</h2>

    <!-- Button to Open the Popup -->
    <button id="openPopupBtn">Add Item to Inventory</button>

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
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        form label {
            display: block;
            margin-top: 10px;
        }

        form input,
        form textarea,
        form button {
            margin-top: 5px;
            padding: 8px;
            font-size: 16px;
            width: 100%;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
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

    // Function to add data to the database
    function addDataToDatabase($conn, $data)
    {
        $productName = $data['product_name'];
        $productType = $data['product_type'];
        $color = $data['color'];
        $description = $data['description'];
        $quantity = $data['quantity'];
        $price = $data['price'];
        $entryDate = $data['entry_date'];
        $entryTime = $data['entry_time'];

        // Insert into Inventory
        $sql = "INSERT INTO Inventory (InventoryID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp) 
                VALUES (NULL, '$productName', '$productType', '$color', '$description', '$quantity', '$price', CONCAT('$entryDate', ' ', '$entryTime'))";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    // Handle form submission for adding an item
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_item"])) {
        $data = [
            'product_name' => $_POST['product_name'],
            'product_type' => $_POST['product_type'],
            'color' => $_POST['color'],
            'description' => $_POST['description'],
            'quantity' => $_POST['quantity'],
            'price' => $_POST['price'],
            'entry_date' => $_POST['entry_date'],
            'entry_time' => $_POST['entry_time']
        ];

        $result = addDataToDatabase($conn, $data);
        if ($result === true) {
            echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info!</strong> Added Successfully!.
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> Failed to add item.
                  </div>';
        }
    }

    // Handle form submission for editing an item
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_item"])) {
        $inventory_id = $_POST['inventory_id'];
        $price = $_POST['edit_price'];

        // Update the database
        $sql = "UPDATE Inventory SET Price = ? WHERE InventoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $price, $inventory_id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info!</strong> Updated Successfully!.
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
            echo "<tr><th>InventoryID</th><th>ProductName</th><th>Product Type</th><th>Color</th><th>Description</th><th>Quantity</th><th>Price</th><th>EntryDate</th><th>EntryTime</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['InventoryID'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['ProductType'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>";
                echo '<form method="POST">';
                echo '<input type="hidden" name="inventory_id" value="' . $row['InventoryID'] . '">';
                echo '<input type="text" name="edit_price" value="' . $row['Price'] . '" style="width: 80px;">';
                echo '<button type="submit" name="edit_item">Edit</button>';
                echo '</form>';
                echo "</td>";
                $entryTimestamp = strtotime($row['EntryTimestamp']);
                $entryDate = date("Y-m-d", $entryTimestamp);
                $entryTime = date("h:i A", $entryTimestamp);
                echo "<td>" . $entryDate . "</td>";
                echo "<td>" . $entryTime . "</td>";
                echo '<td><button class="delete-button" data-inventory-id="' . $row['InventoryID'] . '">Delete</button></td>';
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <!-- The Modal (Popup Form) -->
    <div id="popupForm" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Inventory Item</h2>
            <form method="POST">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>

                <label for="product_type">Product Type:</label>
                <input type="text" id="product_type" name="product_type" required>

                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>

                <label for="entry_date">Entry Date:</label>
                <input type="date" id="entry_date" name="entry_date" required>

                <label for="entry_time">Entry Time:</label>
                <input type="time" id="entry_time" name="entry_time" required>

                <button type="submit" name="add_item">Add Item</button>
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("popupForm");

        // Get the button that opens the modal
        var btn = document.getElementById("openPopupBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Delete button functionality
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