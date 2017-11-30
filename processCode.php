<?php
$folderName = $_POST['folderName'];
$fileName = $_POST['file'];
$code = $_POST['code'];

$folder = "/var/www/html/coding/answers/".$folderName;
$file = $folder . "/".$fileName;


if( !is_dir($folder) )  {
	if( !mkdir($folder, 0777) )
		die("unable to create folder");
}

$myFile = fopen($file,"w") or die("false");

fwrite($myFile,$code) or die("error writing to file") ;
fclose($myFile);
echo "Successfully submitted code"; 