<?php
include("navigation.php");
?>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add Product</h2>

    <style>
        body {
            background-color: rgb(247, 247, 247);
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
        input[type="email"],
        input[type="file"],
        input[type="number"] {
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

        .success {
            color: green;
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

    $productName = $productType = $color = $description = $price = $quantity = $imageURL = "";
    $error = "";
    $successMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize form input
        $productID = intval($_POST["productID"]);
        $productName = mysqli_real_escape_string($conn, $_POST["productName"]);
        $productType = mysqli_real_escape_string($conn, $_POST["productType"]);
        $color = mysqli_real_escape_string($conn, $_POST["color"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $price = floatval($_POST["price"]);
        $quantity = intval($_POST["quantity"]);

        // Handle image upload
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $imageURL = $targetFilePath;
                } else {
                    $error = "Error uploading image.";
                }
            } else {
                $error = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            $error = "No image uploaded or an error occurred.";
        }

        if ($error === "") {
            // Insert into product table
            $sqlInsertProduct = "INSERT INTO Product (ProductID, ProductName, ProductType, Color, Description, Price, Quantity, ImageURL)
                          VALUES ('$productID', '$productName', '$productType', '$color', '$description', $price, $quantity, '$imageURL')";

            if (mysqli_query($conn, $sqlInsertProduct)) {
                // Now insert into theinventory table
                $sqlInsertInventory = "INSERT INTO theinventory (ProductID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp)
                              VALUES ('$productID', '$productName', '$productType', '$color', '$description', $quantity, $price, NOW())";

                if (mysqli_query($conn, $sqlInsertInventory)) {
                    $successMessage = "Product and inventory record added successfully!";
                } else {
                    $error = "Error adding inventory record: " . mysqli_error($conn);
                }
            } else {
                $error = "Error adding product: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    }
    ?>

    <div class="form-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="productID">Product ID:</label>
            <input type="number" name="productID" required min="1" step="1">

            <label for="productName">Product Name:</label>
            <input type="text" name="productName" required>

            <label for="productType">Product Type:</label>
            <input type="text" name="productType" required>

            <label for="color">Color:</label>
            <input type="text" name="color" required>

            <label for="description">Description:</label>
            <select name="description" required>
                <option value="">-- Select Size --</option>
                <option value="4ft x 8ft x 18mm">4ft x 8ft x 18mm</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="0" step="1"><br>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" name="submit" value="Add Product">
        </form>

        <?php
        if (!empty($successMessage)) {
            echo "<p class='success'>$successMessage</p>";
        }
        if (!empty($error)) {
            echo "<p class='error'>$error</p>";
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