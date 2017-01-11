<html>
	<head>
		<title>University of Arkansas Ichthyology Teaching Collection Database</title>
	</head>
	<style>
		table, th, td{
			border: 2px solid black;
			border-collapse: collapse;
		}
		th, td{
			padding: 6px;
		}
	</style>
	<body>
		<h3>Enter all of the following data:</h3>

		<form action="php_addlocality.php" method="post">

			Enter the name of the new locality you would like to add to the database.<br>
			Locality Name:<input type="text" name="locality"><br>

			<input name="submit" type="submit" >
		</form>
		<br><br>
		If the locality you have added does not exist along a body of water already in the database, you will have to <a href="php_addwaterbody.php">add the new waterbody</a> as well.
		<br><br>
		You must also <a href="php_describelocality.php">describe the new locality</a>.
		<br><br>

		<a href="../index.html">Return to main page</a>
		<br><br>
	</body>
</html>

<?php
include '/home/mussmann/public_html/includes/php_db.php';  // put code location here
//------------------------------------------------------
// the main program
//------------------------------------------------------
if (isset($_POST['submit'])) 
{
 	// Call a function that does the insertion to mysql
	$connection = connect_db();

	$locality = $_POST['locality'];
	
	//sanitize input;
	$locality = $connection->real_escape_string($locality);

	echo $locality . "<br>";

	$insert = true;
	if(!val_not_empty($locality, "Locality Name"))
	{
		$insert = false;
	}

	//insert the locality
	$success = false;
	if($insert == true)
	{
		$success = insert_locality($locality, $connection);
	}

}
?>
