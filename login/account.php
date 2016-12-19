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
				<div id='menu'>
					<ul>
						<li><a href="account.php?page=home.html">Home</a></li>
						<li><a href="account.php?page=settings.html">Settings</a></li>
						<li><a href='../index.php'>Log out</a></li>
					</ul>
				</div>
							
				<?php
					$page = "home.html"; # start on home
					# change page if a link is clicked
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					include("$page");
				?>
			</div>
			<div id="bottom">
				Web Design by jedignork &nbsp;&bull;&nbsp;
				Rounded_2 &nbsp;&bull;&nbsp;
				From &copy; Open Source Web Design 2016
			</div>
		</div>
	</body>
</html>