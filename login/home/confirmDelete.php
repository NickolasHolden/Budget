<div id="stuff">
	<?php
		$errors = 0;
	
		# Database Connection ---------------------------------------------------------
		include("../DBConnect.php");
		#------------------------------------------------------------------------------
		
		# Table Selection and financial info input ------------------------------------
		$TableName = "finance_info";
		# if there are no errors then clear financial info
		if($errors == 0){
			$SQLstring = "UPDATE $TableName SET income='0', amount_saved='0', goal='0', " .
						"months_to_goal='0' WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the update statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# print error if update statement fails
			if($QueryResult === FALSE){
				echo "Could not delete financial info from database.";
				++$errors;
			}
		}
		
		$TableName2 = "expenses";
		# if there are no errors then clear the expenses table
		if($errors == 0){
			$SQLstring = "UPDATE $TableName2 SET home='0', rent='0', car='0', fuel='0', " .
						"phone='0', utilities='0', insurance='0', entertainment='0', " .
						"giving='0', other='0' WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the update statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# print error if update statement fails
			if($QueryResult === FALSE){
				echo "Could not delete financial info database.";
				++$errors;
			}
		}#-----------------------------------------------------------------------------
		
		if($errors == 0){
			echo "Your budget has been successfully deleted.";
		}
	?>
	
	<br /><br />
	<a href="account.php?page=home.html" class="budget">Home</a>
	<br />
</div>