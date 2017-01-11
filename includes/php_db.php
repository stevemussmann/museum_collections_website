<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


//connect to Database
function connect_db ()
{
   $username="REDACTED";    // change to your mysql username
   $password="REDACTED";  // change to your mysql password
   $dbname ="REDACTED";     // change to your mysql username
   $servername ="REDACTED";     

   //create the connection
   $connection = new mysqli($servername, $username, $password, $dbname);	
   if ($connection->connect_error) 
      die("Connection failed: " . $connection->connect_error);
   else
      return $connection;
}

// Insert into any table, any values from data passed in as String parameters
function insert($table, $values, $connection)
{ 
    $query = 'INSERT into ' . $table . ' values (' . $values . ')' ;
	echo $query . "<br>";
    $result = $connection->query($query);
	if($result)
		return true;
	else
		return false;
}

function family_list()
{
	$connection = connect_db();
	$result = $connection->query("SELECT FamilyID,Family FROM family ORDER BY Family");
	echo "<select name='FamilyID'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	while( $row = $result->fetch_assoc()){
		unset($FamilyID,$Family);
		$FamilyID = $row['FamilyID'];
		$Family = $row['Family'];
		echo '<option value="' . $FamilyID . '">' . $Family . '</option>';
	}

	echo "</select>";
}

function order_list()
{
	$connection = connect_db();
	$result = $connection->query("SELECT OrderID,Orders FROM orders ORDER BY Orders");
	echo "<select name='OrderID'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	while( $row = $result->fetch_assoc()){
		unset($OrderID,$Order);
		$OrderID = $row['OrderID'];
		$Order = $row['Orders'];
		echo '<option value="' . $OrderID . '">' . $Order . '</option>';
	}

	echo "</select>";
}

function species_list()
{
	$connection = connect_db();
	$result = $connection->query("SELECT SpeciesID,Species FROM species ORDER BY Species");
	echo "<select name='SpeciesID'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	while( $row = $result->fetch_assoc()){
		unset($SpeciesID,$Species);
		$SpeciesID = $row['SpeciesID'];
		$Species = $row['Species'];
		echo '<option value="' . $SpeciesID . '">' . $Species . '</option>';
	}

	echo "</select>";
}

function year_list()
{
	echo "<select name='Year'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	for($i=2000; $i<date("Y")+1; $i++){
		echo '<option value="' . $i . '">' . $i . '</option>';
	}

	echo "</select>";
}

function loc_list()
{
	$connection = connect_db();
	$result = $connection->query("SELECT LocalityID,Locality FROM localities ORDER BY Locality");

	echo "<select name='LocalityID'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	while( $row = $result->fetch_assoc()){
		unset($LocalityID,$Locality);
		$LocalityID=$row['LocalityID'];
		$Locality=$row['Locality'];
		echo '<option value="' . $LocalityID . '">' . $Locality . '</option>';
	}

	echo "</select>";
}

function wb_list()
{
	$connection = connect_db();
	$result = $connection->query("SELECT WaterBodyID,WaterBody FROM waterBodies ORDER BY WaterBody");

	echo "<select name='WaterBodyID'>";
	echo "<option disabled selected value> -- select an option -- </option>";

	while( $row = $result->fetch_assoc()){
		unset($WaterBodyID,$WaterBody);
		$WaterBodyID=$row['WaterBodyID'];
		$WaterBody=$row['WaterBody'];
		echo '<option value="' . $WaterBodyID . '">' . $WaterBody . '</option>';
	}

	echo "</select>";
}


function print_table($result)
{
   echo '<table style=\"width:100%\">';
   $first_row = true;
   while ($row = mysqli_fetch_assoc($result)) 
   {
      if ($first_row) 
      {
         $first_row = false;

         // Output header row from keys.
         echo '<tr>';
         foreach($row as $key => $field) 
             echo '<th>' . $key . '</th>';
         echo '</tr>';
      }

      echo '<tr>';
      foreach($row as $key => $field) 
         echo '<td>' . $field . '</td>';

   echo '</tr>';
   }
   echo '</table>';
}

// execute a query and print the results
function query($q, $connection) 
{
   $result = $connection->query($q);
   echo '<br><hr><br>';
   echo '<br><h3>Result: </h3>';
   print_table($result);
}

