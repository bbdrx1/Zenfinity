<?php include("navigation.php"); ?>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Warehouse</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #66c1ff;
        }

        .chart-container {
            margin-top: -30px;
            padding-bottom: 0px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0; /* Adjust top and bottom margin */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh; /* 100% of the viewport height */
            justify-content: center;
        }

        #warehouse {
            position: relative;
            width: 100%; /* Adjusted width to 100% */
            flex: 1; /* Takes up remaining vertical space */
            border: 1px solid #000;
            display: flex;
            flex-wrap: wrap;
        }

        .cell {
            width: calc(20% - 10px); /* 20% with 10px spacing */
            height: calc(20% - 10px);
            box-sizing: border-box;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 5px;
            font-size: 12px; /* Reduced font size */
            transition: background-color 0.3s;
        }

        .cell:hover {
            background-color: #f0f0f0;
        }

        .product {
            font-weight: bold;
        }

        .details {
            display: none;
            margin-top: 10px;
        }

        select {
            margin-top: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Product Warehouse</h2>

    <div id="warehouse">
        <?php
        // Fetch products from the database
        $result = $conn->query("SELECT * FROM product");

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = [$row['ProductName'], $row['ProductType'], $row['Color'], $row['Description']];
        }

       
   for ($row = 1; $row <= 5; $row++) {
    for ($col = 1; $col <= 5; $col++) {
        $cellId = "cell-$row-$col";
        $product = getProductInCell($row, $col, $products);
        echo "<div class='cell' id='$cellId' data-row='$row' data-col='$col' onclick='handleCellClick(this)'>";
        if ($product) {
            echo "<span class='product'>$product[0]</span>";
        } else {
            echo 'Add';
        }
        echo '</div>';
    }
}

function getProductInCell($row, $col, $products) {
    foreach ($products as $product) {
        if ($product[2] == $row && $product[3] == $col) {
            return $product;
        }
    }
    return null;
}
?>
    </div>

    <div id="productDetails" class="details">
        <h3>Product Details</h3>
        <p id="selectedProduct"></p>
        <button onclick="removeProduct()">Remove Product</button>
    </div>

    <select id="productList" style="display: none;">
        <option value="" selected disabled>Select a product</option>
        <?php
        // Populate the dropdown with product names from the database
        foreach ($products as $product) {
            echo "<option value='{$product[0]}'>{$product[0]}</option>";
        }
        ?>
    </select>
    <button onclick="addProductToDatabase()">Add Product</button>

</div>

<script>
    function handleCellClick(cell) {
        const row = cell.getAttribute("data-row");
        const col = cell.getAttribute("data-col");
        const productDetails = document.getElementById("selectedProduct");

        if (cell.innerText === 'Add') {
            // Display the product list dropdown
            document.getElementById("productList").style.display = "block";
            document.getElementById("productList").setAttribute("data-row", row);
            document.getElementById("productList").setAttribute("data-col", col);
        } else {
            // Display details of the existing product
            const productName = cell.innerText;
            productDetails.innerText = `Product: ${productName}, Location: ${row}-${col}`;
            document.getElementById("productList").style.display = "none";
        }

        const detailsDiv = document.getElementById("productDetails");
        detailsDiv.style.display = "block";
    }

    function addProductToDatabase() {
        // Get the selected product from the dropdown
        const selectElement = document.getElementById("productList");
        const selectedProductName = selectElement.value;

        if (selectedProductName) {
            const row = selectElement.getAttribute("data-row");
            const col = selectElement.getAttribute("data-col");

            // Save the association in localStorage
            const cellId = `cell-${row}-${col}`;
            localStorage.setItem(cellId, selectedProductName);

            // Update the cell content with the selected product name
            const cell = document.getElementById(cellId);
            cell.innerHTML = `<span class='product'>${selectedProductName}</span>`;
        }

        // Clear the selected product and hide the dropdown
        selectElement.value = "";
        selectElement.style.display = "none";
    }

    function showProductList() {
        // Show the product list dropdown
        const productList = document.getElementById("productList");
        productList.style.display = "block";
    }

    function removeProduct() {
        const productDetails = document.getElementById("selectedProduct");
        const productName = productDetails.innerText.split(":")[1].trim();
        const row = productDetails.innerText.split(":")[2].split("-")[0].trim();
        const col = productDetails.innerText.split(":")[2].split("-")[1].trim();

        // Remove the association from localStorage
        const cellId = `cell-${row}-${col}`;
        localStorage.removeItem(cellId);

        // Update the cell content to 'Add'
        const cell = document.getElementById(cellId);
        cell.innerHTML = 'Add';

        // In this example, I'm using a dummy alert as a placeholder
        alert(`Product "${productName}" removed from the cell and the association removed from storage`);
    }

    // Load saved associations from localStorage on page load
    window.onload = function () {
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            const value = localStorage.getItem(key);
            const cell = document.getElementById(key);
            if (cell) {
                cell.innerHTML = `<span class='product'>${value}</span>`;
            }
        }
    };
</script>



<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
