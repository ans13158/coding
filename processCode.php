<?php
$code = $_POST['code'];
$myFile = fopen("/var/www/html/coding/answers/team2/ques1.txt","w") or die("false");

fwrite($myFile,$code);
fclose($myFile);