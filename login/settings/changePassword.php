<div id="stuff">
	<?php
		$errors = 0;
		
		# Database Connection --------------------------------------------
			include("../DBConnect.php");
		#-----------------------------------------------------------------
		
		# Old Password Validation ----------------------------------------
		$TableName = "users";
		# if there are no errors then select the user password from the table
		if($errors == 0){
			$SQLstring = "SELECT password_md5 FROM $TableName WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the select statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect); 
			# if select statement fails to select something then print error
			if($QueryResult === FALSE){
				echo "Failed to find password.";
				++$errors;
			}else{ # if select statement returns a password then check if old password equals the users password
				# create array containing the query result
				$Row = mysql_fetch_assoc($QueryResult);
				$oldPassword = md5(stripslashes($_POST['old']));
				if($oldPassword <> $Row['password_md5']){
					echo "The old password you entered was incorrect.<br />";
					++$errors;
				}
			}
		}#-----------------------------------------------------------------
		
		# New Password Validation -----------------------------------------
		# if password textbox is empty then print error
		if(empty($_POST['password'])){
			++$errors;
			echo "You need to enter a password.<br />";
			$password = "";
		}else{ # if password textbox is not empty set equal to $password
			$password = stripslashes($_POST['password']);
		}
		# if confirm password textbox is empty then print error
		if(empty($_POST['password2'])){
			++$errors;
			echo "You need to enter a confirmation password<br />";
			$password2 = "";
		}else{ # if confirm password textbox is not empty set equal to $password2
			$password2 = stripslashes($_POST['password2']);
		}
		# if password and confirm password are not empty check if valid
		if(!empty($password) && !empty($password2)){
			# if password is less than 6 characters long then print error
			if(strlen($password) < 6){
				++$errors;
				echo "The password is too short.<br />";
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
		
		# Update Password -------------------------------------------------
		$TableName = "users";
		# if there are no errors then update the password
		if($errors == 0){
			$password = md5(stripslashes($_POST['password']));
			$SQLstring = "UPDATE $TableName SET password_md5='$password' WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the update statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# if update statement fails then print error
			if($QueryResult === FALSE){
				echo "Failed to change password.<br />";
				++$errors;
			}
		}#------------------------------------------------------------------
		
		# if there are no errors then print update successful
		if($errors == 0){
			echo "Your password has been successfully updated.<br />";
			echo "<br /><br />
				<a href='account.php?page=settings.html' class='budget'>Back to Settings</a>
				<br />";
		}else{
			echo "<br /><br />
				<a href='account.php?page=settings/password.html' class='budget'>Back</a>
				<br />";
		}
	?>
	<br /><br />
</div>