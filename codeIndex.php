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
$message = "";
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
else  
	header('Location:index.php');
if(!$login)	
	header('Location:index.php'); //Redirect to index if not logged in.

else
	include_once "views/common/headerLogin.php"; //used when user logged in.

?>

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
                <div class="col-md-1 ques-heading">
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

                            <td class="options">
                                <label>
                                    <input type='checkbox' class='checkBox' value='<?=$optNo ?>' onchange='check(<?= $optNo ?>)' id='option<?= $optNo?>'>
                                    <?=  $options[2+ $i] ?>
                                </label>;</td>

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

</script>