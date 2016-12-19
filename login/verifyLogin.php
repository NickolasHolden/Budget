<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Budget</title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="style.css" />
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
						
						# Database Connection --------------------------------------------
						include("../DBConnect.php");
						#-----------------------------------------------------------------
						
						# Table and User Selection ---------------------------------------
						$TableName = "users";
						# if there are no errors then select the user from the table
						if($errors == 0){
							$SQLstring = "SELECT profile_ID, first_name, last_name FROM" .
								" $TableName WHERE username = '" . 
								stripslashes($_POST['username']) . "' and password_md5 = '" .
								md5(stripslashes($_POST['password'])) . "'";
							# run the select statement
							$QueryResult = @mysql_query($SQLstring, $DBConnect); 
							# if select statement fails to select something then print error
							if(mysql_num_rows($QueryResult) == 0){
								echo "Incorrect username or password\n";
								++$errors;
							}else{ # if select statement returns user then set $profileId and $name
								# create array containing the query result
								$Row = mysql_fetch_assoc($QueryResult);
								$_SESSION['profile_ID'] = $Row['profile_ID'];
								$name = $Row['first_name'] . " " .
									$Row['last_name'];
								echo "Welcome back, $name!\n";
							}
						}#-----------------------------------------------------------------
						
						# if there are errors then tell user to go back
						if($errors > 0){
							echo "Please use the BACK button to return" .
								" to the form and fix the errors indicated.\n";
						}
						
						# Form Creation ---------------------------------------------------
						# create form with hidden fields if there are no errors
						if($errors == 0){
							echo "<br /><br />
								<a href='account.php?" . SID . "' class='budget'>Go to Account Page</a>
								<br />";
						}else{
							echo "<br /><br />
								<span>
								<form method='post' action='../index.php?page=login.html'>
								<input type='hidden' name='page' value='../index.php?page=login.html' />
								<input type='submit' name='submit' value='Back' />
								</form>
								</span>
								<br />";
						}#-----------------------------------------------------------------
					?>
					<br /><br />
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