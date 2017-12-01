<?php
	require_once "connection.php";
	ob_start();
	//session_start();
	$message = ""; //FOR SHOWING ERRORS GENERATED (if any) DURING RETRIEVAL.
	/*
	*
	*FOLLOWING CODE RESTRICTS ACCESS TO PAGE :
	*PAGE CAN BE ACCESSED ONLY WHEN USER IS NOT LOGGED-IN.
	*"$_SESSION['teamNo']" AND "$_SESSION['teamName']" ENSURE THIS.
	*IF SESSION EXISTS THEN CHECK IF CREDENTIALS ARE VALID.
	*IF USER ALREADY LOGGED IN, THEN REDIRECT TO INDEX PAGE.
	* 
	*/
	// if(isset($_SESSION['teamNo']) && isset($_SESSION['teamName'] ) )  {
	// 	$teamNo = $_SESSION['teamNo'];
	// 	$name = $_SESSION['teamName'];
	// 	$query = "SELECT * FROM `Teams` WHERE `TeamNo` = '$teamNo' AND `name` = '$name'";
	// 	$result = $conn->query($query);
	// 	if($result)  {
	// 		$row = $result->num_rows;
	// 		if($row)
	// 			die("no");
	// 			//header('Location:index.php');
	// 	}
	// }

	/*
	 * Collect answers of questions from DB, store in cookie.
	 * Check above cookie against JS cookie containing responses. 
	 */
	$answerQuery = "SELECT * FROM `answers`";
	$answerResult = $conn->query($answerQuery);
	if(!$answerResult)
		die("Error checking answers. Please contact the organizers");
	$answerArray = mysqli_fetch_assoc($answerResult);
	if(!$answerArray)  
		die("Error Fetching answers from db.");
	$arr = [];
	$i = 0;
	foreach ($answerResult as $answers ) {
		$arr[$i] = $answers['answer'];
		$i++;
	}
	$cookie_value  = [];
	$cookie_name = "answers";
	$cookie_value = json_encode($arr);
	if(setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/") ) // 86400 = 1 day
		header('Location:checkanswers.php');
		
	else
		die( "failed"); 
	 ob_end_flush();

	$error = isset($_GET['error'] ) ? $_GET['error']  : null ;
	if($error)
		die($error);

	
