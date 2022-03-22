<?php 
	session_start();
	if(isset($_SESSION["user"]))
		echo("Creating new owner...");

	$_SESSION["n_first_name"] = $_POST["n_first_name"];
	$_SESSION["n_last_name"] = $_POST["n_last_name"];

 ?>

<html>
<head>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>New Owner</title>
</head>
<body>
<?php

# Set up parameters to connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vet";

# Create connection to database
$conn = mysqli_connect($servername, $username, $password, $dbname);

# Check the connection was successful
if (!$conn) {
	die(mysqli_connect_error());
}

# SQL query to run
$sql = <<<SQL
INSERT INTO owners(First_Name, Last_Name, Phone, Email)
VALUES ("{$_POST["n_first_name"]}", "{$_POST["n_last_name"]}", {$_POST["n_phone"]}, "{$_POST["n_email"]}"); 
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Check if the modification was performed successfully
if ($result) {
	echo("New owner has been entered");
} else {
	echo("There was a problem, please try again.");
}

?>
<form method="post" action="new_pet.php">
	<input type="submit" value="New Pet">
</form>

<body>
</html>