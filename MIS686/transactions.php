<?php 
session_start()
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>transactions</title>
</head>
<body>
	<h1>Please complete your transaction here:</h1>
	<form method="post" action = "transactions_check.php"> 
		<br>
		Owner ID: 
		<input type="number" name="Owner_ID">
		<br>
		Amount:
		<input type="number" name="Amount">
		<br>
		<input type="submit" value="Submit Transaction">
		<br>
	</form>
	<form method="post" action="index.php">
	<input type="submit" value="Back to Homepage">
	</form>
</body>
</html>