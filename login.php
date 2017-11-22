<?php
	require_once "connection.php";

	session_start();

	$error = ""; //FOR SHOWING ERRORS GENERATED (if any) DURING SUBMISSION.

	/*
	*
	*FOLLOWING CODE RESTRICTS ACCESS TO PAGE :
	*PAGE CAN BE ACCESSED ONLY WHEN USER IS NOT LOGGED-IN.
	*"$_SESSION['teamNo']" AND "$_SESSION['teamName']" ENSURE THIS.
	*IF SESSION EXISTS THEN CHECK IF CREDENTIALS ARE VALID.
	*IF USER ALREADY LOGGED IN, THEN REDIRECT TO INDEX PAGE.
	* 
	*/
	if(isset($_SESSION['teamNo']) && isset($_SESSION['teamName'] ) )  {
		$teamNo = $_SESSION['teamNo'];
		$name = $_SESSION['teamName'];
		$query = "SELECT * FROM `Teams` WHERE `TeamNo` = '$teamNo' AND `name` = '$name'";
		$result = $conn->query($query);
		if($result)  {
			$row = $result->num_rows;
			if($row)
				header('Location:index.php');
			
		}
	}
	
	/*
	*
	*CODE FOR LOGIN.
	*PARAMETERS CHECKED : "TeamName and Password".
	*IF LOGIN SUCCESSFUL, CREATE AS SESSION AND PASS "Team Number, Team Name & Language(selected during *registration)". Redirect to "mcqPage.php"
	*
	*/
	if(isset($_POST['signUp'] ) )  {
		$name = isset($_POST['teamName']) ? trim($_POST['teamName']) : "" ;
		$password = isset($_POST['password']) ? md5( trim( $_POST['password'] ) ) : "" ;

		$query = "SELECT * FROM `Teams` WHERE `name` = '$name' AND `password` = '$password'";
		$result = $conn->query($query);
		if(!$result)  {
			$error .= "Wrong credentials. Try Again.";
		}	
		else  {
			$rows = $result->num_rows;
			if($rows)  {
				$data = mysqli_fetch_assoc($result);
				$_SESSION['teamNo'] = $data['TeamNo'];
				$_SESSION['teamName'] = $data['name'];
				$_SESSION['language'] = $data['language'];
				header('Location:mcqPage.php');
				
			}
			else  {
				$error .= "Wrong Credentials or You are not registered";
			}
		}

	}

?>

<?php
	/*
	*REQUIRE COMMON HEADER FOR EACH PAGE.
	*/
	require "views/common/header.php";
?>

<?php
				/*
				*
				*FOLLOWING VIEWS CONTAINS THE FORM FOR LOGIN
				*/
	include 'views/login.php';
?>