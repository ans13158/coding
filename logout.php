<?php
	
	/*
	*
	*FOLLOWING CODE RESTRICTS ACCESS TO PAGE :
	*PAGE CAN BE ACCESSED ONLY WHEN USER IS LOGGED-IN.
	*"$_SESSION['teamNo']" AND "$_SESSION['teamName']" ENSURE THIS.
	*IF SESSION EXISTS THEN CHECK IF CREDENTIALS ARE VALID.
	*IF USER NOT LOGGED IN, THEN REDIRECT TO INDEX PAGE.
	* 
	*/
require_once "connection.php";
	session_start();
	$error = "";
	if(isset($_SESSION['teamNo']) && isset($_SESSION['teamName'] ) )  {
		$teamNo = $_SESSION['teamNo'];
		$name = $_SESSION['teamName'];
		$query = "SELECT * FROM `Teams` WHERE `TeamNo` = '$teamNo' AND `name` = '$name'";
		$result = $conn->query($query);
		if($result)  {
			$row = $result->num_rows;
			if(!$row)
				header('Location:index.php');
			
		}
	}

	/*
	*LOGGIN OUT
	*/
	
	session_destroy();
	
	/*
	*REDIRECT TO INDEX PAGE AFTER GETTING LOGGED-OUT.
	*/
	header('Location:index.php');

?>