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

		<form action="php_updatequantity.php" method="post">

			Enter the ITC# for the sample you would like to update.<br>
			ITC#:<input type="text" name="ITC">
			<br><br>
			
			New Quantity:<input type="text" name="Quantity">
			<br><br>
			
			<input name="submit" type="submit" >
			<br><br>
		
		</form>
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

	$itc = $_POST['ITC'];
	$qty = $_POST['Quantity'];
	
	//sanitize input;
	$itc = $connection->real_escape_string($itc);
	$qty = $connection->real_escape_string($qty);

	$insert = true;
	if(!val_int($qty) || !val_int($itc))
	{
		$insert = false;
	}

	if(!val_not_empty($itc, "ITC") || !val_not_empty($qty, "Quantity"))
	{
		$insert = false;
	}

	//Update the quantity
	$success = false;
	if($insert == true)
	{
		$success = update_qty($itc,$qty, $connection);
	}

}
?>
