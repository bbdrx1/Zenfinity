<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "zenfinityaccount";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT ProductID, ProductName, ProductType, Color, Description, Quantity FROM product ORDER BY Quantity ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
    $quantity = $row['Quantity'];
    $status = "In Stock";
    $class = "in-stock";

    if ($quantity <= 5):
        $status = "Very Low";
        $class = "very-low-stock";
    elseif ($quantity <= 20):
        $status = "Low Stock";
        $class = "low-stock";
    endif;
    ?>
    <tr class="<?= $class ?>">
        <td><?= htmlspecialchars($row['ProductName']) ?></td>
        <td><?= $row['ProductID'] ?></td>
        <td><?= htmlspecialchars($row['ProductType']) ?></td>
        <td><?= htmlspecialchars($row['Color']) ?></td>
        <td><?= htmlspecialchars($row['Description']) ?></td>
        <td><?= $row['Quantity'] ?></td>
        <td><?= $status ?></td>
    </tr>
<?php endwhile; ?>