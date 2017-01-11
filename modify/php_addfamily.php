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

		<form action="php_addfamily.php" method="post">


			Select the order to which your family belongs.<br>
			You will need to add a new order to the database if yours does not appear in the list.<br>
			<?php
				include '/home/mussmann/public_html/includes/php_db.php';  // put code location here
				order_list();
			?>
			<br><br>
			Family Name:<input type="text" name="Family"><br>

			<input name="submit" type="submit" >
		</form>
		<br><br>
		<a href="../index.html">Return to main page</a>
		<br><br>
	</body>
</html>

<?php
//include '/home/mussmann/public_html/includes/php_db.php';  // put code location here
//------------------------------------------------------
// the main program
//------------------------------------------------------
if (isset($_POST['submit'])) 
{
 	// Call a function that does the insertion to mysql
	$connection = connect_db();

	$family = $_POST['Family'];
	$orderID = $_POST['OrderID'];
	
	//sanitize input;
	$family = $connection->real_escape_string($family);

	echo $family . "<br>";
	echo $orderID . "<br>";

	$insert = true;
	if(!val_not_empty($family, "Family Name"))
	{
		$insert = false;
	}

	//insert the family
	$success = false;
	if($insert == true)
	{
		$sql = "SHOW TABLE STATUS LIKE 'family'";
		$result=$connection->query($sql);
		$row=$result->fetch_assoc();
		//echo $row['Auto_increment'];
		$familyID=$row['Auto_increment'];
		$success = insert_family($family, $familyID, $orderID, $connection);
	}


	//insert FamilyID,SpeciesID into lookupFamily
	if($success == true ){
		//echo "yay!" . "<br>";
		
	}

}
?>
