<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <meta charset="utf-8" />
	<meta name="description" content="User creates account.">
    <meta name="viewport" content="width=divice-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="/js/verifyUsername.js" type="text/javascript"></script>
</head>

<body>
	
	<!--Header-->
    <?php include "../header.php"; ?>
	
	<!--Content-->
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <h2 class="pt-4">Create an Account</h2>
            <br />
            <form class="col-12" action="createAccountDB.php" method="post">
                <label for="fName">Name:</label>
                <input type="text" class="form-control" id="fName" name="fName" />
                <br />
                <label for="fEmail">Email:</label>
                <input type="text" class="form-control" id="fEmail" name="fEmail" />
                <br />
                <label for="fUsername">Username:</label>
                <input type="text" class="form-control" id="fUsername" name="fUsername" />
                <br />
                <label for="fPassword">Password:</label>
                <input type="password" class="form-control" id="fPassword" placeholder="Must be at least 8 characters" name="fPassword" />
                <br />
                <label for="fRePassword">Reenter Password:</label>
                <input type="password" class="form-control" id="fRePassword" name="fRePassword" />
                <br />
                <input class="btn btn-primary" type="submit" value="Create Account" />
            </form>
        </div>
    </div>

	<!--Footer-->
    <?php include "../footer.html"; ?>

</body>
</html>