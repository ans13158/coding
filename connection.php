<?php

$host = "localhost";
$user = "root";
$pass = "ans";
$db = "coding";

$conn = new mysqli($host,$user,$pass,$db);
if(!$conn)
	die("Error connecting DB. Please contact organizers".mysqli_connect_error() );