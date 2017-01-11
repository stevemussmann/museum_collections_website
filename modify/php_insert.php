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

		<form action="php_insert.php" method="post">


			Select a species from the list below.<br>
			You may need to add a species if yours does not appear in the list.<br><br>
			Species:
			<?php
				include '/home/mussmann/public_html/includes/php_db.php';  // put code location here
				species_list();
					echo " required field.";

				echo "<br><br>";
				echo 'Quantity:<input type="text" name="Quantity">';
			
					echo " required field.";
			
				echo "<br><br>";
				echo "Locality:";
		
				loc_list();
			
					echo " required field.";

				echo "<br><br>";
				echo "Water Body:";
				
				wb_list();

					echo " required field.";
	
				echo "<br><br>";
				echo "Year:";
			
				year_list();
				
					echo " required field.";
				
				echo "<br><br>";

				echo 'Storage:<select name="Storage">';
				echo '<option disabled selected value> -- select an option -- </option>';
				echo '<option value="Dry">Dry</option>';
				echo '<option value="EtOH">Ethanol</option>';
				echo '<option value="FORM">Formalin</option>';
				echo '<option value="i-PrOH">Isopropanol</option>';
				echo '</select>';

					echo " required field.";
				echo '<br><br>';
			
				echo 'Comment:<br>';
				echo '<textarea name="Comment" cols="40" rows="5"></textarea>';
				echo '<br><br>';
				echo 'Original Museum Number: <input type="text" name="OrigNum">';
					echo " Enter original museum number in this field if the speicmen is a gift from another museum (not required).";

				echo "<br><br>";
			?>
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
	//connect to db
	$connection = connect_db();

	// Call a function that does the insertion to mysql
	$species = $_POST['SpeciesID'];
	$quantity = $_POST['Quantity'];
	$loc = $_POST['LocalityID'];
	$wb = $_POST['WaterBodyID'];
	$year = $_POST['Year'];
	$storage = $_POST['Storage'];
	$comment = $_POST['Comment'];
	$orig = $_POST['OrigNum'];
	

	//sanitize input
	$comment = $connection->real_escape_string($comment);
	$orig = $connection->real_escape_string($orig);

	$insert = true;
	if((!val_not_empty($species,"Species")) || (!val_not_empty($quantity,"Quantity")) || (!val_not_empty($wb,"Water Body")) || (!val_not_empty($year,"Year")) || (!val_not_empty($storage,"Storage")) ){
		$insert = false;
	}

	//check if $quantity is an integer
	if(!val_int($quantity))
	{
		$insert = false;
	}

	//check if $loc + $wb combination occurs in localityInfo table
	if(!check_exists($loc,$wb,$connection))
	{
		echo '<br><font color="red"> Locality and WaterBody combination has not been described.<br>You must describe this locality before entering this specimen into the database.<br>Specimen has not been added to the database.<br><br>';
		$insert = false;
	}


	$success = false;
	if($insert == true)
	{
		echo "Insert is true<br>";
		$success = insert_specimen($species,$quantity,$loc,$wb,$year,$storage,$comment,$orig,$connection);
	}


}
?>
