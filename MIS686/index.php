<?php
	session_start();
	if(isset($_SESSION["user"])){
		$_SESSION["user"] = $_SESSION["user"];
	}

	
?>
<!-- To access database use:
user: admin
pass: admin321
--->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>Login</title>
</head>
<body>
	<H1>Welcome, Please Login in.</H1>
	<form method = "post" action = "homepage.php">
		<label for = "user">Username:</label>
		<input type="text" name="user">
		<label for = "pass">Password:</label>
		<input type="password" name="pass">
		<input type="submit" value="Login">

	</form>

</body>
</html>