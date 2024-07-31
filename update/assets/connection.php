<?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = new mysqli('localhost', 'u552028129_management', 'BigBoss*01', 'u552028129_garahehub');
	if($conn->connect_error) {
	  exit('Failed to connect to the database');
	}
?>