function insert_species( $species, $speciesID, $familyID, $connection )
{
	// Insert the species name
	$values = 'DEFAULT' . ',\'' . $species . '\'';
	if(insert("species", $values, $connection)){
		$famvalues = $familyID . ',' . $speciesID;
		insert("lookupFamily", $famvalues, $connection);
		echo '<br>Insertion of ' . $species . ' successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function insert_family( $family, $familyID, $orderID, $connection )
{
	// Insert the family name
	$values = 'DEFAULT' . ',\'' . $family . '\'';
	if(insert("family", $values, $connection)){
		$ordvalues = $orderID . ',' . $familyID;
		insert("lookupOrder", $ordvalues, $connection);
		echo '<br>Insertion of ' . $family . ' successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function insert_order( $order, $connection )
{
	// Insert the order name
	$values = 'DEFAULT' . ',\'' . $order . '\'';
	if(insert("orders", $values, $connection)){
		echo '<br>Insertion of ' . $order . ' successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function update_qty($itc, $qty, $connection)
{
	$query = "UPDATE specimens SET Quantity=" . $qty . " WHERE ITC=" . $itc;
	$result = $connection->query($query);
	if($result)
		return true;
	else
		return false;
}

function insert_locality( $locality, $connection )
{
	// Insert the locality name
	$values = 'DEFAULT' . ',\'' . $locality . '\'';
	if(insert("localities", $values, $connection)){
		echo '<br>Insertion of ' . $locality . ' successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function insert_wb( $wb, $connection )
{
	// Insert the waterbody name
	$values = 'DEFAULT' . ',\'' . $wb . '\'';
	if(insert("waterBodies", $values, $connection)){
		echo '<br>Insertion of ' . $wb . ' successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function insert_description($loc, $wb, $desc, $county, $state, $connection)
{
	// Insert the locality description
	$values = $loc . ',' . $wb . ',' . $desc . ',' . $county . ',' . $state;
	if(insert("localityInfo", $values, $connection)){
		echo '<br>Insertion successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

function insert_specimen($species, $quantity, $loc, $wb, $year, $storage, $comment, $orig, $connection)
{
	//prepare storage
	$storage = '\'' . $storage . '\'';

	//prepare comment
	if(!val_not_empty_noprint($comment, "Comment"))
	{
		$comment = "NULL";
	}else{
		$comment = '\'' . $comment . '\'';
	}

	if(!val_not_empty_noprint($orig, "Original Number"))
	{
		$orig = "NULL";
	}else{
		$orig = '\'' . $orig . '\'';
	}

	// Insert the locality description
	$values = 'DEFAULT' . ',' . $species . ',' . $quantity . ',' . $loc . ',' . $wb . ',' . $year . ',' . $storage . ',' . $comment . ',' . $orig;
	if(insert("specimens", $values, $connection)){
		echo '<br>Insertion successful.<br>';
		return true;
	}else{
		echo '<br><font color="red">Insertion Failed.</font><br>';
		return false;
	}
}

//check if a LocalityID and WaterBodyID pair already exists in the database
function check_exists($loc, $wb, $connection)
{
        $query = "SELECT * FROM localityInfo WHERE LocalityID=" . $loc . " AND WaterBodyID=" . $wb;
        $rows = rowcount($query, $connection);
        #echo("The number of rows is " . $rows);
        if($rows<1){
                return false;
        }else{
                return true;
        }
}

function viewall($sortby)
{
	$connection = connect_db();
	$query = 'select s.ITC,o.Orders,f.Family,p.Species,s.Quantity,s.Storage from specimens s INNER JOIN species p ON s.SpeciesID=p.SpeciesID INNER JOIN lookupFamily l ON s.SpeciesID=l.SpeciesID INNER JOIN family f ON f.FamilyID=l.FamilyID INNER JOIN lookupOrder lo ON l.FamilyID=lo.FamilyID INNER JOIN orders o ON o.OrderID=lo.OrderID ORDER BY ' . $sortby;
	query($query, $connection);
}

function searchdata($searchby, $term)
{
	$connection = connect_db();
	$query = 'select s.ITC,o.Orders,f.Family,p.Species,s.Quantity,s.Storage from specimens s INNER JOIN species p ON s.SpeciesID=p.SpeciesID INNER JOIN lookupFamily l ON s.SpeciesID=l.SpeciesID INNER JOIN family f ON f.FamilyID=l.FamilyID INNER JOIN lookupOrder lo ON l.FamilyID=lo.FamilyID INNER JOIN orders o ON o.OrderID=lo.OrderID WHERE ' . $searchby . ' LIKE \'%' . $term . '%\' ORDER BY ITC';

	query($query, $connection);

}

//count the number of rows in a result
function rowcount($q, $connection)
{
	$result = $connection->query($q);
	$rows = $result->num_rows;
	return $rows;
}

//validate an integer
function val_int($int)
{
	echo('<br>');
	if(!filter_var($int, FILTER_VALIDATE_INT) === false)
	{
		//echo("<br>Integer is valid<br>");
		return true;
	}else{
		echo("<br><font color=\"red\">Quantity " . '\'' . $int . '\'' . " is not a valid number.</font><br>");
		return false;
	}
}

function val_not_empty($var, $field_name)
{
	if(!empty($var))
	{
		return true;
	}
	else
	{
		echo("<br><font color=\"red\">" . $field_name . " is a required field.</font><br>");
		return false;
	}
}

function val_not_empty_noprint($var, $field_name)
{
	if(!empty($var))
	{
		return true;
	}else{
		return false;
	}
}

?>
