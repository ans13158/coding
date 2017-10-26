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
	$no_of_ques = "";
	$query = "SELECT count(*) FROM `mcqs`";
	$result = $conn->query($query);
	if(!$result)
		die("Error retrieving questions" . $conn->error);
	$no_of_ques = $result->fetch_array()[0];
	if(!$no_of_ques)
		$message = "No questions stored in database. Please contact the organizers.";
 	

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
		<!-- Displays color codes for attempted, unattempted, marked for review questions -->
		<div class="">
			<div class="col-md-12 color-codes">
					<div class="col-md-4">
						<div class="color-1 coding" style="display: inline-block;">
						</div>	
						<div style="display: inline-block;"><h4 >Un-attempted</h4></div>
					</div>
					
					<div class="col-md-4">
						<div class="color-2 coding" style="display: inline-block;">
						</div>	
						<div style="display: inline-block;"><h4 >Attempted</h4></div>
					</div>

					<div class="col-md-4">
						<div class="color-3 coding" style="display: inline-block;">
						</div>	
						<div style="display: inline-block;"><h4 >Marked for Review</h4></div>
					</div>	
			</div>	
		</div>	
	</div>	
		<div class="row">
			<div class="col-md-8 col-sm-8 section-1 ques-summary">
					<!-- <div class="mcq-disp"> -->
				 <div class="mcq-ques"> 
					<?= "<pre>" ?>
					<h3>Question No. <?= $quesNo ?></h3>	
					<?= " <h4 style='font-family:Times New Roman'> $quesContent </h4> " ?>
						<br>
					<?= "</pre>" ?>
				</div>	
				<?php
					for($i = 0;$i< 4;$i++)  {
						?>
						<div class="mcq-options">
							<?php
								$optNo = $i+1;
								echo "<pre><h4> $optNo).". $options[2+ $i] . "</h4></pre>";
					}
						?>

					</div>
					<?php
				?>	
			</div>	
			</div>			
		</div>
	</div>

			<!-- /*
				  * DISPLAYS TIME LEFT. (static as of now;will be made dynamic later on).
				  */ -->
		<div class="col-md-4 col-sm-4 section-2 clock_inst2">
			<div class="clock_div">
				<div class="clock">
					<h4>Time left : 30:25:00</h4>
				</div>
			</div>	

			<!-- /*
				  * DISPLAYS Question List.
				  */ -->

			<div class="quesList_div">
				<div class="quesList">
					<?php for($i = 1; $i<= $no_of_ques; $i++) { ?>
						<div class="col-md-3 quesNo_disp">
							<div class="quesNo unattempted">
								<a href="disp_mcq.php?k=<?= urlencode($i + 100); ?>"> <?= $i ?></a>
							</div>	
						</div>	
					<?php  } ?>	

				</div>
			</div>
		</div>	
	</div>
</div>
</div>	
