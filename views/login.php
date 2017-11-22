<html>
	
<div class="page-wrap">
	<div class="row">
		<div class="regi-page col-md-8 col-md-offset-2">
			<div class="regi-form">
				<h3 id="sign-up">Login</h3>
				<h4 ><a href="register.php" style="color:red;float:left"> Sign-up Instead? </a></h4>
					<br><br>
				<div class = "errors">
					 <?php 
						if(strlen($error) )  {
							echo "<h4> $error </h4>";
						}
					?>	 
				</div>	
				<form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
					<div class="form-group team-info">
						<label for="teamName">Name of Team</label>
						<input type="text" name="teamName" id="teamName" class="form-control" placeholder="Choose a name" required="required">
					</div>	
					
					<div class="form-group team-info">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" onkeyup="validatePassword(this);" required="required">
					</div>	
					
					<div id="validPass"></div>

					<div class="btn-submit">
						<button class="btn btn-primary" name="signUp">Log in</button>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>				
					
</html>