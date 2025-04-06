<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenfinityaccount";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the last used transaction number from the transaction_counter table
    $query = "SELECT last_transaction_number FROM transaction_counter";
    $result = $conn->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $lastTransactionNumber = $row['last_transaction_number'];
    } else {
        $lastTransactionNumber = 1; // Default value if the table is empty
    }

    // Increment the last used transaction number
    $nextTransactionNumber = $lastTransactionNumber + 1;

    // Update the transaction_counter table with the new last_transaction_number
    $updateQuery = "UPDATE transaction_counter SET last_transaction_number = $nextTransactionNumber";
    $conn->query($updateQuery);

    $soldto = $_POST["soldto"];
    $address = $_POST["address"];
    $productnames = $_POST["productname"];
    $quantities = $_POST["quantity"];
    $prices = $_POST["price"];

    $conn->autocommit(FALSE); // Disable autocommit for transaction

    $validTransaction = true; // Flag to track the validity of the transaction

    for ($i = 0; $i < count($productnames); $i++) {
        $productname = $productnames[$i];
        $quantity = $quantities[$i];
        $price = $prices[$i];

        // Check product quantity
        $productInfo = getProductInfo($conn, $productname);

        if ($productInfo) {
            $productType = $productInfo['ProductType'];
            $color = $productInfo['Color'];
            $description = $productInfo['Description'];

            if ($quantity <= 0 || $quantity > $productInfo['quantity']) {
                echo "<script>alert('Invalid quantity for product: $productname. The available quantity is: " . $productInfo['quantity'] . "'); window.location.href='transaction.php';</script>";
                $validTransaction = false;
                break;
            }

            $entrytimestamp = date("Y-m-d H:i:s"); // Get the current date and time

            $stmt = $conn->prepare("INSERT INTO transaction (transactionnumber, soldto, address, productname, quantity, price, ProductType, Color, Description, Entrytimestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisssss", $nextTransactionNumber, $soldto, $address, $productname, $quantity, $price, $productType, $color, $description, $entrytimestamp);

            if ($stmt->execute()) {
                // Insertion was successful
                // Update the quantity in the product table
                $stmt = $conn->prepare("UPDATE product SET quantity = quantity - ? WHERE productname = ?");
                $stmt->bind_param("ss", $quantity, $productname);
                $stmt->execute();
            } else {
                // Handle insertion error
                $validTransaction = false;
                break;
            }
        } else {
            // Handle invalid product
            $validTransaction = false;
            break;
        }
    }

    if ($validTransaction) {
        // Commit the transaction if it's valid
        $conn->commit();
        header("Location: transaction.php");
        exit();
    } else {
        // Rollback the transaction if it's invalid
        $conn->rollback();
    }

    // Enable autocommit again
    $conn->autocommit(TRUE);
}

function getProductInfo($conn, $productname) {
    $query = "SELECT ProductType, Color, Description, quantity FROM product WHERE productname = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $productname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
?>
