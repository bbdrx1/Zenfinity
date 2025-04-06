<?php
session_start();
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "zenfinityaccount";

// Establish a connection to the database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input from POST request
$username = $_POST['username'];
$password = $_POST['password']; // No md5 hashing applied

// Prepare the SQL query
$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password); // Bind parameters
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // User exists
    $_SESSION["username"] = $row['username'];
    $_SESSION["type"] = $row['type']; // Set the user type in the session

    if ($row['type'] == 'admin') {
        header("Location: Admin/HomePage.php");
    } elseif ($row['type'] == 'customer') {
        header("Location: User/HomePage.php");
    } elseif ($row['type'] == 'supplier') {
        header("Location: supplier/HomePage.php");
    } else {
        echo "Error: Unknown account type";
    }
} else {
    // User does not exist or credentials are incorrect
    header("Location: index.html?error=" . urlencode("Invalid Credentials"));
}

// Close the database connection
$stmt->close();
$conn->close();
