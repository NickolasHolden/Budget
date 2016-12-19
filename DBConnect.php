<?php
	# connect to database server
	$DBConnect = @mysql_connect("localhost", "root", "");
	# if server connection fails then print error
	if($DBConnect === FALSE){
		echo "Unable to connect to the database.\n";
		++$errors;
	}else{ # if server successfully connects then connect to database
		$DBName = "budget_db";
		$result = @mysql_select_db($DBName, $DBConnect);
		# if database connection fails then print error
		if($result === FALSE){
			echo "Unable to select the database.";
			++$errors;
		}
	}
?>