<div id="stuff">
	<?php
		$errors = 0;
		$email = "";
		
		# Email Validation ----------------------------------------------
		# if email textbox is empty then print error
		if(empty($_POST['email'])){
			++$errors;
			echo "You need to enter an e-mail address.<br />";
		}else{ # if email textbox is not empty set equal to $email
			$email = stripslashes($_POST['email']);
			
			# if regular expression and email don't match then print error
			if(preg_match("/^[\w-]+([\.[\w-]+)*@[\w-]+(\.[\w-]+)*" .
					"(\.[a-zA-Z]{2,})$/i", $email) == 0){
				++$errors;
				echo "You need to enter a valid e-mail<br />" .
					"address.</p>\n";
				$email = "";
			}
		}
		
		# if confirm email textbox is empty then print error
		if(empty($_POST['confirm'])){
			++$errors;
			echo "You need to enter a confirmation E-mail<br />";
			$confirm = "";
		}else{ # if confirm email textbox is not empty set equal to $confirm
			$confirm = stripslashes($_POST['confirm']);
		}
		
		# if email and confirm email are not empty check if valid
		if(!empty($email) && !empty($confirm)){
			# if emails don't match then print error
			if($email <> $confirm){
				++$errors;
				echo "The emails do not match.<br />";
				$email = "";
				$confirm = "";
			}
		}#-----------------------------------------------------------------
		
		# Database Connection ---------------------------------------------
		# if there are no errors then connect to the database server
		if($errors == 0){
			include("../DBConnect.php");
		}#-----------------------------------------------------------------
		
		# Table Selection and Update Email --------------------------------
		$TableName = "users";
		# if there are no errors then select the number of fields in the table
		if($errors == 0){
			$SQLstring = "UPDATE $TableName SET email='$email' WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the update statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# if update statement fails then print error
			if($QueryResult === FALSE){
				echo "Could not update email address<br />";
				++$errors;
			}
		}# ----------------------------------------------------------------
		
		# if there are no errors then print update successful
		if($errors == 0){
			echo "Your email address has been successfully updated.<br />";
			echo "<br /><br />
				<a href='account.php?page=settings.html' class='budget'>Back to Settings</a>
				<br />";
		}else{
			echo "<br /><br />
				<a href='account.php?page=settings/update.html' class='budget'>Back</a>
				<br />";
		}
	?>
</div>