<?php
// Displays user cart

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
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
	<div class="container">
		<div class="row p-4">
			<div class="col">
				<?php
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$database = "onlinemusicstore";

				$conn = new mysqli($servername, $username, $password, $database);

				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$total;

				$sql = "SELECT song.song_ID, song.song_name, song.song_price, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
					FROM client
					INNER JOIN transaction ON client.client_ID = transaction.client_ID
					INNER JOIN transactionlines ON transaction.transaction_ID = transactionlines.transaction_ID
					INNER JOIN song ON transactionlines.song_ID = song.song_ID
					INNER JOIN album ON song.album_ID = album.album_ID
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					WHERE transaction.client_ID = '" . $_SESSION["id"] . "' AND transaction.transaction_status = '0'" .
					" ORDER BY album.album_name";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<h2>Cart</h2>;
					echo "<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>";

					while ($row = $result->fetch_assoc()) {
						echo "<tr><td><a href='/musicInfo/songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
							 "<td><a href='/musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
							 "<td><a href='/musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</td>" . 
							 "<td>" . '$' . $row["song_price"] . "</td>" .
							 "<td><form action='deleteSong.php' method='post'><button name='song_ID' type='submit' value='" . $row["song_ID"] . "'>Delete Song</button></form></td></tr>";
							 $total += $row["song_price"];
					}
					echo "</table>";
					echo "<div class='d-flex flex-row justify-content-between'>
						<form action='buy.php' method='post'><button type='submit'>Complete Transaction</button></form>
						<h5 id='bold'>Total: " . '$' . $total . "</h5></div>";
				}
				else {
					echo "<h2>Empty Cart</h2>";
					echo "Lorem ipsum dolor sit amet, qui eu inciderint neglegentur. 
					Delenit postulant temporibus et sit, iriure voluptatum sea ad. 
					Vim euismod fuisset eleifend cu. 
					Sed et malis appareat, an per eius cetero, his et vidit dicunt mentitum. 
					Sea ad iriure veritus, in usu nostrum expetenda.
					<br /><br />";
					echo "<a href='/index.php'>Return to Home Page</a>";
				}
				?>
			</div>
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>

</body>
