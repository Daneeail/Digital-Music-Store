<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
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
		<div class="row justify-content-center align-items-center">
			<h2 class="pt-4">Sign In</h2>
			<br />
			<form class="col-12" action="verifySignIn.php" method="post">
				<label for="email">Username:</label> 
				<input type="text" class="form-control" id="email" placeholder="Enter Username" name="username" />
				<br />
				<label for="password">Password:</label> 
				<input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" />
				<br />
				<input class="btn btn-primary" type="submit" value="Sign In" />
			</form>
			<br />
			<span>New User? <a href="/account/createAccount.php">Click Here</a></span>
			<br />
		</div>
	</div>

	<!--Footer-->
    <?php include "../footer.html"; ?>
</body>
</html>
