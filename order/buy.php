<?php
// Verifies and displays successful purchase

session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase Successful!</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=divice-width, initial-scale=1" />
    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
	<!--Header-->
    <?php include "../header.php"; ?>

	<!--Content-->
	<div class='container pt-2'>
		<div class='row'>
			<div class='column'>
				<?php
				$sql = "UPDATE transaction
						SET transaction_status = '1'
						WHERE client_ID = '" . $_SESSION["id"] . "' AND transaction_status = '0'";

				if ($conn->query($sql) === TRUE) {
					echo "<h2>Purchase successful!</h2>";
					echo "<br>";
					echo "<a href='/index.php'>Return to Home Page</a>";
				}
				else {
					echo "ERROR!";
				}
				?>
			</div>
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>
</body>
</html>