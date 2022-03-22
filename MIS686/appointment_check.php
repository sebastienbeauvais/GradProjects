<?php 
session_start()
 ?>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
 	<title>Appointment Check</title>
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

$sql = <<<SQL
INSERT INTO Appointments (Pet_Name, appt_date, appt_time)
VALUES ("{$_POST["Pet_Name"]}", "{$_POST["appt_date"]}", "{$_POST["appt_time"]}")
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Check if the modification was performed successfully
if ($result) {
	echo("A new appointment has been created for {$_POST["Pet_Name"]} on {$_POST["appt_date"]} at {$_POST["appt_time"]}.");
} else {
	echo("Sorry, this time is unavailable. Please try again.");
}
?>
<br>
<form method="post" action="appointment.php">
<input type="submit" value="Back to appointments">
</form>
</body>
</html>