<?php 
	session_start();
 ?>

<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>Customer Search</title>
</head>
<body>
	<table>
		<tr>
			<th>Name</th><th>Date</th><th>Rating</th><th>Review</th>
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
SELECT Name, Date, Rating, Review_Text 
FROM Reviews
WHERE Review_Text LIKE "%{$_POST["search"]}%"
AND Rating = {$_POST["stars"]};
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
	echo("<tr><td>{$value["Name"]}</td><td>{$value["Date"]}</td><td>{$value["Rating"]}</td><td>{$value["Review_Text"]}</td></tr>");
}

?>
	</table>
<body>
</html>