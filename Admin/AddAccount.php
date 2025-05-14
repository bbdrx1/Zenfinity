<?php
include("navigation.php");
?>

<!-- Page Content  -->
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">Add Account</h2>

    <style>
        body {
            background-color: rgb(253, 253, 253);
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }

        form {
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
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

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
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $email = $_POST["email"];
        $user_type = $_POST["user_type"];

        $errors = array();

        if (empty($username)) {
            $errors[] = "Username is required.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($errors)) {
            // No hashing applied
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "zenfinityaccount";

            $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO user (username, password, Email, type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $password, $email, $user_type); // Store plaintext password
            $stmt->execute();

            $stmt->close();
            $conn->close();

            echo '
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Info!</strong> Registration successful!.
        </div>';
        } else {
            $error_message = implode("\\n", $errors);

            echo '
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Danger!</strong> ' . $error_message . '.
        </div>';
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="user_type">Select User Type:</label>
        <select name="user_type" required>
            <option value="">Select User Type</option>
            <option value="customer">User</option>
            <option value="admin">Admin</option>
            <option value="supplier">Supplier</option>
        </select>

        <input type="submit" value="Register">
    </form>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</div>