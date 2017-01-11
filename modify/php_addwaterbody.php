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

		<form action="php_addwaterbody.php" method="post">

			Enter the name of the new locality you would like to add to the database.<br>
			Water Body Name:<input type="text" name="wb"><br>

			<input name="submit" type="submit" >
		</form>
		<br><br>
		If you have not yet added the specific locality for this water body to the database, you will have to <a href="php_addlocality.php">add a locality</a> as well.
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

	$wb = $_POST['wb'];
	
	//sanitize input;
	$wb = $connection->real_escape_string($wb);

	echo $wb . "<br>";

	$insert = true;
	if(!val_not_empty($wb, "WaterBody Name"))
	{
		$insert = false;
	}

	//insert the body of water
	$success = false;
	if($insert == true)
	{
		$success = insert_wb($wb, $connection);
	}

}
?>
