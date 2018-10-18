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
    <title>Album Information</title>
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
	$albumID = $_SERVER["QUERY_STRING"];

	$sql = "SELECT album.album_image, album.album_name, artist.artist_name, song.song_name, song.song_ID, song.song_price, artist.artist_ID
			FROM song
			INNER JOIN album ON song.album_ID = album.album_ID
			INNER JOIN artist ON album.artist_ID = artist.artist_ID
			WHERE album.album_ID = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $albumID);
		$stmt->execute();
		$stmt->bind_result($albImage, $albName, $artName, $songName, $songID, $songPrice, $artID);
		$songIDs = array();
		$songNames = array();
		$albumPrice;
		$soPrice;

		while ($stmt->fetch()) {
			$albumImage = $albImage;
			$albumName = $albName;
			$artistName = $artName;
			$artistID = $artID;
			$songIDs[] = $songID;
			$songNames[] = $songName;
			$albumPrice += $songPrice;
			$soPrice = $songPrice; 
		}

		$stmt->close();
	}
	?>

	<div class="container">
		<div class="row d-flex justify-content-between">
			<div class="col-3 justify-content-start">
				<?php
				echo '<img src="data:image/jpeg;base64,' . base64_encode($albumImage) . '" style="height: 150px; width: 150px;"/>';
				?>
			</div>
			<div class="col-3 pt-3">
				<p id="bold">Artist: <?php echo $artistName; ?></p>
				<p id="bold">Album: <?php echo $albumName; ?></p>
				<p id="bold">Price: <?php echo '$' . $albumPrice; ?></p>
			</div>
			<div class="col-3 align-self-center">
				<form action='/order/addAlbumToCartDB.php' method='post'><button name='albumID' type='submit' value=' <?php echo $albumID; ?> '>Add to Cart</button></form>
			</div>
		</div>
		<div class="row">
			<h3>Album Details</h3>
			<p>Lorem ipsum dolor sit amet, sed cu tritani albucius, pri ut commodo aperiri. 
			Eu sit paulo labores, quod scripserit ut duo, dicam causae ea mea. 
			Persius bonorum debitis sea at, sea postea molestie cu. 
			Prima mutat dicat ei per, in natum legendos deseruisse vix. 
			Mei an modo quaeque tibique, odio indoctum mea cu, mei ea discere aliquando omittantur.</p>
		</div>
		<div class="row">
			<?php
			echo "<table class='table table-hover' style='width: 100%'><tr><th>Song</th><th>Artist</th><th>Album</th><th>Price</th><th></th></tr>";

			for ($i = 0; $i < count($songIDs); $i++) {
				echo "<tr><td><a href='songInfo.php?" . $songIDs[$i] . "'>" . $songNames[$i] . "</a></td>" .
					 "<td><a href='artistInfo.php?" . $artistID . "'>" . $artistName . "</a></td>" .
					 "<td><a href='albumInfo.php?" . $albumID . "'>" . $albumName . "</a></td>" . 
					 "<td>" . '$' . $soPrice . "</td>" .
					 "<td><form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value='" . $songIDs[$i] . "'>Add to Cart</button></form></td></tr>";
			}

			echo "</table>";
			?>
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>