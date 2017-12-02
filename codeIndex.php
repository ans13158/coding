<?php

/*First page displayed for subjective questions*/

	
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
        $lang = $_SESSION['language'];
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

else  {
	include_once "views/common/headerLogin.php"; //used when user logged in.
    $team_cookie = "team_cookie";
    $team_value = $teamNo;
    setcookie($team_cookie,$team_value); 
}


/*
 * COUNTS TOTAL NO. OF QUESTIONS IN DB. 	
*/

$count_query = "SELECT count(*) FROM `subjectives`";
$count_result = $conn->query($count_query);
$number = mysqli_fetch_array($count_result);
$no_of_ques = $number[0];

?>

<script>
var _ANSWER_PATH = "/var/www/html/coding/answers/team";    
var urlParam = function(name) {
var results = new RegExp('[/?&]' + name + '=([^&#]*)').exec(window.location.href);
if (results == null)
   return null;
else
   return decodeURI(results[1]) || 0;
}

var question = parseInt(urlParam('ques'));
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

    <?php
            /*Using file to store  question because faster than database.*/

            $questionNo = $_GET['ques'] - 100;
            $quesExistQuery = "SELECT * FROM `subjectives` WHERE `quesId` = '$questionNo'";
            $quesExistResult = $conn->query($quesExistQuery);
            if(!$quesExistResult)
                die("This question doesn't exist. Please contact organizers");
            $quesData = mysqli_fetch_assoc($quesExistResult);
            $quesNo = $quesData['quesId'];
            $quesName = $quesData['quesName'];
            $filePath = $quesData['filePath'];
            $fileName = $quesData['fileName'];

            $file = $filePath . "/". $fileName;
            
            $quesFile = fopen($file,'r') or die("This question doesn't exist. Please contact organizers");

            $quesContent = "";

            while( !feof($quesFile) )  {
                $quesContent .= fgets($quesFile) . "<br>";
            } 

            fclose($quesFile);
    ?>

    <div class="row">
        <div class="col-md-8 col-sm-8 section-1 ques-summary">
            <!-- <div class="mcq-disp"> -->
            <div class="mcq-ques">
                <div class="col-md-12 ques-heading">
                    <div class="col-md-1">
                        <h3> <?= $quesNo ?>. 
                            <img src="assets/images/bookmark_before.svg" style="margin-left: -10px;height: 35px;width:35px" id="review_ques<?= $quesNo ?>">
                             <span id="bookmark-dialog"><p>Mark Question</p></span>
                        </h3> 
                    </div>
                    <div class="col-md-offset-2 col-md-8">    
                        <h2><?= $quesName ?></h2>
                    </div>    
                    
                </div>
                <div class="col-md-12 ques-content">
                    <h4> <?= $quesContent ?></h4>
                </div>
            </div>
            <div class="text-editor">
                <div id="autosave-msg">
                    <h4>Your code will be automatically saved after 1 sec.</h4>
                    <h4>Select your language below.</h4>
                </div>    
                <div class="lang-opt col-md-6">
                    <label for="select_lang">Select Language</label>
                    <select id="select_lang" onchange="editorLang();">
                        <option value="c">C</option>
                        <option value="cpp">C++</option>
                        <option value="java">Java</option>
                    </select>
                </div> 
                <div class="font-size col-md-6">
                    <label for="fontSelect">Font Size</label>
                    <select id="font-size" onchange="selFontSize();">
                        <option value="14">14px</option>
                        <option value="10">10px</option>
                        <option value="12">12px</option>
                        <option value="16">16px</option>
                        <option value="18">18px</option>
                        <option value="20">20px</option>
                    </select>
                </div>   
                <div id="editor"></div>
            </div>    
            
            <div id="errorSubmit" class="errorSubmit"></div>
            <div id="success_div" class="success_div"></div>

            <div class="buttons_subjective">
                <div class=" col-md-offset-3 col-md-3 btn-nav">
                    <button id="submit_btn" class="btn btn-danger submit_btn" onclick="submitCode();"> Submit Code</button>
                </div>
                <div class="col-md-12 navigation">
                    <div class="col-md-6 btn_nav btn_prev">
                        <a id="btn_prev" class="btn_prev" onclick="prevQues();"> <<< Previous  </a>
                    </div>
                    <div class="col-md-6 btn_nav btn_next">
                        <a id="btn_next" class="btn_next" onclick="nextQues();"> Next >>> </a>
                    </div>
                </div>    
                <input type="hidden" id="max_question" name="max_question" value="<?= $no_of_ques ?> ">
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

