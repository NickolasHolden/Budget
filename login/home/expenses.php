<div id="stuff">
	<br />
	<b>Monthly Expenses:</b>
	<br />
	(Anything entered into the fields that is not a number will be considered a zero.)
	<br />
	<br />
	<form method="post" action="account.php?page=home/view.php" >
		<?php
			# get text form previous form
			$income = $_POST['income'];
			$saved = $_POST['saved'];
			$goal = $_POST['goal'];
			$time = $_POST['time'];
			
			$errors = 0;
			# Database Connection -----------------------------------------------
			include("../DBConnect.php");
			#--------------------------------------------------------------------
			
			# Table and financial info Selection --------------------------------
			$TableName = "expenses";
			# if there are no errors then select info from finance_info table
			if($errors == 0){
				$SQLstring = "SELECT * FROM $TableName WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
				# run select statement
				$QueryResult = @mysql_query($SQLstring, $DBConnect);
				# print error if select statement fails
				if(mysql_num_rows($QueryResult) == 0){
					echo "failed to get expenses.";
					++$errors;
				}else{
					# declare variables containing table fields
					$Row = mysql_fetch_assoc($QueryResult);
					$home = $Row['home'];
					$rent = $Row['rent'];
					$car = $Row['car'];
					$fuel = $Row['fuel'];
					$phone = $Row['phone'];
					$utilities = $Row['utilities'];
					$insurance = $Row['insurance'];
					$entertainment = $Row['entertainment'];
					$giving = $Row['giving'];
					$other = $Row['other'];
				}
			}
			
			# create text boxes and fill them with expenses
			echo "<input type='hidden' name='income' value='$income' />" .
				"<input type='hidden' name='saved' value='$saved' />" .
				"<input type='hidden' name='goal' value='$goal' />" .
				"<input type='hidden' name='time' value='$time' />" .
				"<input type='hidden' name='page' value='home/view.php' />" .
				"<label for='home'>Home: <span id='span' style='margin-left:59px;'>$</span></label>" .
				"<input type='text' name='home' value='$home' /><br /><br />" .
				"<label for='rent'>Rent: <span id='span' style='margin-left:66px;'>$</span></label>" .
				"<input type='text' name='rent' value='$rent' /><br /><br />" .
				"<label for='car'>Car: <span id='span' style='margin-left:71px;'>$</span></label>" .
				"<input type='text' name='car' value='$car' /><br /><br />" .
				"<label for='fuel'>Fuel: <span id='span' style='margin-left:69px;'>$</span></label>" .
				"<input type='text' name='fuel' value='$fuel' /><br /><br />" .
				"<label for='phone'>Phone: <span id='span' style='margin-left:57px;'>$</span></label>" .
				"<input type='text' name='phone' value='$phone' /><br /><br />" .
				"<label for='utilities'>Utilities: <span id='span' style='margin-left:51px;'>$</span></label>" .
				"<input type='text' name='utilities' value='$utilities' /><br /><br />" .
				"<label for='insurance'>Insurance: <span id='span' style='margin-left:35px;'>$</span></label>" .
				"<input type='text' name='insurance' value='$insurance' /><br /><br />" .
				"<label for='entertainment'>Entertainment: <span id='span' style='margin-left:13px;'>$</span></label>" .
				"<input type='text' name='entertainment' value='$entertainment' /><br /><br />" .
				"<label for='giving'>Giving/Charity: <span id='span' style='margin-left:10px;'>$</span></label>" .
				"<input type='text' name='giving' value='$giving' /><br /><br />" .
				"<label for='other'>Other: <span id='span' style='margin-left:61px;'>$</span></label>" .
				"<input type='text' name='other' value='$other' /><br /><br />";
		?>
		
		<input type="submit" name="submit" value="Submit" />
		<input type="reset" name="reset" value="Reset" />
	</form>
	<form method="post" action="account.php?page=home/create.php" style="margin-top: -25px; margin-left: 200px;">
		<input type="hidden" name="page" value="home/create.php" />
		<input type="submit" name="cancel" value="Back" />
	</form>
	<br />
</div>