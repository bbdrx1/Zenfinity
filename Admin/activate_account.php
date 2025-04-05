<?php
if (isset($_GET["userId"])) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "zenfinityaccount";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_GET["userId"];

    // Retrieve the archived user's data
    $sqlSelect = "SELECT * FROM archiveaccount WHERE ID = $userId";
    $resultSelect = $conn->query($sqlSelect);
    $userData = $resultSelect->fetch_assoc();

    // Insert the archived user's data back into the user table
    $sqlInsert = "INSERT INTO user (ID, username, password, Email, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("issss", $userData["ID"], $userData["username"], $userData["password"], $userData["Email"], $userData["type"]);

    if ($stmt->execute()) {

        $sqlDelete = "DELETE FROM archiveaccount WHERE ID = $userId";
        if ($conn->query($sqlDelete) === TRUE) {
            header("Location: Account_List.php?archiveID=$userId"); 
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Error reactivating user: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>