<html>
<div class="page-wrap">
	<div class="row">
		<div class="col-md-offset-1 col-sm-offset-1 col-md-6 col-sm-6  section-1 ques-summary">
			<div class="ques-list">
				<div class="ques-disp">
					<?php
						if(isset($message))  {
							if(strlen($message) )  
								echo "<h3>$message</h3>";
							else  {
								for($i=1;$i<= $no_of_ques;$i++) {
							?>
							<div class="col-md-3 col-sm-3 list">
								<a href="disp_mcq.php?k=<?= urlencode($i + 100); ?>" class="active questions" id="ques<?= $i ?>" > Question <?= $i ?></a> <!-- DISPLAYS QUESTIONS NOs. -->
							</div>
						<?php 
								} 
							}
					}	
					?>
				</div>
			</div>			
		</div>

			<!-- /*
				  * DISPLAYS TIME LEFT. (static as of now;will be made dynamic later on).
				  */ -->
		<div class="col-md-5 col-sm-5 section-2 clock_inst">
			<div class="clock_div">
				<div class="clock">
					<h4>Time left : 30:25:00</h4>
				</div>
			</div>	

			<!-- /*
				  * DISPLAYS INSTRUCTIONS.
				  */ -->
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