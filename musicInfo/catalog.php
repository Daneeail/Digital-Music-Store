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
		<div class="row">
			<div class="col">
				<?php
				// Display all songs

				$type = $_GET["type"];
				if ($type != "") {
					if ($type == "songs") {
						if (isset($_GET["pageNum"]) && $_GET["pageNum"] != "") {
							$pageNum = $_GET["pageNum"];
						}
						else {
							$pageNum = 1;
						}

						$recordsPerPage = 10;
						$offset = ($pageNum - 1) * $recordsPerPage;

						$sql = "SELECT COUNT(*) AS totalRecords FROM song";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_assoc($result);
						$totalRecords = $row["totalRecords"];
						$totalPages = ceil($totalRecords / $recordsPerPage);

						echo "<h1 class='py-3'>Songs</h1>";
						echo "<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>";

						$sql = "SELECT song.song_ID, song.song_name, song.song_price, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
								FROM song
								INNER JOIN album ON song.album_ID = album.album_ID
								INNER JOIN artist ON album.artist_ID = artist.artist_ID
								ORDER BY song.song_name
								LIMIT $offset, $recordsPerPage";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td><a href='songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
									 "<td><a href='artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
									 "<td><a href='albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
									 "<td>" . '$' . $row["song_price"] . "</td>" .
									 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $row["song_ID"] . "'>Add to Cart</button></form></td></tr>";
							}
						}

						echo "</table>";
						
						// Pagination
						echo "<div class='d-flex justify-content-center'>";
						echo "<ul class='pagination'>";
						if ($totalPages <= 10) {
							for ($page = 1; $page <= $totalPages; $page++) {
								if ($page == $pageNum) {
									echo "<li class='page-item active'><a class='page-link'>" . $page . "</a></li>";
								}
								else {
									echo "<li class='page-item'><a class='page-link' href='?type=songs&pageNum=" . $page . "'>" . $page . "</a></li>";
								}
							}
						}
						echo "</ul></div>";
					}


					// Display all albums
					elseif ($type == "albums") {
						if (isset($_GET["pageNum"]) && $_GET["pageNum"] != "") {
							$pageNum = $_GET["pageNum"];
						}
						else {
							$pageNum = 1;
						}

						$recordsPerPage = 10;
						$offset = ($pageNum - 1) * $recordsPerPage;

						$sql = "SELECT COUNT(*) AS totalRecords FROM album";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_assoc($result);
						$totalRecords = $row["totalRecords"];
						$totalPages = ceil($totalRecords / $recordsPerPage);

						echo "<h1 class='py-3'>Albums</h1>";
						echo "<table class='table table-hover' style='width: 100%'><tr><th>Album Image</th><th>Album</th><th>Artist</th><th></th></tr>";

						$sql = "SELECT album.album_image, album.album_ID, album.album_name, artist.artist_ID, artist.artist_name
								FROM album
								INNER JOIN artist ON album.artist_ID = artist.artist_ID
								ORDER BY album.album_name
								LIMIT $offset, $recordsPerPage";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>" . '<img src="data:image/jpeg;base64,' . base64_encode($row['album_image'] ) . '" style="height: 100px; width: 100px;"/></td>' . 
									 "<td><a href='albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" .
									 "<td><a href='artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" .
									 "<td><form action='/order/addAlbumToCartDB.php' method='post'><button name='albumID' type='submit' value='" . $row["album_ID"] . "'>Add to Cart</button></form></td></tr>";
							}
						}

						echo "</table>";

						// Pagination
						echo "<div class='d-flex justify-content-center'>";
						echo "<ul class='pagination'>";
						if ($totalPages <= 10) {
							for ($page = 1; $page <= $totalPages; $page++) {
								if ($page == $pageNum) {
									echo "<li class='page-item active'><a class='page-link'>" . $page . "</a></li>";
								}
								else {
									echo "<li class='page-item'><a class='page-link' href='?type=albums&pageNum=" . $page . "'>" . $page . "</a></li>";
								}
							}
						}
						echo "</ul></div>";
					}


					// Display all songs of particular genre
					else {
						echo "<h1 class='pt-3'>" . ucfirst($type) . "</h1>";

						$sql = "SELECT album.album_image, album.album_ID, album.album_name, artist.artist_name, artist.artist_ID
								FROM album
								INNER JOIN artist ON album.artist_ID = artist.artist_ID
								WHERE album.album_genre = ?
								ORDER BY album.album_name
								LIMIT 5";

						echo "<h4>Albums</h4>";
						echo "<div class='d-flex flex-wrap'>";

						if ($stmt = $conn->prepare($sql)) {
							$stmt->bind_param("s", $type);
							$stmt->execute();
							$stmt->bind_result($albImage, $albID, $albName, $artName, $artID);

							while ($stmt->fetch()) {
								echo "<div class='mx-auto pb-4'>" .
									 '<img src="data:image/jpeg;base64,' . base64_encode($albImage) . '" style="height: 100px; width: 100px;"/>' . 
									 "<p><a href='artistInfo.php?" . $artID . "'>" . $artName . "</a></p>" .
									 "<p><a href='albumInfo.php?" . $albID . "'>" . $albName . "</a></p>" .
									 "<form action='/order/addAlbumToCartDB.php' method='post'><button name='albumID' type='submit' value='" . $albID . "'>Add to Cart</button></form>" .
									 "</div>";
							}

							$stmt->close();
						}

						echo "</div>";

						$sql = "SELECT song.song_ID, song.song_name, song.song_price, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
								FROM song
								INNER JOIN album ON song.album_ID = album.album_ID
								INNER JOIN artist ON album.artist_ID = artist.artist_ID
								WHERE album.album_genre = ?
								ORDER BY song.song_name";
						
						if ($stmt = $conn->prepare($sql)) {
							echo "<h4 class='pt-4'>Songs</h4>";
							echo "<div class='pt-2'><table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>";
							$stmt->bind_param("s", $type);
							$stmt->execute();
							$stmt->bind_result($songID, $songName, $songPrice, $artistID, $artistName, $albumID, $albumName);

							while ($stmt->fetch()) {
								echo "<tr><td><a href='songInfo.php?" . $songID . "'>" . $songName . "</a></td>" . 
									 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" . 
									 "<td><a href='albumInfo.php?" . $albumID . "'>" . $albumName . "</td>" . 
									 "<td>" . '$' . $songPrice . "</td>" .
									 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songID . "'>Add to Cart</button></form></td></tr>";
							}
						}
						echo "</table></div>";
					}
				}


				// Display search result
				elseif (isset($_POST["search"])){
					$param = "{$_POST["search"]}%";
					echo "<h1 class='pt-3'>Search</h1>";
					$sql = "SELECT song.song_ID, song.song_name, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
							FROM song
							INNER JOIN album ON song.album_ID = album.album_ID
							INNER JOIN artist ON album.artist_ID = artist.artist_ID
							WHERE song.song_name LIKE ?
							ORDER BY song.song_name";
						
					if ($stmt = $conn->prepare($sql)) {
						echo "<h4 class='pt-4'>Songs</h4>";
						echo "<div class='pt-2'><table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th></th></tr>";
						$stmt->bind_param("s", $param);
						$stmt->execute();
						$stmt->bind_result($songID, $songName, $artistID, $artistName, $albumID, $albumName);

						while ($stmt->fetch()) {
							echo "<tr><td><a href='songInfo.php?" . $songID . "'>" . $songName . "</a></td>" . 
								 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" . 
								 "<td><a href='albumInfo.php?" . $albumID . "'>" . $albumName . "</td>" . 
								 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songID . "'>Add to Cart</button></form></td></tr>";
						}
					}
					echo "</table></div>";
					$stmt->close();

					$sql = "SELECT song.song_ID, song.song_name, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
							FROM song
							INNER JOIN album ON song.album_ID = album.album_ID
							INNER JOIN artist ON album.artist_ID = artist.artist_ID
							WHERE album.album_name LIKE ?
							ORDER BY album.album_name";

					if ($stmt = $conn->prepare($sql)) {
						echo "<h4 class='pt-4'>Albums</h4>";
						echo "<div class='pt-2'><table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th></th></tr>";
						$stmt->bind_param("s", $param);
						$stmt->execute();
						$stmt->bind_result($songID, $songName, $artistID, $artistName, $albumID, $albumName);

						while ($stmt->fetch()) {
							echo "<tr><td><a href='songInfo.php?" . $songID . "'>" . $songName . "</a></td>" . 
								 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" . 
								 "<td><a href='albumInfo.php?" . $albumID . "'>" . $albumName . "</td>" . 
								 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songID . "'>Add to Cart</button></form></td></tr>";
						}
					}
					echo "</table></div>";
					$stmt->close();

					$sql = "SELECT song.song_ID, song.song_name, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
							FROM song
							INNER JOIN album ON song.album_ID = album.album_ID
							INNER JOIN artist ON album.artist_ID = artist.artist_ID
							WHERE artist.artist_name LIKE ?
							ORDER BY artist.artist_name";

					if ($stmt = $conn->prepare($sql)) {
						echo "<h4 class='pt-4'>Artists</h4>";
						echo "<div class='pt-2'><table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th></th></tr>";
						$stmt->bind_param("s", $param);
						$stmt->execute();
						$stmt->bind_result($songID, $songName, $artistID, $artistName, $albumID, $albumName);

						while ($stmt->fetch()) {
							echo "<tr><td><a href='songInfo.php?" . $songID . "'>" . $songName . "</a></td>" . 
								 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" . 
								 "<td><a href='albumInfo.php?" . $albumID . "'>" . $albumName . "</td>" . 
								 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songID . "'>Add to Cart</button></form></td></tr>";
						}
					}
					echo "</table></div>";
					$stmt->close();
				}


				// If no type given, display all songs
				else {
					echo "<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th></th></tr>";

					$sql = "SELECT song.song_ID, song.song_name, artist.artist_ID, artist.artist_name, album.album_ID, album.album_name
							FROM song
							INNER JOIN album ON song.album_ID = album.album_ID
							INNER JOIN artist ON album.artist_ID = artist.artist_ID
							ORDER BY song.song_name";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "<tr><td><a href='songInfo.php?" . $row["song_ID"] . "'>" . $row["song_name"] . "</a></td>" . 
								 "<td><a href='artistInfo.php?" . $row["artist_ID"] . "'>" . $row["artist_name"] . "</a></td>" . 
								 "<td><a href='albumInfo.php?" . $row["album_ID"] . "'>" . $row["album_name"] . "</a></td>" . 
								 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $row["song_ID"] . "'>Add to Cart</button></form></td></tr>";
						}
					}
					echo "</table>";
				}
				?>

			</div>
		</div>
	</div>

    <!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>