<!-- Scripts for code editor configs -->
<script src="assets/lib/src-min/ace.js"></script>
<script src="assets/lib/src-min/theme-crimson_editor.js"></script>
<script src="assets/lib/src-min/mode-c_cpp.js" type="text/javascript" charset="utf-8"></script>
<script src="assets/lib/src-min/mode-java.js" type="text/javascript" charset="utf-8"></script>
<script src="assets/lib/src-min/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>

<script>
    /*Retrive team_cookie to create folder named team no.*/
        function getCookie(c_name) {
            var i, x, y, ARRcookies = document.cookie.split(";");
            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                x = x.replace(/^\s+|\s+$/g, "");
                if (x == c_name) {
                    return unescape(y);
                }
            }
        }

        var teamNo = getCookie("team_cookie");
        
    /*Retrive team_cookie to create folder named team no.*/
    
    var editor = ace.edit("editor"); //defined variable for code editor object 

    editor.setTheme("ace/theme/crimson_editor");
    var JavaScriptMode = ace.require("ace/mode/c_cpp").Mode;
    editor.session.setMode(new JavaScriptMode());
    document.getElementById("editor").style.fontSize='14px';
    editor.session.setOption("tabSize",4);   
    filler = "#include <stdio.h>\n\nint main()  {\n\n\t//Your code goes here\n\n\treturn 0;\n}"
    editor.session.setValue(filler);  

    var error_div =document.getElementById("errorSubmit");
    error_div.style = "display:none";

    var success_div =document.getElementById("success_div");
    success_div.style = "display:none";

    
/*Change editor language onchange SELECT LANGUAGE dropdown*/
    var edit = document.getElementById('select_lang');
    var lang = edit.value;
    
    function editorLang()  {
        lang = edit.value;    
        if(lang == "java")  {
            var JavaScriptMode = ace.require("ace/mode/java").Mode;
            editor.session.setMode(new JavaScriptMode());
            editor.setOptions({
                tabSize : 2,
                useSoftTabs : true
            });
            filler =    
                            "\import java.util.*;\nimport java.lang.*;\nimport java.io.*;\n\n/* Name of the class has to be 'Main' only if the class is public. */\n\nclass Program\n{\n\tpublic static void main (String[] args) throws java.lang.Exception\n\t{\n\n\t\t// your code goes here\n\n\t}\n}";
            editor.setValue(filler); 

            showSavedCode();

        }

        if(lang == "cpp")  {
            var JavaScriptMode = ace.require("ace/mode/c_cpp").Mode;
            editor.session.setMode(new JavaScriptMode());
            filler = "#include <iostream>\nusing namespace std;\n\nint main()  {\n\t//Your code goes here\n\treturn 0;\n}";
            editor.session.setOption("tabSize",4);   
            editor.session.setValue(filler);                
            showSavedCode();
        }

        if(lang== "c")  {
            var JavaScriptMode = ace.require("ace/mode/c_cpp").Mode;
            editor.session.setMode(new JavaScriptMode());
            editor.session.setOption("tabSize",4);   
            filler = "#include <stdio.h>\n\nint main()  {\n\n\t//Your code goes here\n\n\treturn 0;\n}";
            showSavedCode();
            editor.session.setValue(filler);                
            showSavedCode();
        }
    }

    function selFontSize()  {
        var font_size =document.getElementById("font-size").value;
        document.getElementById("editor").style.fontSize = font_size+"px";

    }

   
