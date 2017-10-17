<?php

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
	include_once "common/header.php" ; //used when user not logged in.
else
	include_once "common/headerLogin.php"; //used when user logged in.
?>

<!-- 
	/*
	 * VIEW DISPLAYS LIST OF QUESTION NOs. AND INSTRUCTIONS. 
	 */
-->

<?php
/*
 * Counting no. of questions in db. (no_of_ques).
 * If no_of_ques > 20, select randomly 20 questions
 * Else show 20 questions in random order.
 * In this page however, we list only the question nos. 
 */
	
$query = "SELECT count(*) FROM `mcqs`";
$result = $conn->query($query);
if(!$result)
	die("Error retrieving questions" . $conn->error);
$no_of_ques = $result->fetch_array()[0];
if(!$no_of_ques)
	$message = "No questions stored in database. Please contact the organizers.";
 	
?>

<?php
	include "views/clock_inst.php";
?>