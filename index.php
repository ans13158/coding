<?php

/*
 *Landing page of the site
 */


 /*
*
* FOLLOWING CODE CHANGES HEADER OF PAGE IF USER IS LOGGED IN (HEADER SHOWS "LOGOUT" INSTEAD OF "LOGIN").
* CHECK IF USER ALREADY LOGGED IN. IF YES : USE "headerLogin.php" header ELSE USE "header.php" header. (the *regular one).
* IF $login = 0, THEN NOT LOGGED IN,  ELSE LOGGED IN.
*
*/
session_start();
require_once "connection.php";
$login = 0;
$message = "";
if(isset($_SESSION['teamNo']) && isset($_SESSION['teamName'] ) )  {
		$teamNo = $_SESSION['teamNo'];
		$name = $_SESSION['teamName'];
		$query = "SELECT * FROM `Teams` WHERE `TeamNo` = '$teamNo' AND `name` = '$name'";
		$result = $conn->query($query);
		if($result)  {
			$row = $result->num_rows;
			if($row)
				$login = 1;
			else 
				$login = 0;
			
		}
	}

if(!$login)	
	include_once "views/common/header.php" ; //used when user not logged in.
else
	include_once "views/common/headerLogin.php"; //used when user logged in.
?>

<div class="index-desc">
	<h1>Blah Blah Blah</h1>
	<h4>Welcome to BlahBlahBlahBlah. We do Blah Blah Blah Blah Blah Blah</h4>
	<h4>Welcome to BlahBlahBlahBlah. We do Blah Blah Blah Blah Blah Blah</h4>
	<h4>Welcome to BlahBlahBlahBlah. We do Blah Blah Blah Blah Blah Blah</h4>
	<h4>Welcome to BlahBlahBlahBlah. We do Blah Blah Blah Blah Blah Blah</h4>
</div>

		<!-- Put this inside a modal -->
<div class="login-div">
	<h3><a href="login.php">Click here to login</a></h3>
</div>	
		<!-- Put this inside a modal -->


<div class="modal-wrap">
	<div class="modal-div">
		
	</div>
</div>