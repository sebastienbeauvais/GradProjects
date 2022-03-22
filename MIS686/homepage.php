<?php 
	session_start();
	if(isset($_POST["user"], $_POST["pass"])){
		$_SESSION["user"] = $_POST["user"];
		$_SESSION["pass"] = $_POST["pass"];
	}
	$connect=mysqli_connect("localhost", "root", "", "vet") or die("Connection Failed");
	if(!empty($_POST['save']));
	{
		$user=$_POST['user'];
		$pass = mysqli_real_escape_string($connect, 
		$_POST["pass"]);
		$query = "SELECT * FROM login WHERE username='$user' AND pass='$pass'";
		$result=mysqli_query($connect,$query);
		$count=mysqli_num_rows($result);
		if($count>0){
			echo "Login Successful";
		}else{
			echo("Login Failed. Your username or password is incorrect.");
			die();
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homepage</title>
</head>
<body>
	<h1><?php 
	echo("Hello, {$_SESSION["user"]}!");
	 ?></h1>

	<br>
	<h4>What can we help you with?</h4>
	<form method = "post" action = owners.php>
		<input type="submit" value="Owners">
	</form>

	<form method = "post" action = appointment.php>
		<input type="submit" value="Schedule an appointment">
	</form>

	<form method = "post" action = reviews.php>
		<input type="submit" value="Reviews">
	</form>

	<form method = "post" action = transactions.php>
		<input type="submit" value="Make a transaction">
	</form>
</body>
</html>