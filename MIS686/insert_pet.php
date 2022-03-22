<?php 
	session_start();
	if(isset($_SESSION["user"]))
		echo("Creating new pet...");
 ?>

<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>Insert New Pet</title>
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
INSERT INTO Pets (owner_id, name, breed_id, age, gender)
VALUES ({$_POST["ownerid"]}, "{$_POST["pet_name"]}", {$_POST["pet_breed"]}, {$_POST["pet_age"]}, "{$_POST["pet_gender"]}");
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Check if the modification was performed successfully
if ($result) {
	echo("Pet has been successfully entered.");
	echo'<form method="post" action="owners.php">
			<input type="submit" value="Back">
		</form>';
} else {
	echo("There seems to be a problem with the data you entered. Please try again.");
	echo '<br>';
	echo'<form method="post" action="owners.php">
			<input type="submit" value="Try Again">
		</form>';
}

?>
<body>
</html>
