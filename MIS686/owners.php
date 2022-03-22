<?php 
	session_start();
	if(isset($_SESSION["user"]))
		echo("Hello,")
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Owners</title>
</head>
<body>
	<?php 
		echo("Logged in as: {$_SESSION["user"]}");
	 ?>
	<h3>List of Owners</h3>
		<form method = "post" action = "new_owner.php">
		<label for = "n_first_name">First Name:</label>
		<input type="text" name="n_first_name">
		<label for = "n_last_name">Last Name:</label>
		<input type="text" name="n_last_name">
		<label for = "n_phone">Phone Number:</label>
		<input type="number" name="n_phone">
		<label for = "n_email">Email:</label>
		<input type="text" name="n_email">
		<input type="submit" value="Create new owner">
	</form>
	<br>
	<form method = "post" action = "owner_search.php">
		<label for = "search">Search last name:</label>
		<input type="text" name="search">
		<input type="submit" value="Go!">		
	</form>
	<br>
	<table>
		<tr>
			<th>Owner ID</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>E-mail</th>
		</tr>
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
SELECT * FROM owners;
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Fetch results from the SQL query
# OPTIONAL: MYSQLI_ASSOC setting
# Without this setting, the fields numbered. The first field is [0], the second is [1], etc.
# With this setting, the fields are named. First name is ["First_Name"], etc.
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

# Loop through query results row-by-row
# Each row will be stored in the $row variable
foreach ($data as $key => $value) {
	echo("<tr><td>{$value["Owner_ID"]}</td><td>{$value["First_Name"]}</td><td>{$value["Last_Name"]}</td><td>{$value["Phone"]}</td><td>{$value["Email"]}</td></tr>");
}

?>
	</table>
</body>
</html>