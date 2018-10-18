<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT client_ID, client_username, client_pw 
		FROM client
		WHERE client_username = ?";

if ($stmt = $conn->prepare($sql)) {
	$stmt->bind_param("s", $_POST["username"]);
	$stmt->execute();
	$stmt->bind_result($clientID, $clientUsername, $clientPW);
	if ($stmt->fetch() && password_verify($_POST["password"], $clientPW)) {
		$_SESSION["username"] = $clientUsername;
		$_SESSION["id"] = $clientID;
		if ($_SESSION["songID"] != "" && isset($_SESSION["songID"])) {
			header("Location: /order/addSongToCartDB.php");
		}
		elseif ($_SESSION["albumID"] != "" && isset($_SESSION["albumID"])) {
			header("Location: /order/addAlbumToCartDB.php");
		}
		else {
			header("Location: /index.php");
		}
	}
	else {
		header("Location: /signIn/signIn.php");
	}
}
?>