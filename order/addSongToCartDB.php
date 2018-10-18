<?php
session_start();

if (isset($_SESSION["username"])) {
	if (isset($_POST["songID"])) {
		$_SESSION["songID"] = $_POST["songID"];
	}

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$database = "onlinemusicstore";

	$conn = new mysqli($servername, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$count;
	$sql = "SELECT COUNT(transaction_ID) 
			FROM transaction 
			WHERE client_ID = ? AND transaction_status = '0'";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $_SESSION["id"]);
		$stmt->execute();
		$stmt->bind_result($lastTransID);
		$stmt->fetch();
		$count = $lastTransID;
		$stmt->close();
	}

	$last_id;
	
	if ($count == 0) {
		$stmt = $conn->prepare("INSERT INTO transaction (transaction_date, client_ID, transaction_status) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $transaction_date, $client_ID, $transaction_status);

		$transaction_date = date("Y/m/d");
		$client_ID = $_SESSION["id"];
		$transaction_status = 0;
		$stmt->execute();
		$stmt->close();
		$last_id = $conn->insert_id;
	}
	else {

		$sql = "SELECT MAX(transaction_ID)
				FROM transaction
				WHERE client_ID = ?";
				
		if ($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("s", $_SESSION["id"]);
			$stmt->execute();
			$stmt->bind_result($lastID);
			$stmt->fetch();
			$last_id = $lastID;
			$stmt->close();
		}
	}

	$stmt = $conn->prepare("INSERT INTO transactionlines (transaction_ID, song_ID) VALUES (?, ?)");
	$stmt->bind_param("ss", $transaction_ID, $song_ID);

	$transaction_ID = $last_id;
	$song_ID = $_SESSION["songID"];
	$stmt->execute();
	$stmt->close();

	$_SESSION["transaction_ID"] = $last_id;

	header ("Location: cart.php");
}
else {
	$_SESSION["songID"] = $_POST["songID"];
	header ("Location: /signIn/signIn.php");
}
?>