</script>
<!-- Scripts for code editor configs -->

<!-- Scripts for code editor functionalities -->
<script>
    /*Show code in code editor when question's file already has content in it.*/
    function showSavedCode()  {
        var fileName = question + "_" + lang + ".txt";
        var folder = _ANSWER_PATH + teamNo;
        //alert(folderName + "/" + fileName);
        $.post("readCode.php", {
            function : "checkFile",
            fileName : fileName,
            folderName : folder
        },
         function(data,status)  {
           if(data!== "File does not exist")  {
             editor.setValue(data);
           }
        });

        }
    
    showSavedCode();

    /*Take code to be submitted and write to file "/var/www/html/coding/answers/<teamNo>/<quesNo_lang>.txt"*/

    //making call to finalSubmit here so as to pass code in editor as parameter. good for reusibility
    function submitCode()  {
        var code = editor.session.getValue();
        finalSubmit(code);
    }

    function finalSubmit(code, showSucessMessage = true)  { /*showSuccessMessage set to false when code 
                                                            saved from autosave feature.*/

        var fileName = question + "_" + lang + ".txt";
        var folderName = _ANSWER_PATH + teamNo;
        var showSuccess = true; 
        /*if both showSuccess and showSuccessMessage are true, means show success message below. if showSuccessMessage is false, dont show message*/
        
        //Send code using POST request.
        $.post("readCode.php",
            {   
                function : "saveCode",
                folderName : folderName,
                fileName : fileName,
                code : code
            },
            function(data, status){
                if(status == "success")  {
                    if(data.length > 0)  {
                        if(data == "Successfully submitted code" && (showSucessMessage == true && showSuccess == true) )  {
                            success_div.style = "display:block";
                            success_div.innerHTML = "Successfully submitted code";
                        }
                        else if(data == "Successfully submitted code" && (showSucessMessage == false && showSuccess == true) )  {;}

                        else  {   
                            alert("data:"+data+";<br>status:"+status );
                            error_div.style = "display:block";
                            error_div.innerHTML = "Error submitting code. Please try again or contact the organizers";
                        }
                    }
                   } 
            });
       
    }

     /*AutoSave code after every 1 sec
     * Uses HTML5's LOCALSTORAGE    
    */
    function autoSave()  {
        if(typeof(Storage) !== "undefined")  {      /*Checks if LOCALSTORAGE is supported by browser. If   
                                                      not: Cant do anything. Sorry no autosave.*/

            var currentCode = editor.getValue();  //Stores current code in editor
            localStorage.setItem("currentCode", JSON.stringify(currentCode) );
            window.onbeforeunload = function()  {
                localStorage.setItem(question, JSON.stringify(lang) );

                finalSubmit( JSON.parse(localStorage.getItem("currentCode")), false ); 
                /*set showSucessMessage false so that success message is not displayed when autoSave saves code to file*/
            }
        }
        setTimeout(autoSave,1000);
    }
    autoSave();

    function showLastLang()  {             /*Selects language in editor that was selected last time. */
        if(localStorage.getItem(question) )  {
            var lastLang = JSON.parse( localStorage.getItem(question) );
            var select_lang = document.getElementById("select_lang");
            for(var i =0;i<select_lang.options.length;i++)  {
                if(select_lang.options[i].value === lastLang )  {
                    select_lang.selectedIndex = i;
                    editorLang();
                    break;
                }
            }
        } 
    }  
    showLastLang();
</script>
<!-- Scripts for code editor functionalities -->

<!-- Scripts for other functionalities -->
<script>
    /*
     * Functionality for NEXT & PREVIOUS buttons.
    */
	function prevQues() {
	    window.location.href = "codeIndex.php?ques=" + (question - 1);
	}

	function nextQues() {
	    window.location.href = "codeIndex.php?ques=" + (question + 1);
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
</script>
<!-- Scripts for other functionalities -->

    