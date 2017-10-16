<?php
session_start();
require_once "connection.php";
$login = 0;
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

if(!$login)	
	include_once "common/header.php" ;
else
	include_once "common/headerLogin.php";
?>

<html>

<div class="page-wrap">
	<div class="row">
		<div class="col-md-offset-1 col-sm-offset-1 col-md-6 col-sm-6  section-1 ques-summary">
			<div class="ques-list">
				<div class="ques-disp">
					<?php
						for($i=1;$i<=20;$i++) {
					?>
					<div class="col-md-3 col-sm-3 list">
						<a href="#" class="active questions" id="ques<?= $i ?>" > Question <?= $i ?></a>
					</div>
					<?php } ?>
				</div>
			</div>			
		</div>

		<div class="col-md-5 col-sm-5 section-2 clock_inst">
			<div class="clock_div">
				<div class="clock">
					<h4>Time left : 30:25:00</h4>
				</div>
			</div>	

			<div class="inst_div">
				<div class="instructions">
					<ul class="inst_list">
						<h3>Instructions</h3>
						<li>Cannot change window; will lead to immediate disqualification.</li>
						<li>Recheck all questions before submitting.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco</li> 
						<li> Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </li>
						<li>Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
					</ul>
				</div>
			</div>
		</div>	
	</div>
</div>

</html>