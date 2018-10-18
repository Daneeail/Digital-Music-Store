<?php
// Deletes song from cart

session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM transactionlines
		WHERE transaction_ID = '" . $_SESSION["transaction_ID"] . "' AND song_ID = '" . $_POST["song_ID"] . "'";

if ($conn->query($sql) === TRUE) {
	header ("Location: cart.php");
}
else {
	echo "Error deleting record: " . $conn->error;
}

?>