<?php
	require_once "connection.php";

	session_start();

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


	$quesNo = urldecode( $_GET['k'] );
	$quesNo =  $quesNo - 100;
	
	/*
	 * Fetch question corresponding to "$ques_no".
	 * IF invalid "$ques_no" , i.e., question doesn't exist in db, display error
    */

	$mcq_query = "SELECT * FROM `mcqs` WHERE `quesNo` = '$quesNo'";
	$mcq_result = $conn->query($mcq_query);
	if(!$mcq_result)
		$message .= "Question couldn't be fetched.";
	else  {
		$data = mysqli_fetch_assoc($mcq_result);
		if(!$data)
			die("not fetched" . mysqli_error($conn) );
		$quesContent = $data['question'];
		$option_query = "SELECT * FROM `options` WHERE `quesNo` = '$quesNo'";
		$option_result = $conn->query($option_query);
		if(!$option_result)  {
			$message .= "Options can't be fetched" ;
			die( $message);
		}
		else  {
			$options = mysqli_fetch_array($option_result);
			if(!$options)
				die("not fetched");
			$option1 = $options['option1'];
			$option2 = $options['option2'];
			$option3 = $options['option3'];
			$option4 = $options['option4'];
		}
	}
	


	require_once "common/headerLogin.php";
		
?>

<div class="page-wrap">
	<div class="row">
			<!-- /*
				  * DISPLAYS TIME LEFT. (static as of now;will be made dynamic later on).
				  */ -->
		<div class="col-md-12 col-sm-12 section-1-mcq time-left">
			<div class="clock_div">
				<div class="clock clock-mcq">
					<h4>Time left : 30:25:00</h4>
				</div>
			</div>	
		</div>	
	</div>

	<div class="row">
		<div class="col-md-8 mcq-disp-wrap">
			<div class="mcq-disp">
				<?= "<pre>" ?>
				<h3>Question No. <?= $quesNo ?></h3>	
				<?= " <h4 style='font-family:Times New Roman'> $quesContent </h4> " ?>
					<br>
				<?= "</pre>" ?>
				<?php
					for($i = 0;$i< 4;$i++)  {
						echo "<h4>". $options[2+ $i] . "</h4>";
					}
				?>
					
				



			</div>	
		</div>	
	</div>	
</div>	
