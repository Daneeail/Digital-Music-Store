<?php
// Displays the order history of the user

session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "onlinemusicstore";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Saves total price of each transaction to display

$totalPrices = array();

$sql = "SELECT SUM(song.song_price) AS total_price
		FROM transaction
		INNER JOIN transactionlines ON transaction.transaction_ID = transactionlines.transaction_ID
		INNER JOIN song ON transactionlines.song_ID = song.song_ID
		WHERE transaction.client_ID = '" . $_SESSION["id"] . "' AND transaction.transaction_status = '1' 
		GROUP BY transactionlines.transaction_ID";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$totalPrices[] = $row["total_price"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
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
	<?php
	if (isset($_SESSION["username"])) {

		echo "<h1>Order History</h1>";

		$sql = "SELECT *
				FROM transaction
				INNER JOIN transactionlines ON transaction.transaction_ID = transactionlines.transaction_ID
				INNER JOIN song ON transactionlines.song_ID = song.song_ID
				INNER JOIN album ON song.album_ID = album.album_ID
				INNER JOIN artist ON album.artist_ID = artist.artist_ID
				WHERE transaction.client_ID = '" . $_SESSION["id"] . "' AND transaction.transaction_status = '1' 
				ORDER BY transaction_date";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			echo "<div class='container'>";
			$transactionID = 0;
			$transactionNum = 0;
			while ($row = $result->fetch_assoc()) {
				if ($transactionID != $row["transaction_ID"]) {
					if ($transactionID != 0) {
						echo "</table></div></div>";
					}
					$transactionID = $row["transaction_ID"];
					$transactionNum++;
					echo "<div class='row'>";
					echo "<div class='pr-4 pt-4' id='italics'>Transaction #" . $transactionNum . "</div>";
					echo "<div class='pr-4 pt-4' id='italics'>Date: " . $row["transaction_date"] . "</div>";
					echo "<div class='pr-4 pt-4' id='italics'>Total: " . '$' . $totalPrices[$transactionNum - 1] . "</div>";
					echo "</div>";
					echo "<div class='row-flex'>";
					echo "<div class='column'>";
					echo "<table class='table table-hover'><thread><tr class='d-flex'><th class='col-3'>Song</th><th class='col-3'>Artist</th><th class='col-3'>Album</th><th class='col-3'>Price</th></tr></thread>";
					echo "<tbody><tr class='d-flex'><td class='col-3'><a href='/musicInfo/songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
						 "<td class='col-3'><a href='/musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
						 "<td class='col-3'><a href='/musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
						 "<td class='col-3'>" . '$' . $row["song_price"] . "</td></tr>";
				}
				else {
					echo "<tr class='d-flex'><td class='col-3'><a href='/musicInfo/songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
						 "<td class='col-3'><a href='/musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
						 "<td class='col-3'><a href='/musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
						 "<td class='col-3'>" . '$' . $row["song_price"] . "</td></tr>";
				}
			}
			echo "</tbody></table></div></div></div>";
		}
		else {
			echo "<div class='container'><h5>No Order History!<h5></div>";
		}
	}
	else {
		header ("Location: /singIn/signIn.php");
	}
	?>

    <!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>