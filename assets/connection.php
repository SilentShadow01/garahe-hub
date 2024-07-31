<?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = new mysqli('localhost', 'lstvroot', 'Lstv@2016', 'bluebirdhotel');
	if($conn->connect_error) {
	  exit('Failed to connect to the database');
	}
?>