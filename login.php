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
			if($row)
				header('Location:index.php');
			
		}
	}
	

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
				header('Location:index.php');
				
			}
			else  {
				$error .= "Wrong Credentials or You are not registered";
			}
		}

	}

?>
<?php
	require "common/header.php";
?>

<?php
	include 'views/login.php';
?>