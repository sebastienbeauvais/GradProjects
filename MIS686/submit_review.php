<?php
session_start();
	if(isset($_SESSION["user"], $_SESSION["pass"])){
		
		$connect=mysqli_connect("localhost", "root", "", "vet") or die("Connection Failed");
		if(!empty($_POST['save']));
		{
			$query = "SELECT * FROM login WHERE username='{$_SESSION["user"]}' AND pass='{$_SESSION["pass"]}'"; #HERE IS THE QUERY. IT DOES PULL CORRECT OWNER_ID BUT STORES IN ARRAY
			$result=mysqli_query($connect,$query);
			$count=mysqli_num_rows($result);
			if($count>0){
				$data = mysqli_fetch_all($result, MYSQLI_ASSOC); 
				extract($data);										#I WOULD LIKE TO MAKE $ownerID = $data AND HAVE ownerID BE JUST THE VALUE
			}else{
				echo'<form method="post" action="index.php">
					<input type="submit" value="Login">
				</form>';
				die();
			}
		}
	}
 ?>

<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.4/css/foundation.min.css">
	<title>review data</title>
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

$date = date("Y-m-d");

# SQL query to run
$sql = <<<SQL
INSERT INTO Reviews (Name, date, rating, review_text)
VALUES (  "{$_SESSION["user"]}", "$date", "{$_POST["stars"]}", "{$_POST["review_text"]}"); # I WANT TO CALL 'ownerID' HERE, SET BLANK SO PAGE WORKS
SQL;

# Send SQL query to the database
$result = mysqli_query($conn, $sql);

# Check if the modification was performed successfully
if ($result) {
	echo("Thank you for submitting a review!");
} else {
	echo("Sorry there was an error processing your review. Please try again.");
}

?>
	<form method = "post" action = "reviews.php">
		<input type="submit" value="Back to reviews">
	</form>
	<form method = "post" action = "index.php">
		<input type="submit" value="Back to homepage">
	</form>
<body>
</html>