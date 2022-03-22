<?php 
	session_start();
	if(isset($_SESSION["user"]))
		echo("{$_SESSION['user']}");

 ?>

<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>Owner Search</title>
</head>
<body>
	<table>
		<tr>
			<th>Owner</th><th>Pet Name</th><th>Breed</th><th>Age</th><th>Gender</th><th>Total Spent</th>
		</tr>
<?php
#########################################################################################
## NOTE: This should show all information related to an owner (pet, transactions, etc) ##
#########################################################################################

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
	SELECT CONCAT(o.first_name, " ",o.Last_Name) AS Name, p.name as Pet_Name, b.breed_name AS Breed_Name, p.age AS Age, p.gender AS Gender, SUM(t.amount) AS Transaction_Total
	FROM Owners o
	JOIN Pets p
	ON o.owner_id = p.owner_ID
	JOIN Breeds b
	ON p.breed_ID = b.breed_ID
	JOIN Transactions t
	ON o.owner_id = t.owner_ID
	WHERE o.Last_Name LIKE "%{$_POST["search"]}%"
	GROUP BY o.Owner_ID;
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
	echo("<tr><td>{$value["Name"]}</td><td>{$value["Pet_Name"]}</td><td>{$value["Breed_Name"]}</td><td>{$value["Age"]}</td><td>{$value["Gender"]}</td><td>{$value["Transaction_Total"]}</td></tr>");
}

?>
	</table>
<form method = "post" action = owners.php>
	<input type="submit" value="Back To Owners">
</form>
<body>
</html>