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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Digital Music Store</title>
	<meta name="description" content="Main page for a digital music store titled Lorem Ipsum." />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=divice-width, initial-scale=1" />
    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css" />
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
    <!--Header-->
    <?php include "header.php"; ?>

	<!--Content-->
	<div class="container">
		<h1 class="pt-4">Lorem Ipsum</h1>
		<h4>Best-Selling Albums</h4>
		<div class="row p-4">
			<?php
			$sql = "SELECT album.album_image, album.album_name, album.album_ID, artist.artist_name, artist.artist_ID
					FROM album
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					ORDER BY album.album_date
					LIMIT 5";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<div class='mx-auto'>" .
						 '<img src="data:image/jpeg;base64,' . base64_encode($row["album_image"]) . '" style="height: 100px; width: 100px;"/>' . 
						 "<p><a href='musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></p>" .
						 "<p><a href='musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></p>" .
						 "</div>";
				}
			}
			?>
		</div>
		<h4 class="pt-4">Best-Selling Songs</h4>
		<div>
			<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>
			<?php
			$sql = "SELECT song.song_ID, song.song_name, song.song_price, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
					FROM song
					INNER JOIN album ON song.album_ID = album.album_ID
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					ORDER BY song.song_name
					LIMIT 10";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td><a href='musicInfo/songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
						 "<td><a href='musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
						 "<td><a href='musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
						 "<td>" . '$' . $row["song_price"] . "</td></tr>";
				}
			}
			?>
			</table>
		</div>
		<h4 class="pt-4">New Albums</h4>
		<div class="row p-4">
			<?php
			$sql = "SELECT album.album_image, album.album_name, album.album_ID, artist.artist_name, artist.artist_ID
					FROM album
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					ORDER BY album.album_date
					LIMIT 5";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<div class='mx-auto'>" .
						 '<img src="data:image/jpeg;base64,' . base64_encode($row["album_image"]) . '" style="height: 100px; width: 100px;"/>' . 
						 "<p><a href='musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></p>" .
						 "<p><a href='musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></p>" .
						 "</div>";
				}
			}
			?>
		</div>
		<h4 class="pt-4">New Songs</h4>
		<div>
			<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th></tr>
			<?php
			$sql = "SELECT song.song_ID, song.song_name, song.song_price, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
					FROM song
					INNER JOIN album ON song.album_ID = album.album_ID
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					ORDER BY album.album_date
					LIMIT 10";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td><a href='musicInfo/songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
						 "<td><a href='musicInfo/artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
						 "<td><a href='musicInfo/albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
						 "</tr>";
				}
			}
			?>
			</table>
		</div>
	</div>

    <!--Footer-->
    <?php include "footer.html"; ?>

</body>
</html>
