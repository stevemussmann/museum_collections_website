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
		<h3>Press button to view all specimens in the database:</h3>

		<form action="php_viewall.php" method="post">
			Sort by:<br>
			<input type="radio" name="sortby" value="ITC" checked="checked"> ITC#<br>
			<input type="radio" name="sortby" value="Orders"> Order<br>
			<input type="radio" name="sortby" value="Family"> Family<br>
			<input type="radio" name="sortby" value="Species"> Species<br>
			<input name="submit" type="submit" >
		</form>
		<br><br>
		<a href="index.html">Return to main page</a>
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
   viewall($_POST['sortby']);
}

?>
