<?php
	require_once "connection.php";
	$error = "";
	session_start();
	
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
	* CHECKING "$_POST['signUp']" ENSURES THAT PAGE HAS BEEN ACCESSED BY CLICKING ON THE SUBMIT BUTTON IN *FORM.
	* "Team Name and Language" STORED IN "Teams" TABLE.
	* INFO. ABOUT MEMBERS STORED IN "Members" TABLE.
	* "Members" HAS FOREIGN KEY "TeamNo" FROM "Teams" TABLE.
	*/
	if(isset($_POST['signUp'] ) )   
	{
		$teamName = ( isset($_POST['teamName']) ) ? trim($_POST['teamName']) : '';
		$language =  ( isset($_POST['language']) ) ? trim($_POST['language']) : '';
		$password = ( isset($_POST['password']) ) ? md5( trim($_POST['password'] ) ) : '';
		$mem1_name  = ( isset($_POST['mem1_name']) ) ? trim($_POST['mem1_name']) : '';
		$mem1_id = ( isset($_POST['mem1_id']) ) ? trim($_POST['mem1_id']) : '';
		$mem1_branch = ( isset($_POST['mem1_branch']) ) ? trim($_POST['mem1_branch']) : '';
		$mem1_mail = ( isset($_POST['mem1_mail']) ) ? trim($_POST['mem1_mail']) : '';

		$mem2_name  = ( isset($_POST['mem2_name']) ) ? trim($_POST['mem2_name']) : '';
		$mem2_id = ( isset($_POST['mem2_id']) ) ? trim($_POST['mem2_id']) : '';
		$mem2_branch = ( isset($_POST['mem2_branch']) ) ? trim($_POST['mem2_branch']) : '';
		$mem2_mail = ( isset($_POST['mem2_mail']) ) ? trim($_POST['mem2_mail']) : '';


		if(strlen($teamName)  && strlen($password) && strlen($mem1_name)&& strlen($mem1_id)&& strlen($mem1_branch)&& strlen($mem1_mail)&& strlen($mem2_name)&& strlen($mem2_mail)&& strlen($mem2_id)&& strlen($mem2_branch) )  
		{
			$team_query = "INSERT INTO `Teams` (`name`, `language`, `password`) VALUES ('$teamName', '$language', '$password')";
			
			$team_result = $conn->query($team_query);
			if(!$team_result)
				$error .= "Error registering your team. Please try again.".$conn->error;
			
			else  
			{
				$team_no = $conn->insert_id; //RETRIEVES LAST INSERTED AUTO-INCREMENT ID.
				
				$member_query = "INSERT INTO `Members` (`team_no`,`name1`, `id1`, `branch1`, `mail1`,`name2`, `id2`, `branch2`, `mail2`) VALUES ('$team_no','$mem1_name', '$mem1_id', '$mem1_branch', '$mem1_mail', '$mem2_name', '$mem2_id', '$mem2_branch', '$mem2_mail')";
				$member_result = $conn->query($member_query);
				
				if(!$member_result)
					$error .= "Error registering team members. Please try again.".$conn->error;
				
				else  {
					$_SESSION['teamNo'] = $team_no;
					$_SESSION['teamName'] = $teamName;
					$_SESSION['language'] = $language;
					header('Location:index.php');
					//echo "reached successfully";
				}
			}
			

		}
		
	}


			
?>
<?php
require_once "common/header.php" ;
?>
<?php
	/*
	*VIEW CONTAINS CODE OF REGISTRATION PAGE.
	*/
include "views/register.php";