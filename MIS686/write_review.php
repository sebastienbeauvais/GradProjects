<?php 
session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Write a review</title>
</head>
<body>
	<h3>Write your review below</h3>

	<form method = "post" action = "submit_review.php">
		<label for = "stars">Rating:</label>
			<select name = "stars">
				<option value = "1">1</option>
				<option value = "2">2</option>
				<option value = "3">3</option>
				<option value = "4">4</option>
				<option value = "5">5</option>			
			</select>
			<br>
		<label for = "review_text">Review:</label>
		<input type="text" name="review_text">
		<br>
		<input type="submit" value="Submit">		
	</form>


</body>
</html>