<?php
include("navigation.php");
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Product List</h2>
    <!-- Add a legend section for the quantity borders -->
    <div class="legend-container">
        <h4>Legend:</h4>
        <div class="legend-item">
            <div class="legend-color red-border"></div>
            <div class="legend-text">Quantity &lt; 30</div>
        </div>
        <div class="legend-item">
            <div class="legend-color yellow-border"></div>
            <div class="legend-text">Quantity: 30 - 50</div>
        </div>
        <div class="legend-item">
            <div class="legend-color green-border"></div>
            <div class="legend-text">Quantity &gt; 50</div>
        </div>
    </div>

    <style>
        body {
            background-color: rgb(255, 255, 255);
        }

        /* CSS styles for the legend */
        .legend-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border-radius: 5px;
        }

        /* Define colors for the legend items */
        .legend-color.red-border {
            background-color: red;
        }

        .legend-color.yellow-border {
            background-color: yellow;
        }

        .legend-color.green-border {
            background-color: green;
        }

        .legend-text {
            font-size: 14px;
        }

        .posted-data {
            margin-left: 50px;
            margin-right: 50px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            /* Allow boxes to wrap to the next line */
            justify-content: flex-start;
            /* Start from left to right */
        }

        .product-box {
            background-color: #089cfc;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            width: 350px;
            /* Adjust the width as needed */
            height: 410px;
            /* Adjust the height as needed */
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column;
            /* Stack the inner elements vertically */
            justify-content: space-between;
            /* Add space between the inner elements */
        }

        .product-info {
            font-size: 15px;
            /* Adjust the font size as needed */
            text-align: left;
            /* Align the text to the left within product-info */
            padding: 5px;
            /* Add padding to create space around the text */
        }

        .red-border {
            border: 10px solid red;
        }

        .yellow-border {
            border: 10px solid yellow;
        }

        .green-border {
            border: 10px solid green;
        }

        h3 {
            font-size: 20px;
            /* Adjust the title font size as needed */
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        /* Add CSS for alerts */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .alert {
            position: relative;
            width: 300px;
            margin-bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .alert.show {
            opacity: 1;
        }
    </style>


    <div class="alert-container" id="alert-container"></div>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT ProductID, ProductName, ProductType, Color, Description, Quantity, Price FROM product";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="product-container">'; // Start product container
        while ($row = $result->fetch_assoc()) {
            $quantity = (int)$row['Quantity']; // Convert quantity to an integer
            $borderClass = '';

            // Determine the border class based on quantity
            if ($quantity <= 29) {
                $borderClass = 'red-border';
            } elseif ($quantity >= 30 && $quantity <= 50) {
                $borderClass = 'yellow-border';
            } else {
                $borderClass = 'green-border';
            }

            echo '<div class="product-box ' . $borderClass . '">';
            echo '<h3>' . $row['ProductName'] . '</h3>';
            echo '<div class="product-info">';
            echo '<p><strong>Product ID:</strong> ' . $row['ProductID'] . '</p>';
            echo '<p>Product Type: ' . $row['ProductType'] . '</p>';
            echo '<p>Color: ' . $row['Color'] . '</p>';
            echo '<p>Description: ' . $row['Description'] . '</p>';
            echo '<p>Quantity: ' . $row['Quantity'] . '</p>';
            echo '<p>Price: ₱' . number_format($row['Price'], 2, '.', ',') . '</p>';

            // Container for buttons
            echo '<div class="button-container">';

            // Add an "Edit" button for each product


            // Add a form for deleting each product with a confirmation dialog
            echo '<form action="delete_product.php" method="post" class="delete-form" onsubmit="return confirmDelete();">';
            echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
            echo '</form>';

            echo '</div>'; // Close button-container

            echo '</div>'; // Close product-info
            echo '</div>'; // Close product-box

            // Create an edit form for each product
            echo '<div class="edit-form" style="display:none;" id="edit-form-' . $row['ProductID'] . '">';
            echo '<h3>Edit Product</h3>';
            echo '<form action="update_product.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
            echo '<label for="edit-product-name">Product Name:</label>';
            echo '<input type="text" name="edit-product-name" id="edit-product-name" value="' . htmlspecialchars($row['ProductName']) . '"><br>';
            echo '<label for="edit-product-type">Product Type:</label>';
            echo '<input type="text" name="edit-product-type" id="edit-product-type" value="' . htmlspecialchars($row['ProductType']) . '"><br>';
            echo '<label for="edit-color">Color:</label>';
            echo '<input type="text" name="edit-color" id="edit-color" value="' . htmlspecialchars($row['Color']) . '"><br>';
            echo '<label for="edit-description">Description:</label>';
            echo '<input type="text" name="edit-description" id="edit-description" value="' . htmlspecialchars($row['Description']) . '"><br>';
            echo '<label for="edit-price">Price:</label>';
            echo '<input type="text" name="edit-price" id="edit-price" value="' . $row['Price'] . '"><br>';
            // Quantity is not editable
            echo '<input type="submit" value="Save">';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>'; // Close product container
    } else {
        echo 'No data found.';
    }
    ?>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to Archive this product?");
        }
    </script>

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".edit-button").click(function() {
                // Get the product ID from the data attribute
                var productId = $(this).data("product-id");

                // Hide all other edit forms (if any)
                $(".edit-form").hide();

                // Show the edit form for the clicked product
                $("#edit-form-" + productId).show();
            });
        });
    </script>

    <script>
        document.getElementById("enterButton").addEventListener("click", function(event) {
            var qrData = document.getElementById("qrData").value.trim(); // Get and trim QR data input

            if (qrData !== "") {
                // Assuming the quantity is included in the QR data, extract it
                var dataArray = qrData.split(',');
                if (dataArray.length >= 7) { // Assuming quantity is the 7th element in the QR data
                    var quantity = dataArray[6]; // Extract the quantity

                    // Send the data to the server using AJAX or form submission
                    // You can display the success or error message based on the server's response

                    // For demonstration purposes, we'll simulate a server response
                    var serverResponse = true; // Change this to the actual server response

                    if (serverResponse) {
                        displayAlert("success", "Added Successfully!");
                    } else {
                        displayAlert("danger", "Error adding data.");
                    }

                    // Prevent the form from submitting (you can remove this line if not needed)
                    event.preventDefault();
                } else {
                    event.preventDefault();
                }
            }
        });

        // Function to display an alert
        function displayAlert(type, message) {
            var alertContainer = document.getElementById("alert-container");
            var alertElement = document.createElement("div");

            alertElement.className = "alert alert-" + type + " alert-dismissible show";
            alertElement.innerHTML = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Info!</strong> ' + message;

            alertContainer.innerHTML = ''; // Clear any existing alerts
            alertContainer.appendChild(alertElement);

            // Automatically hide the alert after 5 seconds
            setTimeout(function() {
                alertElement.classList.remove("show");
            }, 5000);
        }
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</div>
</body>

</html>