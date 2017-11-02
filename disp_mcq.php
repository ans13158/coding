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
	 * "answers[]" also used to check if question has been attempted or left unattempted.
	 * "responses" is the value and name of cookie storing responses of answers.
	 * "question" stores current question no. by taking GET parameter.
	 * "reviews[]" stores question nos. marked for review.
	 */
	
	var answers = [];
	var responses = [];
	var review = [];
	//var review_ques = [];
	
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
    
    var response_cookie = getCookie('responses');
    if(response_cookie)
		if(response_cookie.length)  {
			answers = JSON.parse(response_cookie);
			//alert(answers)
		}

  
   /*
	* Fetch value of REVIEW cookie, if exists
	*/	
		var review_cookie = getCookie('review');
		if(review_cookie)  {
			if(review_cookie.length)  {
				review = JSON.parse(review_cookie);
				//alert(review);
			}
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
                    <div style="display: inline-block;">
                        <h4>Un-attempted</h4></div>
                </div>

                <div class="col-md-4">
                    <div class="color-2 coding" style="display: inline-block;">
                    </div>
                    <div style="display: inline-block;">
                        <h4>Attempted</h4></div>
                </div>

                <div class="col-md-4">
                    <div class="color-3 coding" style="display: inline-block;">
                    </div>
                    <div style="display: inline-block;">
                        <h4>Marked for Review</h4></div>
                </div>
            </div>
        </div>
    </div>

    <!-- DIV FOR DISPLAYING QUESTIONS AND OPTIONS -->
    <div class="row">
        <div class="col-md-8 col-sm-8 section-1 ques-summary">
            <!-- <div class="mcq-disp"> -->
            
            <div class="mcq-ques">
                <div class="col-md-1 ques-heading" >
                    <h4> <?= $quesNo ?>.</h4>
                    <img src="assets/images/bookmark_before.svg" style="margin-left: -10px;" id="review_ques<?= $quesNo ?>">
                    <span id="bookmark-dialog"><p>Mark Question</p></span>
                </div>
                <div class="col-md-11 ques-content">
                    <h4> <?= $quesContent ?></h4>
                </div>    
            </div>

             <div class="mcq-options col-md-offset-1 col-md-11">
                <table class="table table-hover table-bordered"> 
                    
                        <br>
                    <?php
                        for($i=0; $i<4;$i++)  {
                            $optNo = $i+1;
                    ?>        
                    <tr>
                        
                        <td  class="options"><label> <input type='checkbox' class='checkBox' value='<?=$optNo ?>' onclick='check(<?= $optNo ?>)' id='option<?= $optNo?>' > <?=  $options[2+ $i] ?> </label>;</td>
                        
                       
                    </tr>
                  <?php
                  }
                  ?>  
                  
                </table>
            </div>    
                
                

                <div class="buttons">
                    <div class="col-md-3 btn-nav">
                    	<button id="submit_btn" class="btn btn-danger submit_btn" onclick="finalSubmit();"> Submit Test</button>
                    </div>	
                    <div class="col-md-offset-3 col-md-3  btn_nav">
                        <button id="previous_btn" class="btn btn-primary previous_btn" onclick="prevQues();"> Previous</button>
                    </div>
                    <div class="col-md-3 btn_nav">
                        <button id="next_btn" class="btn btn-primary next_btn" onclick="nextQues();"> Next</button>
                    </div>
                    <input type="hidden" id="max_question" name="max_question" value="<?= $no_of_ques ?> ">
                </div>
        </div>
    <!-- </div> -->

<!-- </div> -->
<!-- </div> -->

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
                    <div class="quesNo unattempted" id="ques<?= $i ?>">
                        <a class="quesNo_link" href="disp_mcq.php?k=<?= urlencode($i + 100); ?>">
                            <?= $i ?>
                        </a>
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
 var reviewId = "review_ques" + (question - 100);

//Total no. of questions in the db.
var no_of_ques = document.getElementById('max_question').value;
no_of_ques = parseInt(no_of_ques);

//Image used for bookmark icon
var review_img = document.getElementById(reviewId);

//Counts no. of clicks on bookmark icon. For odd clicks, bookmark ques.; else unmark
var clickCount = 0

//Dialog "Mark Question" appears when bookmark icon is hovered upon.
var bookmark_dialog = document.getElementById("bookmark-dialog");

review_img.onmouseover = function() {
    bookmark_dialog.style = "display:block";
}

review_img.onmouseout = function() {
    bookmark_dialog.style = "display:none";
}

/*
 *Fill values in "review" & "answers" arrays with zeroes for null values.
 */

function fillReview()  {
	for(var i = 0;i < no_of_ques; i++)  {
		if(!review[i])  
			review[i] = 0;
		else
			review[i] = review[i];
	}
}

function fillAnswers()  {
	for(var i = 0;i < no_of_ques; i++)  {
		if(!answers[i])  
			answers[i] = 0;
		else
			answers[i] = answers[i];
	}
}

fillAnswers();
fillReview();
/*
 * Change image when bookmark icon clicked.
 * For odd no. of clicks : bookmark_after icon else bookmark_before
 */
review_img.onclick = function() {
    clickCount++;
    if (clickCount % 2 == 1) {
        review_img.src = "assets/images/bookmark_after.png";
        review_img.style = "height :40px;width:40px";
        review[question - 101] = 1;
        document.cookie = "review = " + JSON.stringify(review);
        changeReviewColor();
    } else {
        review_img.src = "assets/images/bookmark_before.svg";
        review[question - 101] = 0;
        document.cookie = "review = " + JSON.stringify(review);
        changeReviewColor();
    }
}

function finalSubmit()  {
    window.location.href = "finalSubmit.php";
}

function check(optNo) {

    /* Section enables checking only 1 checkbox at a time. */

    /*REMOVED FOR NOW*/

    // if(document.getElementById(optNo).checked == true)  {
    // 	document.getElementById(optNo).checked = false;
    // }
    // for(var i = 1; i <=4; i++)
    // 	document.getElementById(i).checked = false;

    // document.getElementById(optNo).checked = true;

    /* Section enables checking only 1 checkbox at a time. */

    /*Fetch value of selected checkbox and store in "answers[]" array */
    var checked = [];
    var elements = document.getElementsByClassName('checkBox');
    for (var i = 0; elements[i]; i++) {
        //alert(elements[i].checked)
        if (elements[i].checked) {
            checked[i] = elements[i].value;
        } 
        else
            checked[i] = 0;
    }

    for (var i = 0; i < 4; i++) {
        if (checked[i] != '0' || checked[i] != 0) {
            answers[question - 101] = parseInt(checked[i]);
        }
    }
    /*Fetch value of selected checkbox and store in "answers[]" array */

    responses = JSON.stringify(answers);
    document.cookie = 'responses=' + responses;
}

/* 
 * "no_of_ques" stores no. of questions  in db.	
 * "question" stores the current question no.
 * "prevQues()" & "nextQues()" give functionalities to PREVIOUS & NEXT buttons.
 */

var no_of_ques = document.getElementById('max_question').value;
no_of_ques = parseInt(no_of_ques);
no_of_ques += 100;

var previous = document.getElementById('previous_btn');
var next = document.getElementById('next_btn');

/*
 * Disable NEXT or PREVIOUS buttons a/c to current ques no. :
 * If current ques. is first question in list, disable PREVIOUS.
 * If ques. last in list, disable NEXT.
 */
if (question == no_of_ques) {
    next.disabled = true;
}
if (question == 101)
    previous.disabled = true;

function prevQues() {
    window.location.href = "disp_mcq.php?k=" + (question - 1);
}

function nextQues() {
    window.location.href = "disp_mcq.php?k=" + (question + 1);
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
    n = h + " : " + m + " : " + s;
    document.getElementById('clock').innerHTML = "<h4> Time Left  " + n + "</h4>";
    t = setTimeout(function() {
        startTime()
    }, 1000);
}
startTime();

/*
 * Function changes colors of circles with questions that are attempted, unattempted, etc. a/c to color code. 
 */

function changeReviewColor() {
    if (review.length) {
        
        if(review[question-101] == 1 || review[question-101] == '1')  {
        	review_img.src = "assets/images/bookmark_after.png";
            review_img.style = "height :40px;width:40px";
            clickCount = 1;
        }
        else  {
        	review_img.src = "assets/images/bookmark_before.svg";
            review_img.style = "height :40px;width:40px";
            clickCount = 0;
        }
        for (var i = 0; i < review.length; i++) {
            var id = "ques" + (i + 1);
            if (review[i] == 1 || review[i] == "1") {
                document.getElementById(id).classList.add("review");
                // review_img.src = "assets/images/bookmark_after.png";
                // review_img.style = "height :40px;width:40px";
                // clickCount = 1;
            }
        }
    }
}

changeReviewColor();

function changeColor() {

    for (var i = 0; i < answers.length; i++) {
        if (answers[i]) {
            id = "ques" + (i + 1);
            document.getElementById(id).classList.remove("unattempted");
            document.getElementById(id).classList.add("attempted");
            if (question - 101 == i) {
                optId = "option" + answers[i];
                document.getElementById(optId).checked = true;
            }
        }
    }
    //   id = "ques" + (i+1) ;
    //   var classes = document.getElementById(id).className.split(" ");
    //   for(var i =0;i<classes.length;i++)  {
    //    if(classes[i] != "attempted" )  {
    // 		document.getElementById(id).classList.remove("attempted");
    //    		document.getElementById(id).classList.add("unattempted");
    // 	}
    // }	
}

changeColor();
// changeReview();

</script>