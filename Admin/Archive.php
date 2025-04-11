<?php
include("navigation.php");
?>

<!-- Page Content  -->
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">List of Deactivated Accounts</h2>

    <style>
        body {
            background-color: rgb(255, 255, 255);
        }

        .posted-data {
            margin-left: 50px;
            margin-right: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #089cfc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: white;
            text-align: center;
        }

        th {
            background-color: #475053;
            color: white;

        }

        tr:hover {
            background-color: #23395d;
        }

        h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }
    </style>

    <?php

    if (isset($_GET["userId"])) {
        if ($_GET["Activity"] == 'TRUE') {
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "zenfinityaccount";

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $userId = $_GET["userId"];

            // Retrieve the user's data
            $sqlSelect = "SELECT * FROM user WHERE ID = $userId";
            $resultSelect = $conn->query($sqlSelect);
            $userData = $resultSelect->fetch_assoc();

            // Insert the user's data into ArchiveAccount table
            $sqlInsert = "INSERT INTO archiveaccount (ID, username, password, Email, type) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("issss", $userData["ID"], $userData["username"], $userData["password"], $userData["Email"], $userData["type"]);

            if ($stmt->execute()) {
                $sqlDelete = "DELETE FROM user WHERE ID = $userId";
                if ($conn->query($sqlDelete) === TRUE) {
                    echo '
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info!</strong> Archive successful!.
					
                </div>';
                    echo '<script> 
				window.location="Archive.php?userId=' . $userId . '&Activity=FALSE";
				</script>';
                } else {
                    echo "Error deleting user: " . $conn->error;
                }
            } else {
                echo "Error archiving user: " . $conn->error;
            }

            // Close the database connection
            $stmt->close();
            $conn->close();
        }
    }
    ?>

    <div class="posted-data">
        <?php
        // Database connection
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "zenfinityaccount";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve data from the database
        $sql = "SELECT * FROM archiveaccount";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Email</th><th>Account Type</th><th>Activate</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td><a href='activate_account.php?userId=" . $row["ID"] . "' class='btn btn-success' style='background-color: #74B72E; color: WHITE; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;'>Activate</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found.";
        }
        $conn->close();
        ?>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>

</html>