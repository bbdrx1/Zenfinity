<?php
session_start();
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "zenfinityaccount";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);

$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // User exists
    $_SESSION["username"] = $row['username'];
    $_SESSION["type"] = $row['type']; // Set the user type in the session

    if ($row['type'] == 'Admin') {
        header("Location: Admin/HomePage.php");
    } elseif ($row['type'] == 'User') {
        header("Location: User/HomePage.php");
    } else {
        echo "error: Unknown account type";
    }
} else {
    // User does not exist or credentials are incorrect
    header("Location: index.html?error=" . urlencode("Invalid Credentials"));
}
?>
