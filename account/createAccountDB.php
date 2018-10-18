<?php
// Inserts account and user info into database

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO client (client_name, client_username, client_email, client_pw) VALUES (?, ?, ?, ?)";

if ($stmt = mysqli_prepare($conn, $sql)) {
	mysqli_stmt_bind_param($stmt, "ssss", $name, $user, $email, $pw);

	$name = $_POST["fName"];
	$user = $_POST["fUsername"];
	$email = $_POST["fEmail"];
	$pw = password_hash($_POST["fPassword"], PASSWORD_DEFAULT);

	mysqli_stmt_execute($stmt);

	header("Location: accountCreated.php");
	exit();
}