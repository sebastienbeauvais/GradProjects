<?php  
session_start()
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>transactions_check</title>
</head>
<body>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vet";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die(mysqli_connect_error());
}

# SQL query to run
$sql = <<<SQL
INSERT INTO Transactions(Owner_ID, Amount)
VALUES ("{$_POST["Owner_ID"]}", "{$_POST["Amount"]}")
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Check if the modification was performed successfully
if ($result) {
	echo("Transaction was successfully submitted");
} else {
	echo("There was a problem, please try again.");
}
?>
<form method="post" action="index.php">
<input type="submit" value="Back to Homepage">
</body>
</html>