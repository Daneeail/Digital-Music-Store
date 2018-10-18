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
    <title>Song Information</title>
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
	$songID = $_SERVER["QUERY_STRING"];
	$albumImage;
	$songName;
	$albumName;
	$artistName;

	$sql = "SELECT album.album_image, album.album_name, song.song_name, song.song_price, artist.artist_name
			FROM song
			INNER JOIN album ON song.album_ID = album.album_ID
			INNER JOIN artist ON album.artist_ID = artist.artist_ID
			WHERE song_ID = ?";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $songID);
		$stmt->execute();
		$stmt->bind_result($albImage, $albName, $soName, $soPrice, $artName);

		while ($stmt->fetch()) {
			$albumImage = $albImage;
			$songName = $soName;
			$songPrice = $soPrice;
			$albumName = $albName;
			$artistName = $artName;
		}
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
				<p id="bold">Song: <?php echo $songName; ?></p>
				<p id="bold">Artist: <?php echo $artistName; ?></p>
				<p id="bold">Album: <?php echo $albumName; ?></p>
				<p id="bold">Price: $<?php echo $songPrice; ?></p>
			</div>
			<div class="col-3 align-self-center">
				<form action='/order/addSongToCartDB.php' method='post'><button name='songID' type='submit' value=' <?php echo $songID; ?> '>Add to Cart</button></form>
			</div>
		</div>
		<div class="row">
			<h3>Song Details</h3>
			<p>Lorem ipsum dolor sit amet, sed cu tritani albucius, pri ut commodo aperiri. 
			Eu sit paulo labores, quod scripserit ut duo, dicam causae ea mea. 
			Persius bonorum debitis sea at, sea postea molestie cu. 
			Prima mutat dicat ei per, in natum legendos deseruisse vix. 
			Mei an modo quaeque tibique, odio indoctum mea cu, mei ea discere aliquando omittantur.</p>
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>