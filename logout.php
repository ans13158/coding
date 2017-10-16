<?php

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

	session_destroy();
	header('Location:index.php');

?>