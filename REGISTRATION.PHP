<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
</head>

<body>
    <h2>Registration Form</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $student_id = $_POST["student_id"];

        $errors = array();

        // Validate inputs
        if (empty($username)) {
            $errors[] = "Username is required.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($student_id)) {
            $errors[] = "Student ID is required.";
        }

        // If no errors, proceed with registration
        if (empty($errors)) {
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "zenfinityaccount";

            $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Hash the password securely
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query
            $stmt = $conn->prepare("INSERT INTO user (Username, Email, IDnumber, Password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $student_id, $password_hash); // Store hashed password
            $stmt->execute();

            $stmt->close();
            $conn->close();

            echo "Registration successful!";
        } else {
            // Display validation errors
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <br>

        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required>

        <br>

        <input type="submit" value="Register">
    </form>
</body>

</html>