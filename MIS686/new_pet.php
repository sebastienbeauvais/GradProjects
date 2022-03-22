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
			<th>Owner ID</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>E-mail</th>
		</tr>
	<form method = "post" action = "insert_pet.php">

		<label for = "pet_name">Pet Name:</label>
		<input type="text" name="pet_name">

		<label for = "pet_breed">Breed ID:</label>
		<input type="number" name="pet_breed" min="1" max="17">

		<label for = "pet_age">Pet Age:</label>
		<input type="number" name="pet_age">

		<label for = "pet_gender">Gender:</label>
			<select name = "pet_gender">
				<option value = "M">M</option>
				<option value = "F">F</option>
			</select>
		<label for = "ownerid">Owner_ID:</label>
		<input type="number" name="ownerid">
		<input type="submit" value="Go">
	</form>

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
SELECT * FROM Owners
WHERE First_Name like "{$_SESSION["n_first_name"]}"
AND Last_Name like "{$_SESSION["n_last_name"]}";
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
	<table>
		<th>Breed_ID</th><th>Breed Name</th><br>
			<tr><td>1</td><td>Golden Retriever</td></tr>
			<tr><td>2</td><td>German Shepard</td></tr>
			<tr><td>3</td><td>Labrador Retriever</td></tr>
			<tr><td>4</td><td>Bulldog</td></tr>
			<tr><td>5</td><td>Pug</td></tr>
			<tr><td>6</td><td>Dobermann</td></tr>
			<tr><td>7</td><td>Shiba Inu</td></tr>
			<tr><td>8</td><td>Bernese Mountain Dog</td></tr>
			<tr><td>9</td><td>Border Collie</td></tr>
			<tr><td>10</td><td>Persian</td></tr>
			<tr><td>11</td><td>Maine Coon</td></tr>
			<tr><td>12</td><td>Bengal</td></tr>
			<tr><td>13</td><td>Scottish Fold</td></tr>
			<tr><td>14</td><td>Norwegian Forest</td></tr>
			<tr><td>15</td><td>Turkish Angora</td></tr>
			<tr><td>16</td><td>Burmese</td></tr>
			<tr><td>17</td><td>Ragamuffin</td></tr>
	</table>
<body>
</html>