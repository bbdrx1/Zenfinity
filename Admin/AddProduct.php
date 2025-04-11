<?php
include("navigation.php");
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add Product</h2>

    <style>
        body {
            background-color: rgb(255, 255, 255);
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #089cfc;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
        }

        input[type="text"],
        input[type="password"],
        select,
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #89d0ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #23395d;
        }

        .error {
            color: #ff0000;
            margin-bottom: 10px;
        }
    </style>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $productID = $productName = $productType = $color = $description = $price = "";
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize form input
        $productID = mysqli_real_escape_string($conn, $_POST["productID"]);
        $productName = mysqli_real_escape_string($conn, $_POST["productName"]);
        $productType = mysqli_real_escape_string($conn, $_POST["productType"]);
        $color = mysqli_real_escape_string($conn, $_POST["color"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $price = floatval($_POST["price"]);

        $sqlInsert = "INSERT INTO Product (ProductID, ProductName, ProductType, Color, Description, Price)
                  VALUES ('$productID', '$productName', '$productType', '$color', '$description', $price)";

        if (mysqli_query($conn, $sqlInsert)) {
            $successMessage = "Product added successfully!";
        } else {
            $error = "Error adding product: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    ?>

    <div class="form-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="productID">Product ID:</label>
            <input type="number" name="productID" required min="1" step="1">

            <label for="productName">Product Name:</label>
            <input type="text" name="productName" required>

            <label for="productType">Product Type:</label>
            <input type="text" name="productType" required>

            <label for="color">Color:</label>
            <input type="text" name="color" required>

            <label for="description">Description:</label>
            <textarea name="description" required style="width: 100%;"></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required><br>
            <
                <input type="submit" name="submit" value="Add Product">
        </form>

        <?php
        if ($error !== "") {
            echo "<p>Error: $error</p>";
        }
        ?>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</div>
</body>

</html>