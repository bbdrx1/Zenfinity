<?php
include("navigation.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-GTVnK6eIfM6N1Zt0a3Pm9eU3OyFEL+X+R5pJTAUjH4ZbwU0k5ENZMe8O3BzEO9Z1"
      crossorigin="anonymous">
    <style>
        body {
            background-color: #fff;
        }

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

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .product-box {
            background-color: #089cfc;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            width: 350px;
            height: 410px;
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-info {
            font-size: 15px;
            text-align: left;
            padding: 5px;
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
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

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
</head>
<body>

<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Product List</h2>

    <!-- Legend -->
    <div class="legend-container">
        <h4>Legend:</h4>
        <div class="legend-item">
            <div class="legend-color red-border"></div>
            <div class="legend-text">Quantity < 30</div>
        </div>
        <div class="legend-item">
            <div class="legend-color yellow-border"></div>
            <div class="legend-text">Quantity: 30 - 50</div>
        </div>
        <div class="legend-item">
            <div class="legend-color green-border"></div>
            <div class="legend-text">Quantity > 50</div>
        </div>
    </div>

    <!-- Alert Container -->
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
    ?>
    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()):
            $quantity = (int)$row['Quantity'];
            $borderClass = '';
            if ($quantity <= 29) {
                $borderClass = 'red-border';
            } elseif ($quantity >= 30 && $quantity <= 50) {
                $borderClass = 'yellow-border';
            } else {
                $borderClass = 'green-border';
            }
        ?>
            <div class="product-box <?= $borderClass ?>">
                <h3><?= $row['ProductName'] ?></h3>
                <div class="product-info">
                    <p><strong>Product ID:</strong> <?= $row['ProductID'] ?></p>
                    <p>Product Type: <?= $row['ProductType'] ?></p>
                    <p>Color: <?= $row['Color'] ?></p>
                    <p>Description: <?= $row['Description'] ?></p>
                    <p>Quantity: <?= $row['Quantity'] ?></p>
                    <p>Price: ₱<?= number_format($row['Price'], 2, '.', ',') ?></p>
                    <div class="button-container">
                        <button class="edit-button btn btn-success" data-product-id="<?= $row['ProductID'] ?>" data-toggle="modal" data-target="#editModal">
                            Edit
                        </button>
                        <form action="delete_product.php" method="post" class="delete-form" onsubmit="return confirmDelete();">
                            <input type="hidden" name="product_id" value="<?= $row['ProductID'] ?>">
                            <input type="submit" value="Archive" class="btn btn-light">
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="update_product.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="edit-product-id">

                    <label for="edit-product-name">Product Name:</label>
                    <input type="text" class="form-control" name="edit-product-name" id="edit-product-name"><br>

                    <label for="edit-product-type">Product Type:</label>
                    <input type="text" class="form-control" name="edit-product-type" id="edit-product-type"><br>

                    <label for="edit-color">Color:</label>
                    <input type="text" class="form-control" name="edit-color" id="edit-color"><br>

                    <!-- Description Input -->
                    <label for="edit-description">Description:</label>
                    <input type="text" class="form-control" name="edit-description" id="edit-description" value="4ft x 8ft x18mm" readonly>
                    <br>

                    <label for="edit-quantity">Quantity:</label>
                    <input type="number" class="form-control" name="edit-Quantity" id="edit-quantity" min="0" step="1"><br>

                    <label for="edit-price">Price:</label>
                    <input type="text" class="form-control" name="edit-price" id="edit-price">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Load product data into modal
        $('.edit-button').on('click', function () {
            var productId = $(this).data('product-id');
            var productName = $(this).closest('.product-box').find('h3').text();
            var productType = $(this).closest('.product-box').find('p:nth-child(2)').text().replace('Product Type: ', '');
            var color = $(this).closest('.product-box').find('p:nth-child(3)').text().replace('Color: ', '');
            var description = $(this).closest('.product-box').find('p:nth-child(4)').text().replace('Description: ', '');
            var quantity = $(this).closest('.product-box').find('p:nth-child(5)').text().replace('Quantity: ', '');
            var price = $(this).closest('.product-box').find('p:nth-child(6)').text().replace('Price: ₱', '').replaceAll(',', '');

            $('#edit-product-id').val(productId);
            $('#edit-product-name').val(productName);
            $('#edit-product-type').val(productType);
            $('#edit-color').val(color);
            $('#edit-description').val("4ft x 8ft x18mm");
            $('#edit-quantity').val(quantity);
            $('#edit-price').val(price);
        });

        // Handle form submission via AJAX to prevent full page reload
        $('form[action="update_product.php"]').submit(function(e) {
            e.preventDefault(); // Prevent default form behavior

            var formData = $(this).serialize();

            $.post("update_product.php", formData, function(response) {
                location.reload(); // ← Optional: Reload page to show changes
                // OR BETTER: Update specific product box dynamically
                var productId = $('#edit-product-id').val();
                var newDesc = $('#edit-description').val();
                var newQty = $('#edit-quantity').val();

                // Find the corresponding product box and update its content
                var $box = $('.product-box').filter(function() {
                    return $(this).find('h3').text() === $('#edit-product-name').val();
                }).first();

                if ($box.length > 0) {
                    $box.find('p:nth-child(4)').text('Description: ' + newDesc);
                    $box.find('p:nth-child(5)').text('Quantity: ' + newQty);

                    // Optional: Update border color based on quantity
                    var qtyNum = parseInt(newQty);
                    var $infoBox = $box.find('.product-info');

                    $box.removeClass('red-border yellow-border green-border');

                    if (qtyNum <= 29) {
                        $box.addClass('red-border');
                    } else if (qtyNum >= 30 && qtyNum <= 50) {
                        $box.addClass('yellow-border');
                    } else {
                        $box.addClass('green-border');
                    }

                    // Show success alert
                    displayAlert('success', 'Product updated successfully!');
                }
            });
        });
    });

    function confirmDelete() {
        return confirm("Are you sure you want to Archive this product?");
    }

    function displayAlert(type, message) {
        var alertContainer = document.getElementById("alert-container");
        var alertElement = document.createElement("div");
        alertElement.className = "alert alert-" + type + " alert-dismissible show";
        alertElement.innerHTML = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Info!</strong> ' + message;
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertElement);
        setTimeout(function () {
            alertElement.classList.remove("show");
        }, 5000);
    }
</script>

</body>
</html>