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
		<!-- Script to disable next or previous buttons according to current ques no. -->
<script>
	/*
	 * "answers[]" is used to retrieve value of cookie storing responses of previous questions.
	 * "answers[]" also stores response of current question later in the code.
	 * "responses" is the value and name of cookie storing responses of answers.
	*/
	var answers = [];

	/*
     * Function to retrieve VALUE of cookie whose name is given as parameter.
	*/
	function getCookie(c_name)  {
	     var i,x,y,ARRcookies=document.cookie.split(";");
	     for (i=0;i<ARRcookies.length;i++)  {
		      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		      x=x.replace(/^\s+|\s+$/g,"");
		      if (x==c_name)  {
		       	return unescape(y);
		      }
	     }
    }

    /*
	 * Retrieve value of RESPONSES cookie, if exists.
    */
    var cookie_val = getCookie('responses');
    if(cookie_val)
		if(cookie_val.length)  {
			answers = JSON.parse(cookie_val);
			//alert(answers)
		}

	/*
	 * Fetch value of GET parameter in URL.
	*/	
	var urlParam = function(name)  {
		var results = new RegExp('[/?&]' + name + '=([^&#]*)').exec(window.location.href);
		if(results == null)  
			return null;
		else 
			return decodeURI(results[1]) || 0;
	}

	var question = parseInt(urlParam('k'));

</script>

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

	<!-- DIV FOR DISPLAYING QUESTIONS AND OPTIONS -->
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
									echo "<pre> <label> <input type='checkbox' class='checkBox' value='$optNo' onclick='check($optNo)' id='$optNo' > ". $options[2+ $i] . "</label> </pre>";
						}
							?>

							</div>
						<div class="buttons">
							<div class=" col-md-3 btn_nav">
								<button id="previous_btn" class="btn btn-primary previous_btn" onclick="prevQues();"> Previous</button>
							 </div>
							 <div class="col-md-3 btn_nav">
								<button id="next_btn" class="btn btn-primary next_btn" onclick="nextQues();"> Next</button>
							 </div>
							 <input type="hidden" id="max_question" name="max_question" value="<?= $no_of_ques ?> ">
						</div>
				</div>	
			</div>		

			</div>
		</div>

	<!-- DIV FOR DISPLAYING QUESTIONS AND OPTIONS -->


			<!-- /*
				  * DISPLAYS TIME LEFT. (static as of now;will be made dynamic later on).
				  */ -->
		<div class="col-md-4 col-sm-4  clock_inst2">
			<div class="clock_div">
				<div class="clock" id="clock">
						
				</div>
			</div>	

			<!-- DISPLAYS LIST OF QUESTIONS WITH COLOR CODES DEFINED ABOVE. -->

			<div class="quesList_div">
				<div class="quesList">
					<?php for($i = 1; $i<= $no_of_ques; $i++) { ?>
						<div class="col-md-3 quesNo_disp">
							<div class="quesNo unattempted">
								<a class="quesNo_link" href="disp_mcq.php?k=<?= urlencode($i + 100); ?>"> <?= $i ?></a>
							</div>	
						</div>	
					<?php  } ?>	

				</div>
			</div> 
		</div>	
	</div>
</div>
</div>	

<script>
	function check(optNo)  {
	 	/* Section enables checking only 1 checkbox at a time. */
		 	for(var i = 1; i <=4; i++)
		 		document.getElementById(i).checked = false;
		 	var id = 'checkBox' + optNo;
		 	document.getElementById(optNo).checked = true;
	 	/* Section enables checking only 1 checkbox at a time. */


	 	/*Fetch value of selected checkbox and store in "answers[]" array */
			var checked = [];
			var elements = document.getElementsByClassName('checkBox');
			for(var i =0; elements[i]; i++)  {
				if(elements[i].checked)
					checked[i] = elements[i].value;
				else
					checked[i] = 0;	 
			}
			for(var i = 0; i<4; i++)  {
				if(checked[i] != '0' || checked[i] != 0)  {
					
					//index.toString();
					answers[question-101]  = parseInt(checked[i]);
				}
			}	
	 	/*Fetch value of selected checkbox and store in "answers[]" array */

	 	responses = JSON.stringify(answers);
	 	document.cookie = 'responses=' + responses;
}
	
	/* 
	 * "no_of_ques" stores no. of questions  in db.	
	 * "questions" stores the current question no.
	 * "prevQues()" & "nextQues()" give functionalities to PREVIOUS & NEXT buttons.
	 */

	var no_of_ques = document.getElementById('max_question').value ;
	no_of_ques = parseInt(no_of_ques);
	no_of_ques += 100;

	var previous = document.getElementById('previous_btn');
	var next = document.getElementById('next_btn');
	
	/*
	* Disable NEXT or PREVIOUS buttons a/c to current ques no. :
	* If current ques. is first question in list, disable PREVIOUS.
	* If ques. last in list, disable NEXT.
	*/
	if(question == no_of_ques )  {
		next.disabled = true;
	}
	if(question == 101)
		previous.disabled = true;

	function prevQues()  {
		window.location.href = "disp_mcq.php?k=" + (question-1);
	}
	function nextQues()  {
		window.location.href = "disp_mcq.php?k=" + (question+1);
	}

	

			/*
			 * Section makes TIME LEFT section dynamic.
			*/	
  function checkTime(i) {
	  if (i < 10) {
	    i = "0" + i;
	  }
	  return i;
  }

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  // add a zero in front of numbers<10
  m = checkTime(m);
  s = checkTime(s);
  n = h + " : " + m +  " : " + s ;
  document.getElementById('clock').innerHTML = "<h4> Time Left  " + n + "</h4>";
  t = setTimeout(function() {
    startTime()
  }, 1000);
}
startTime();


</script>