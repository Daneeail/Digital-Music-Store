<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT client_username FROM client";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		if ($row["client_username"] == $_POST["q"]) {
			echo "yes";
			return;
		}
	}
	echo "no";
}

?>