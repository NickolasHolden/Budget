<div id="stuff">
	<?php
		$errors = 0;
		$expenses = 0;
		
		# Database Connection ---------------------------------------------------------
		include("../DBConnect.php");
		#------------------------------------------------------------------------------
	
		# update the database if the create/edit budget forms were filled out
		if(isset($_POST['income']) && isset($_POST['home'])){ 
			# declare associative array containing all textbox entries
			$array = array("Income" => (double)($_POST['income']), 
					"Amount Saved" => (double)($_POST['saved']),
					"Goal" => (double)($_POST['goal']),
					"Months to Goal" => (int)($_POST['time']),
					"Home" => (double)($_POST['home']),
					"Rent" => (double)($_POST['rent']),
					"Car" => (double)($_POST['car']),
					"Fuel" => (double)($_POST['fuel']),
					"Phone" => (double)($_POST['phone']),
					"Utilities" => (double)($_POST['utilities']),
					"Insurance" => (double)($_POST['insurance']),
					"Entertainment" => (double)($_POST['entertainment']),
					"Giving" => (double)($_POST['giving']),
					"Other" => (double)($_POST['other']));
			
			# Entry Validation ------------------------------------------------------------
			$count = 0;
			# loop through array and add the value of each item to expenses if the entries are valid
			foreach($array as $key => $entry){
				# entries must be valid numbers greater than or equal to zero
				if($entry < 0){ 
					echo "$key must be a number greater than or equal to zero.<br /><br />";
					++$errors;
				}
				$count++;
			}#-----------------------------------------------------------------------------
			
			# Table Selection and financial info input ------------------------------------
			$TableName = "finance_info";
			# if there are no errors then update fincance_info table with financial info
			if($errors == 0){
				$SQLstring = "UPDATE $TableName SET income='" . $array['Income'] . "', amount_saved='" . 
							$array['Amount Saved'] . "', goal='" . $array['Goal'] . "', months_to_goal='" .
							$array['Months to Goal'] . "' WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
				# run the update statement
				$QueryResult = @mysql_query($SQLstring, $DBConnect);
				# print error if update statement fails
				if($QueryResult === FALSE){
					echo "Could not insert financial info into database.";
					++$errors;
				}
			}
			
			$TableName2 = "expenses";
			# if there are no errors then update the expenses table with expenses
			if($errors == 0){
				$SQLstring = "UPDATE $TableName2 SET home='" . $array['Home'] . "', rent='" . $array['Rent'] .
							"', car='" . $array['Car'] . "', fuel='" . $array['Fuel'] . "', phone='" .
							$array['Phone'] . "', utilities='" . $array['Utilities'] . "', insurance='" .
							$array['Insurance'] . "', entertainment='" . $array['Entertainment'] . 
							"', giving='" . $array['Giving'] . "', other='" . $array['Other'] . "' WHERE " .
							"profile_ID = '" . $_SESSION['profile_ID'] . "'";
				# run the update statement
				$QueryResult = @mysql_query($SQLstring, $DBConnect);
				# print error if update statement fails
				if($QueryResult === FALSE){
					echo "Could not update financial info database.";
					++$errors;
				}
			}#-----------------------------------------------------------------------------
		}
		
		# Displaying Budget -------------------------------------------------------
		$TableName = "expenses";
		# if there are no errors then add up expenses
		if($errors == 0){
			# select all the user's expenses from the expenses table
			$SQLstring = "SELECT * FROM $TableName WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the select statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# print error if select statement fails
			if($QueryResult == 0){
				echo "Cannot retrieve database information.";
				++$errors;
			}else{
				$Row = @mysql_fetch_assoc($QueryResult);
				# loop through array and add the value of each item to expenses
				foreach($Row as $key => $entry){
					# do not add profile_ID to expenses
					if($key != "profile_ID"){
						$expenses += $entry;
					}
				}
			}
		}
		
		$TableName2 = "finance_info";
		# if there are no errors then display budget
		if($errors == 0){
			# select all the user's financial info from the fincance_info table
			$SQLstring = "SELECT * FROM $TableName2 WHERE profile_ID = '" . $_SESSION['profile_ID'] . "'";
			# run the select statement
			$QueryResult = @mysql_query($SQLstring, $DBConnect);
			# print error if select statement fails
			if($QueryResult == 0){
				echo "Cannot retrieve database information.";
				++$errors;
			}else{
				$Row = @mysql_fetch_assoc($QueryResult);
				
				# loop through array and check if entries are greater than zero
				foreach($Row as $key => $entry){
					# if any one entry is greater than zero, then the budget has been created
					if($entry > 0){
						$budget = true;
					}
				}
				
				# find how long it will take to reach the goal
				$monthlyIncome = $Row['income'] / 12;
				$monthlyProfit = $monthlyIncome - $expenses;
				$goal = $Row["goal"] - $Row["amount_saved"];
				if($monthlyProfit > 0){
					$monthsToGoal = (int)($goal / $monthlyProfit);
					$setMonthsToGoal = $Row["months_to_goal"];
					$yearsToGoal = (int)($monthsToGoal / 12);
					$andMonths = (int)($monthsToGoal % 12);
				
					# find the amount of money needed to be saved in order to reach the goal if months is specified
					if($setMonthsToGoal > 0){
						$moneyToGoal = round(($goal / $setMonthsToGoal), 2);
						# monthly income needed to reach goal can't be greater than monthly income being received
						if($moneyToGoal >= $monthlyProfit){
							echo "You don't earn enough income to reach that goal within the specified time.";
						}else{
							$freeToSpend = round(($monthlyProfit - $moneyToGoal), 2);
							echo "You need to save $$moneyToGoal each month in order to reach your goal in time.<br /><br />";
							echo "You have $$freeToSpend to freely spend each month.<br /><br />";
						}
					# if monthly expenses is greater than monthly profit then no goal can be reached
					}else if($monthlyProfit <= 0){
						echo "You are losing money. You will never be able to reach your goal unless you " .
							"start earning more money.";
					}else{
						# dislay only the months if it will take less than a year to reach the goal
						if($yearsToGoal == 0){
							echo "It will take you $monthsToGoal month(s) to reach your goal if you save all " .
								"your money not being used on monthly expenses.";
						}else{
							echo "It will take you $yearsToGoal year(s) and $andMonths month(s) to reach your " .
								"goal if you save all your money not being used on monthly expenses.";
						}
					}
				}else{
					echo "You aren't making any profit. You will never be able to reach your goal unless " .
						"you start earning more money.";
				}
			}
		}#-----------------------------------------------------------------------------
	?>
	
	<br /><br />
	<a href="account.php?page=home.html" class="budget">Home</a>
	<br />
</div>