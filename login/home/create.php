<div id="stuff">
	<br />
	<b>Enter your financial information</b>
	<br />
	(Anything entered into the fields that is not a number will be considered a zero.)
	<br />
	<br />
	<form method="post" action="account.php?page=home/expenses.php">
		<?php 
			$errors = 0;
			# Database Connection -----------------------------------------------
			include("../DBConnect.php");
			#--------------------------------------------------------------------
			
			# Table and financial info Selection --------------------------------
			$TableName = "finance_info";
			# if there are no errors then select info from finance_info table
			if($errors == 0){
				$SQLstring = "SELECT * FROM $TableName WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
				# run select statement
				$QueryResult = @mysql_query($SQLstring, $DBConnect);
				# print error if select statement fails
				if(mysql_num_rows($QueryResult) == 0){
					echo "failed to get financial info.";
					++$errors;
				}else{
					# declare variables containing table fields
					$Row = mysql_fetch_assoc($QueryResult);
					$income = $Row['income'];
					$saved = $Row['amount_saved'];
					$goal = $Row['goal'];
					$time = $Row['months_to_goal'];
				}
			}
		
			# create text boxes and fill them with financial info
			echo "<input type='hidden' name='page' value='home/expenses.php' />" .
				"<label for='income'>Income (salary): <span id='span'>$</span></label>" .
				"<input type='text' name='income' value='$income' /><br /><br />" .
				"<label for='saved'>Amount Saved: <span id='span' style='margin-left:9px;'>$</span></label>" .
				"<input type='text' name='saved' value='$saved' /><br /><br />" .
				"<label for='goal'>Goal: <span id='span' style='margin-left:67px;'>$</span></label>" .
				"<input type='text' name='goal' value='$goal' /><br /><br />" .
				"<label for='time'>Months to Goal: <span id='span' style='margin-left:15px;'></span></label>" .
				"<input type='text' name='time' value='$time' /><br /><br />";
		?>
		
		<input type="submit" name="submit" value="Next" />
		<input type="reset" name="reset" value="Reset" />
	</form>
	<form method="post" action="account.php?page=home.php" style="margin-top: -25px; margin-left: 180px;">
		<input type="hidden" name="page" value="home.php" />
		<input type="submit" name="cancel" value="Cancel" />
	</form>
	<br />
</div>