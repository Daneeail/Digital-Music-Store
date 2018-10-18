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
    <title>Artist Information</title>
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
	$artistID = $_SERVER["QUERY_STRING"];

	$sql = "SELECT artist.artist_name, album.album_name, album.album_ID, album.album_image
			FROM album
			INNER JOIN artist ON album.artist_ID = artist.artist_ID
			WHERE artist.artist_ID = ?
			ORDER BY album.album_name";
	
	$artistName;
	$albumNames = array();
	$albumIDs = array();
	$albumImages = array();

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $artistID);
		$stmt->execute();
		$stmt->bind_result($artName, $albName, $albID, $albImage);

		while ($stmt->fetch()) {
			$artistName = $artName;
			$albumNames[] = $albName;
			$albumIDs[] = $albID;
			$albumImages[] = $albImage;
		}

		$stmt->close();
	}
	?>

	<div class="container">
		<div class="row pb-4 pt-2">
			<h1><?php echo $artistName; ?></h1>
		</div>
		<div class="row">
			<h3>Artist Details</h3>
			<p>Lorem ipsum dolor sit amet, sed cu tritani albucius, pri ut commodo aperiri. 
			Eu sit paulo labores, quod scripserit ut duo, dicam causae ea mea. 
			Persius bonorum debitis sea at, sea postea molestie cu. 
			Prima mutat dicat ei per, in natum legendos deseruisse vix. 
			Mei an modo quaeque tibique, odio indoctum mea cu, mei ea discere aliquando omittantur.</p>
		</div>
		<div class="row pt-4">
			<h4>Albums</h4>
		</div>
		<div class="row pb-4">
			<?php
			for ($i = 0; $i < count($albumIDs); $i++) {
				echo "<div class='mx-auto pb-4'>" .
					 '<img src="data:image/jpeg;base64,' . base64_encode($albumImages[$i]) . '" style="height: 100px; width: 100px;"/>' . 
					 "<p><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></p>" .
					 "<p><a href='albumInfo.php?" . $albumIDs[$i] . "'>" . $albumNames[$i] . "</a></p>" .
					 "<form action='/order/addAlbumToCartDB.php' method='post'><button name='albumID' type='submit' value='" . $albumIDs[$i] . "'>Add to Cart</button></form>" .
					 "</div>";
			}
			?>
		</div>
		<div class="row">
			<h4>Songs</h4>
			<?php
			$sql = "SELECT song.song_ID, song.song_name, song.song_price, album.album_ID, album.album_name
					FROM song
					INNER JOIN album ON song.album_ID = album.album_ID
					INNER JOIN artist ON album.artist_ID = artist.artist_ID
					WHERE artist.artist_ID = ?
					ORDER BY song.song_name";
			
			if ($stmt = $conn->prepare($sql)) {
				$stmt->bind_param("s", $artistID);
				$stmt->execute();
				$stmt->bind_result($songID, $songName, $songPrice, $albID, $albName);

				echo "<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>";

				while ($stmt->fetch()) {
					echo "<tr><td><a href='songInfo.php?" . $songID . "'>" . $songName . "</a></td>" . 
						 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" . 
						 "<td><a href='albumInfo.php?" . $albID . "'>" . $albName . "</a></td>" . 
						 "<td>" . '$' . $songPrice . "</td>" .
						 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songID . "'>Add to Cart</button></form></td></tr>";
				}
				echo "</table>";
				$stmt->close();
			}
			?>
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>