<?php
$folderName = $_POST['folderName'];
$fileName = $_POST['fileName'];
$file = $folderName . "/" . $fileName;
//echo $file;
$data = "";
if( is_file($file) )  {
	$myFile = fopen($file, "r")  or die("Error opening file");
	while(!feof($myFile))
		$data .= fgets($myFile);
	echo $data;
}
else  {
	echo "File does not exist";
}