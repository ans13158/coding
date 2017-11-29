 
<html>

<div class="page-wrap">
	<div class="row">
		<div class="regi-page col-md-8 col-md-offset-2">
			<div class="regi-form">
				<h3 id="sign-up">Register Your Team</h3>
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
						<label for="language">Select Language for Test</label>
						<select class="form-control" name="language" id="language" required="required">
							<option selected="selected">C</option>
							<option>C++</option>
							<option>Java</option>
						</select>  
					</div>	
					<div class="form-group team-info">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" onkeyup="validatePassword(this);" required="required">
					</div>	
					
					<div id="validPass"></div>

					<div class="form-group team-info">
						<label for="password">Confirm Password</label>
						<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" onkeyup="matchPasswords(this);" required="required">
					</div>	
					
					<div id="validConfirm"></div>

					<h3>Information About Members </h3>
					<h4>Member 1</h4>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="teamName">Name</label>
							<input type="text" name="mem1_name" id="mem1_name" class="form-control" placeholder="Name of Member 1" required="required">
						</div>	
						<div class="form-group col-md-6">
							<label for="teamName">Id : </label>
							<input type="text" name="mem1_id" id="mem1_id" class="form-control" placeholder="Id of Member 1" onkeyup="validId('mem1_id');" required="required">
						
						<div id="validId1"></div>

						</div>

						<div class="form-group col-md-6">
							<label for="teamName">Branch : </label>
							<input type="text" name="mem1_branch" id="mem1_Name" class="form-control" placeholder="Branch of Member 1" required="required">
						</div>
						<div class="form-group col-md-6">
							<label for="teamName">Email : </label>
							<input type="email" name="mem1_mail" id="mem1_mail" class="form-control" placeholder="Email of Member 1" required="required">
						</div>
					</div>	

					<h4>Member 2</h4>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="teamName">Name</label>
							<input type="text" name="mem2_name" id="mem2_name" class="form-control" placeholder="Name of Member 2" required="required">
						</div>	
						<div class="form-group col-md-6">
							<label for="teamName">Id : </label>
							<input type="text" name="mem2_id" id="mem2_id" class="form-control" placeholder="Id of Member 2" onkeyup="validId('mem2_id');" required="required">

							<div id="validId2"></div>
						</div>

						<div class="form-group col-md-6">
							<label for="teamName">Branch : </label>
							<input type="text" name="mem2_branch" id="mem2_brach" class="form-control" placeholder="Branch of Member 1" required="required">
						</div>
						<div class="form-group col-md-6">
							<label for="teamName">Email : </label>
							<input type="email" name="mem2_mail" id="mem2_mail" class="form-control" placeholder="Email of Member 2" required="required">
						</div>
					</div>	
					<div class="btn-submit">
						<button class="btn btn-primary" name="signUp">Sign Up</button>
					</div>	
				</form>
			</div>
		</div>
	</div>	
</div>	

<script>
	/*
	*
	*VALIDATING FORM DATA
	*PASSWORD SHOULD BE ATLEAST 6 CHARACTERS LONG
	*BOTH PASSWORDS SHOULD MATCH.
	*
	*/

	function validatePassword(e)  {
		var pass = e.value;
		var valid = document.getElementById("validPass");
		if( pass.length >= 6 )
			valid.innerHTML = "<h4 style='color:blue'>Password OK</h4>"
		else
			valid.innerHTML =  "<h4 style='color:red'>Password should be atleast 6 characters long.</h4>"

	}

	function matchPasswords(e)  {
		var confirmPass = e.value;
		var pass = document.getElementById("password").value;
		var valid = document.getElementById("validConfirm");
		if(confirmPass == pass)
			valid.innerHTML = "<h4 style='color:blue'>Passwords OK</h4>";
		else 
			valid.innerHTML = "<h4 style='color:red'>Passwords should match.</h4>"

	}

	function validId(e)  {
		if(e == 'mem1_id')
			var valid = document.getElementById('validId1');
		else if(e == 'mem2_id')
			var valid = document.getElementById('validId2');

		var id = document.getElementById(e).value;
		var pattern = /\d/
		if(id.length < 5  || id.length > 5)
			valid.innerHTML = "<h4 style='color:red'>Invalid Id No.</h4>"

		if(!pattern.exec(id) )
			valid.innerHTML = "<h4 style='color:red'>Invalid Id No. Only digits should be present</h4>"
			
		else if(id.length == 5 && pattern.exec(id) && id >= 41000 && id <= 60000)
			valid.innerHTML = "<h4 style='color:blue'>Id No. OK</h4>";
	}
</script>