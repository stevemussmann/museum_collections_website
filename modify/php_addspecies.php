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

		<form action="php_addspecies.php" method="post">


			Select the family to which your species belongs.<br>
			You will need to add a new family to the database if yours does not appear in the list.<br>
			<?php
				include '/home/mussmann/public_html/includes/php_db.php';  // put code location here
				family_list();
			?>
			<br><br>
			Species Name:<input type="text" name="Species"><br>

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

	$species = $_POST['Species'];
	$familyID = $_POST['FamilyID'];
	
	//sanitize input;
	$species = $connection->real_escape_string($species);

	//echo $species . "<br>";
	//echo $familyID . "<br>";

	$insert = true;
	if(!val_not_empty($species, "Species Name"))
	{
		$insert = false;
	}
	
	//insert the species
	$success = false;
	if($insert == true)
	{
		$sql = "SHOW TABLE STATUS LIKE 'species'";
		$result=$connection->query($sql);
		$row=$result->fetch_assoc();
		//echo $row['Auto_increment'];
		$speciesID=$row['Auto_increment'];
		$success = insert_species($species, $speciesID, $familyID, $connection);
	}


	//insert FamilyID,SpeciesID into lookupFamily
	if($success == true ){
		//echo "yay!" . "<br>";
		
	}

}
?>
