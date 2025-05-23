<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenfinityaccount";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include("navigation.php");

$query = "SELECT productname FROM product";
$result = $conn->query($query);

$productNames = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productNames[] = $row["productname"];
    }
}
?>

<!-- Page Content -->
<div id="content" class="p-4 p-md-5 pt-5">
    <?php
    if (isset($_GET["status"])) {
        if ($_GET["status"] === "success") {
            echo  '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Info!</strong> Added Successfully!.
                    </div>';
        } elseif ($_GET["status"] === "error") {
            $message = urldecode($_GET["message"]);
            echo  '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> ' . $message . '
                    </div>';
        }
    }
    ?>

    <h2 class="mb-4">Orders Transaction Form</h2>
    <style>
        body {
            background-color: rgb(255, 255, 255);
        }

        .transaction-form {
            margin: 0 auto;
            width: 70%;
            background-color: #089cfc;
            padding: 20px;
            border-radius: 10px;
        }

        .transaction-form label,
        .transaction-form select,
        .transaction-form input {
            display: block;
            margin-bottom: 10px;
            color: white;
        }

        .transaction-form select,
        .transaction-form input[type="text"],
        .transaction-form input[type="number"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .transaction-form button {
            background-color: #475053;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .transaction-form button:hover {
            background-color: #23395d;
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
    <div class="transaction-form">
        <form action="process_transaction.php" method="post">

            <label for="soldto">Name of Sold to:</label>
            <input type="text" id="soldto" name="soldto" placeholder="Enter the name" required style="color: black;">

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter the address" required style="color: black;">

            <div class="product-fields-container">
                <div class="product-fields">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="flex: 1; margin-right: 10px;">
                            <label for="productname">Product Name:</label>
                            <select id="productname" name="productname[]" required style="color: black;">
                                <option value="">Select a product</option>
                                <?php
                                // Fetch product name, type, color, description, and price from the database
                                $query = "SELECT ProductName, ProductType, Color, Description, Price FROM product";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $productName = $row["ProductName"];
                                        $productType = $row["ProductType"];
                                        $color = $row["Color"];
                                        $description = $row["Description"];
                                        $price = $row["Price"];
                                        echo "<option value=\"$productName\" data-type=\"$productType\" data-color=\"$color\" data-description=\"$description\" data-price=\"$price\">$productName</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div style="flex: 1; margin-right: 10px;">
                            <label for="producttype">Product Type:</label>
                            <input type="text" id="producttype" name="producttype[]" placeholder="Product Type" required style="color: black;" readonly>
                        </div>
                        <div style="flex: 1; margin-right: 10px;">
                            <label for="color">Color:</label>
                            <input type="text" id="color" name="color[]" placeholder="Color" required style="color: black;" readonly>
                        </div>
                        <div style="flex: 1;">
                            <label for="description">Description:</label>
                            <input type="text" id="description" name="description[]" placeholder="Description" required style="color: black;" readonly>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div style="flex: 1; margin-right: 10px;">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity[]" placeholder="Enter quantity" required style="color: black;">
                        </div>
                        <div style="flex: 1;">
                            <label for="price">Total Price:</label>
                            <input type="text" id="price" name="price[]" placeholder="Price will be updated based on product selection" required style="color: black;" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <button id="addProductButton" type="button">Add Product</button>
            <button type="submit">Submit</button>

        </form>
    </div>

    <script>
        const addProductButton = document.getElementById("addProductButton");
        const productFieldsContainer = document.querySelector(".product-fields-container");
        const originalProductFields = document.querySelector(".product-fields");
        const productSelect = originalProductFields.querySelector("select[name='productname[]']");
        const productTypeInput = originalProductFields.querySelector("input[name='producttype[]']");
        const colorInput = originalProductFields.querySelector("input[name='color[]']");
        const descriptionInput = originalProductFields.querySelector("input[name='description[]']");
        const priceInput = originalProductFields.querySelector("input[name='price[]']");
        const quantityInput = originalProductFields.querySelector("input[name='quantity[]']");

        addProductButton.addEventListener("click", () => {
            const productFields = originalProductFields.cloneNode(true);
            productFieldsContainer.appendChild(productFields);

            // Clear the cloned product inputs
            const clonedProductInputs = productFields.querySelectorAll("input");
            clonedProductInputs.forEach(input => {
                input.value = "";
            });

            // Attach event listeners to the cloned product fields
            const clonedProductSelect = productFields.querySelector("select[name='productname[]']");
            const clonedProductTypeInput = productFields.querySelector("input[name='producttype[]']");
            const clonedColorInput = productFields.querySelector("input[name='color[]']");
            const clonedDescriptionInput = productFields.querySelector("input[name='description[]']");
            const clonedPriceInput = productFields.querySelector("input[name='price[]']");
            const clonedQuantityInput = productFields.querySelector("input[name='quantity[]']");

            clonedProductSelect.addEventListener("change", () => {
                const selectedOption = clonedProductSelect.options[clonedProductSelect.selectedIndex];
                const selectedType = selectedOption.getAttribute("data-type");
                const selectedColor = selectedOption.getAttribute("data-color");
                const selectedDescription = selectedOption.getAttribute("data-description");
                const selectedPrice = selectedOption.getAttribute("data-price");

                clonedProductTypeInput.value = selectedType || "";
                clonedColorInput.value = selectedColor || "";
                clonedDescriptionInput.value = selectedDescription || "";
                clonedPriceInput.value = selectedPrice || "";
            });

            clonedQuantityInput.addEventListener("input", () => {
                updateTotalPrice(clonedQuantityInput, clonedPriceInput);
            });
        });

        productSelect.addEventListener("change", () => {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const selectedType = selectedOption.getAttribute("data-type");
            const selectedColor = selectedOption.getAttribute("data-color");
            const selectedDescription = selectedOption.getAttribute("data-description");
            const selectedPrice = selectedOption.getAttribute("data-price");

            productTypeInput.value = selectedType || "";
            colorInput.value = selectedColor || "";
            descriptionInput.value = selectedDescription || "";
            priceInput.value = selectedPrice || "";
        });

        quantityInput.addEventListener("input", () => {
            updateTotalPrice(quantityInput, priceInput);
        });

        const updateTotalPrice = (quantityInput, priceInput) => {
            const quantity = parseFloat(quantityInput.value);
            const price = parseFloat(priceInput.value);
            if (!isNaN(quantity) && !isNaN(price)) {
                const total = quantity * price;
                priceInput.value = total.toFixed(2);
            } else {
                priceInput.value = "";
            }
        };
    </script>


    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>


    </body>

    </html>