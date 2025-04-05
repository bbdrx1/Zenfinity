<?php
// Include database connection parameters
$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "zenfinityaccount";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['transfer_data'])) {
    // Perform the data transfer to TheInventory table with EntryTimestamp included
    $sqlTransferToTheInventory = "INSERT INTO TheInventory (InventoryID, ProductID, ProductName, ProductType, Color, Description, Quantity, Price, EntryTimestamp)
                                  SELECT InventoryID, ProductID, ProductName, ProductType, Color, Description, SUM(Quantity) AS Quantity, Price, NOW()
                                  FROM Inventory
                                  GROUP BY InventoryID, ProductID, ProductName, ProductType, Color, Description, Price";

    if (mysqli_query($conn, $sqlTransferToTheInventory)) {
        // Data transfer to TheInventory table successful

        // Now, update or insert data into the Product table based on ProductID
        $sqlUpdateOrInsertProduct = "INSERT INTO Product (ProductID, ProductName, ProductType, Color, Description, Price, Quantity)
                                    SELECT i.ProductID, i.ProductName, i.ProductType, i.Color, i.Description, i.Price, SUM(i.Quantity) AS Quantity
                                    FROM Inventory i
                                    LEFT JOIN Product p ON i.ProductID = p.ProductID
                                    GROUP BY i.ProductID, i.ProductName, i.ProductType, i.Color, i.Description, i.Price
                                    ON DUPLICATE KEY UPDATE ProductName = VALUES(ProductName), ProductType = VALUES(ProductType), Color = VALUES(Color), Description = VALUES(Description), Price = VALUES(Price), Quantity = Quantity + VALUES(Quantity)";

        if (mysqli_query($conn, $sqlUpdateOrInsertProduct)) {
            // Data update or insert into the Product table successful

            // Now, delete the transferred data from the Inventory table
            $sqlDelete = "DELETE FROM Inventory";

            if (mysqli_query($conn, $sqlDelete)) {
                // Data deletion successful
                $successMessage = "Data transferred, updated, and deleted successfully!";
                header("Location: inventory.php?success=true&message=" . urlencode($successMessage));
                exit();
            } else {
                // Data deletion failed
                echo "Error deleting data: " . mysqli_error($conn);
            }
        } else {
            // Data update or insert into the Product table failed
            echo "Error updating or inserting data into Product: " . mysqli_error($conn);
        }
    } else {
        // Data transfer to TheInventory table failed
        echo "Error transferring data to TheInventory: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
