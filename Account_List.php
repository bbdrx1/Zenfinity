<?php
include("navigation.php");
?>

<!-- Page Content  -->
<div id="content" class="p-4 p-md-5 pt-5">
    <h2 class="mb-4">List of Active Accounts</h2>
 <style>
 body {
	 background-color: #66c1ff;
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

    th, td {
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
        color: white; 
        font-size: 24px; 
        font-weight: bold; 
    }
</style>
   <div class="posted-data">
   <?php
	if(isset($_GET["archiveID"])){
		 echo  '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Info!</strong> Account #'.$_GET["archiveID"].' Activated Successfully!
                        </div>';
	}
   ?>
   
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "zenfinityaccount";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Email</th><th>Account Type</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
				 echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td><a href='Archive.php?userId=". $row["ID"] ."&Activity=TRUE'><button style='background-color: #808080; color: WHITE; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;'>Deactivate</button></a></td>";
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