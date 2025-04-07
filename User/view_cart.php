<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: product_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .cart-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            border-radius: 8px;
        }

        .cart-item h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .cart-item p {
            margin: 5px 0;
            font-size: 14px;
        }

        .checkout-form {
            margin-top: 20px;
            text-align: center;
        }

        .checkout-form input {
            padding: 10px;
            margin: 5px;
            width: 300px;
        }

        .checkout-form button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .checkout-form button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Shopping Cart</h2>

    <div>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <div class="cart-item">
                <h3><?php echo $item['ProductName']; ?></h3>
                <p><strong>Type:</strong> <?php echo $item['ProductType']; ?></p>
                <p><strong>Color:</strong> <?php echo $item['Color']; ?></p>
                <p><strong>Price:</strong> ₱<?php echo number_format($item['Price'], 2); ?></p>
                <p><strong>Quantity:</strong> <?php echo $item['Quantity']; ?></p>
                <p><strong>Total:</strong> ₱<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST" action="place_order.php" class="checkout-form">
        <h3>Place Your Order</h3>
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <input type="text" name="customer_address" placeholder="Your Address" required>
        <button type="submit">Place Order</button>
    </form>
</body>

</html>