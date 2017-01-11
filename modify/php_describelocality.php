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

		<form action="php_describelocality.php" method="post">

			Select a locality from the list:<br>
			<?php
				include '/home/mussmann/public_html/includes/php_db.php'; // put code location here
				loc_list();
			?>

			<br><br>
			Select a waterbody from the list:<br>
			<?php
				wb_list();
			?>
			
			<br><br>
			Description:<br><textarea name="Description" cols="40" rows="5"></textarea>

			<br><br>
			County:<input type="text" name="County">

			<br><br>
			State:<select name="State">
				<option disabled selected value> -- select an option -- </option>	
				<option value="NULL">None</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
			<br><br>
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

	$loc = $_POST['LocalityID'];
	$wb = $_POST['WaterBodyID'];
	$desc = $_POST['Description'];
	$county = $_POST['County'];
	$state = $_POST['State'];
	
	//sanitize input;
	$desc = $connection->real_escape_string($desc);
	$county = $connection->real_escape_string($county);


	$insert = true;
	if(!val_not_empty_noprint($desc, "Description"))
	{
		$desc = "NULL";
	}else{
		$desc = '\'' . $desc . '\'';
	}

	if(!val_not_empty_noprint($county, "County"))
	{
		$county = "NULL";
	}else{
		$county = '\'' . $county . '\'';
	}

	if($state == "NULL"){
		$state = "NULL";
	}else{
		$state = '\'' . $state . '\'';
	}

	echo $desc . "<br>";
	echo $county . "<br>";
	echo $state . "<br>";


	//insert the description
	$success = false;
	if($insert == true)
	{
		$success = insert_description($loc, $wb, $desc, $county, $state, $connection);
	}

}
?>
