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
		<h3>Enter your information and press the button to search:</h3>

		<form action="php_search.php" method="post">
			Search by:<br>
			<input type="radio" name="searchby" value="ITC"> ITC#<br>
			<input type="radio" name="searchby" value="Orders" checked="checked"> Order<br>
			<input type="radio" name="searchby" value="Family"> Family<br>
			<input type="radio" name="searchby" value="Species"> Species<br><br>
			Enter your search term:<br>
			<input type="text" name="term"><br><br>
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
   searchdata($_POST['searchby'], $_POST['term']);
}
?>
