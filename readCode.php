<?php
$method = $_POST['function'];
$folderName = $_POST['folderName'];
$fileName = $_POST['fileName'];
$file = $folderName . "/" . $fileName;
$code = isset( $_POST['code'] ) ? $_POST['code'] : "";
switch($method)  {
	case "checkFile" : checkFile($file);
					   break;
	case "checkAttempt" : checkAttempt();
						  break; 
	case "saveCode"  :  saveCode($folderName,$file, $code);
						break; 		
	case "findAttempted" : findAttempted($file);
						   break;									  				   	
}

function checkFile($file)  {
	$data = "";
	if( is_file($file) )  {
		$myFile = fopen($file, "r")  or die("Error opening file");
		while(!feof($myFile))
			$data .= fgets($myFile);
		
		echo $data;
		fclose($myFile);
	}
	else  {
		echo "File does not exist";
	}
}

function saveCode($folderName,$file, $code)  {
	if( !is_dir($folderName) )  {
		if( !mkdir($folderName, 0777) )
			die("unable to create folder");
	}

	$myFile = fopen($file,"w") or die("false");

	fwrite($myFile,$code) or die("error writing to file") ;
	fclose($myFile);
	echo "Successfully submitted code"; 
}


function findAttempted($file)  {
	if( is_file($file) )  {
		$myFile = fopen($file, "r") or die("Error opening file");
		$data = "";
		while( !feof($myFile) )  {
			$data .= fgets($myFile);
		}
		echo $data;
	}
	else
		echo "Unattempted";
}
