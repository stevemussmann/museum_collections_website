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

		<form action="php_addorder.php" method="post">

			Enter the name of the order you would like to add to the database.<br>
			Order Name:<input type="text" name="Order"><br>

			<input name="submit" type="submit" >
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

	$order = $_POST['Order'];
	
	//sanitize input;
	$order = $connection->real_escape_string($order);

	echo $order . "<br>";

	$insert = true;
	if(!val_not_empty($order, "Order Name"))
	{
		$insert = false;
	}

	//insert the family
	$success = false;
	if($insert == true)
	{
		$success = insert_order($order, $connection);
	}

}
?>
