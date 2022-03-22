<?php 
session_start()
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Appointments</title>
</head>
<body>
	<h1>Please select an appointment time:</h1>
	<h3>Hours are from 6:00 AM to 5:00 PM, 7 days a week.</h3>
	<form method="post" action = "appointment_check.php"> 
		<br>
		Pet Name: 
		<input type="text" name="Pet_Name">
		<br>
		Date:
		<input type="date" name="appt_date">
		<br>
		Time:
		<input type="time" name="appt_time">
		<input type="submit" value="Check for Availability">
		<br>
	</form>
	<form method="post" action="index.php">
	<input type="submit" value="Back to Homepage">
	</form>
</body>
</html>