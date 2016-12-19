<div id="stuff">
	<b>User Registration</b>
	<?php
		$errors = 0;
		$email = "";
		
		# Email Validation ----------------------------------------------
		# if email textbox is empty then print error
		if(empty($_POST['email'])){
			++$errors;
			echo "<p>You need to enter an e-mail address.</p>\n";
		}else{ # if email textbox is not empty set equal to $email
			$email = stripslashes($_POST['email']);
			
			# if regular expression and email don't match then print error
			if(preg_match("/^[\w-]+([\.[\w-]+)*@[\w-]+(\.[\w-]+)*" .
					"(\.[a-zA-Z]{2,})$/i", $email) == 0){
				++$errors;
				echo "<p>You need to enter a valid e-mail " .
					"address.</p>\n";
				$email = "";
			}
		}#-----------------------------------------------------------------
		
		# Password Validation ---------------------------------------------
		# if password textbox is empty then print error
		if(empty($_POST['password'])){
			++$errors;
			echo "<p>You need to enter a password.</p>\n";
			$password = "";
		}else{ # if password textbox is not empty set equal to $password
			$password = stripslashes($_POST['password']);
		}
		# if confirm password textbox is empty then print error
		if(empty($_POST['password2'])){
			++$errors;
			echo "<p>You need to enter a confirmation password</p>\n";
			$password2 = "";
		}else{ # if confirm password textbox is not empty set equal to $password2
			$password2 = stripslashes($_POST['password2']);
		}
		# if password and confirm password are not empty check if valid
		if(!empty($password) && !empty($password2)){
			# if password is less than 6 characters long then print error
			if(strlen($password) < 6){
				++$errors;
				echo "<p>The password is too short.</p>\n";
				$password = "";
				$password2 = "";
			}
			# if passwords don't match then print error
			if($password <> $password2){
				++$errors;
				echo "<p>The passwords do not match.</p>\n";
				$password = "";
				$password2 = "";
			}
		}#-----------------------------------------------------------------
		
		# Database Connection ---------------------------------------------
		$DBConnect = FALSE;
		# if there are no errors then connect to the database server
		if($errors == 0){
			include("DBConnect.php");
		}#-----------------------------------------------------------------
		
		# Table Selection and Email Check ---------------------------------
		$TableName = "users";
		# if there are no errors then select the number of fields in the table
		if($errors == 0){
			$SQLstring = "SELECT COUNT(*) FROM $TableName WHERE " .
				"email = '$email'";
			# run the select statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# if select statement is not FALSE then check if email already exists
			if($QueryResult !== FALSE){
				# create array containing the query result
				$Row = mysql_fetch_row($QueryResult);
				# if array contains a number greater than zero then email is already registered
				if($Row[0] > 0){
					echo "<p>The email address entered (" . 
						htmlentities($email) . ") is already " .
						"registered.</p>\n";
					++$errors;
				}
			}
		}#-----------------------------------------------------------------
		
		# Table Selection and Username Check ---------------------------------
		$TableName = "users";
		# if there are no errors then select the number of fields in the table
		if($errors == 0){
			$SQLstring = "SELECT COUNT(*) FROM $TableName WHERE " .
				"username = '" . $_POST['username'] . "'";
			# run the select statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# if select statement is not FALSE then check if username already exists
			if($QueryResult !== FALSE){
				# create array containing the query result
				$Row = mysql_fetch_row($QueryResult);
				# if array contains a number greater than zero then username is already registered
				if($Row[0] > 0){
					echo "<p>The username entered (" . htmlentities($email) . ") is already " .
						"registered.</p>\n";
					++$errors;
				}
			}
		}#-----------------------------------------------------------------
		
		# if there are errors then tell user to go back
		if($errors > 0){
			echo "<p>Please use your browser's BACK button to return to " .
				"the form and fix the errors indicated.</p>\n";
		}
		
		# Register New User -----------------------------------------------
		# if there are no errors then insert user information into table
		if($errors == 0){
			$first = stripslashes($_POST['first_name']);
			$last = stripslashes($_POST['last_name']);
			$username = stripslashes($_POST['username']);
			$SQLstring = "INSERT INTO $TableName (first_name, " .
				"last_name, username, email, password_md5) VALUES" .
				"('$first', '$last', '$username', '$email', '" .
					md5($password) . "')";
			# run the insert statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# if insert statement fails to insert information then print error
			if($QueryResult === FALSE){
				echo "<p>Unable to save your registration information.</p>\n";
				++$errors;
			}else{ # if insert statement is succussful then insert profile ID
				$_SESSION['profile_ID'] = mysql_insert_id($DBConnect);
				
				# insert profile id into the finance_info table
				$SQLstring = "INSERT INTO finance_info (profile_ID) VALUES ('" . $_SESSION['profile_ID'] . "')";
				# run insert statement
				$QueryResult = @mysql_query($SQLstring, $DBConnect);
				# print error if insert statement fails
				if($QueryResult === FALSE){
					echo "Could not insert profile ID into database.";
					++$errors;
				}else{
					# insert profile id into the expenses table
					$SQLstring = "INSERT INTO expenses (profile_ID) VALUES ('" . $_SESSION['profile_ID'] . "')";
					# run insert statement
					$QueryResult = @mysql_query($SQLstring, $DBConnect);
					# print error if insert statement fails
					if($QueryResult === FALSE){
						echo "Could not insert profile ID into database.";
						++$errors;
					}
				}
			}
			# close the connection
			mysql_close($DBConnect);
		}#-----------------------------------------------------------------
		
		# if there are no errors print print user's name and ID
		if($errors == 0){
			$UserName = $first . " " . $last;
			echo "<p>Thank you, $UserName. ";
			echo "Your new profile ID is <strong>" . $_SESSION['profile_ID'] .
				"</strong>.</p>\n";
		}
			
		# create link to return to login page
		if($errors == 0){
			echo "<p>Please return to Login page to login to your account</p>";
		}
	?>
	<br /><br />
	<br /><br />
	<br /><br />
</div>