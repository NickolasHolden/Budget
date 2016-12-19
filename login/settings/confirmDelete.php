<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Budget</title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
		<div id="wrapper">
			<div id="top">
			</div>
			<div id="content">
				<div id="header">
					Budget
				</div>
				<div id="menu">
				</div>
				<div id="stuff">
					<?php
						$errors = 0;
					
						# Database Connection ---------------------------------------------------------
						include("../../DBConnect.php");
						#------------------------------------------------------------------------------
						
						# Table Selection and Financial Info Deletion ------------------------------------
						$TableName = "finance_info";
						# if there are no errors then delete user's financial info
						if($errors == 0){
							$SQLstring = "DELETE FROM $TableName WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
							# run the delete statement
							$QueryResult = @mysql_query($SQLstring, $DBConnect);
							# print error if delete statement fails
							if($QueryResult === FALSE){
								echo "Could not delete financial info from database.";
								++$errors;
							}
						}
						
						$TableName2 = "expenses";
						# if there are no errors then delete user's expenses
						if($errors == 0){
							$SQLstring = "DELETE FROM $TableName2 WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
							# run the delete statement
							$QueryResult = @mysql_query($SQLstring, $DBConnect);
							# print error if delete statement fails
							if($QueryResult === FALSE){
								echo "Could not delete expenses from database.";
								++$errors;
							}
						}
						
						$TableName3 = "users";
						# if there are no errors then delete user account
						if($errors == 0){
							$SQLstring = "DELETE FROM $TableName3 WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
							# run the delete statement
							$QueryResult = @mysql_query($SQLstring, $DBConnect);
							# print error if delete statement fails
							if($QueryResult === FALSE){
								echo "Could not delete user account.";
								++$errors;
							}
						}#-----------------------------------------------------------------------------
						
						if($errors == 0){
							echo "Your account has been successfully deleted.";
						}
					?>
					
					<br /><br />
					<a href="../../index.php?page=home.html" class="budget">Home</a>
					<br />
				</div>
				</div>
			<div id="bottom">
				Web Design by jedignork &nbsp;&bull;&nbsp;
				Rounded_2 &nbsp;&bull;&nbsp;
				From &copy; Open Source Web Design 2016
			</div>
		</div>
	</body>
</html>