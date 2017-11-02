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
	*IF USER NOT LOGGED IN, THEN REDIRECT TO INDEX PAGE.
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
	

	require_once "common/headerLogin.php";
?>
<script>
	var answers = []; 	/*Stores array of correct answers retrieved from  "answers" cookie*/
	var responses = []; /*Stores array of user responses retrieved from  "responses" cookie*/
	var score = 0;      /*Stores score of user */
	/*
	 * Function retrieves value of Cookie whose name is passed as parameter. 
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

	answers = JSON.parse(decodeURI(getCookie("answers") ) );
	responses = JSON.parse( getCookie("responses") );

	if(!answers || !responses)  {
		window.location.href = "finalSubmit.php?error=Error check answers. Please contact organisers";
	}

	for(i = 0 ;i <answers.length;i++)
		answers[i] = parseInt(answers[i]);


	/*Replace responses array elements with zeroes for unanswered questions*/
	for(var i = 0; i< answers.length;i++ )  {
		if(!responses[i])
			responses[i] = 0;
		else
			responses[i] = responses[i];
	}
	
	for(var i = 0;i< responses.length;i++)  {
		if(responses[i] == answers[i])  {
			score++;
		}
	}
</script>

<div class="completed-msg">
	<h2 class="completed">
		Round 1 Completed!
	</h2>
	<p class="part1-complete">
		Well Done! You have completed the Round 1 of our competition.
	</p>
	<p class="rest-of-message">
		Our team will contact you very soon with the results.
	</p>
</div>

<div class="score-disp">
	<div class="scores">
		<h2 class="test-cleared">
			<i class="icon-tick"></i> Test 1 Cleared. 
		</h2>
		<span class="score-disp1">
			Your Score : 
		</span>
		<span class="score-disp2" id="score_disp2">
			 
		</span>
		<span class="score-disp3" id="score_disp3">
			
		</span>	
	</div>
	
	<h3 class="msg">Results will be declared and conveyed soon. </h3>	
</div>


<script>
	var score_disp2 = document.getElementById("score_disp2");
	var score_disp3 = document.getElementById("score_disp3");
	
	var no_of_ques = answers.length; /*No. of questions*/
	var multiplier = 10; /*Marks per question*/

	score_disp2.innerHTML = score;
	score_disp3.innerHTML = "/ " + no_of_ques * multiplier;
</script>