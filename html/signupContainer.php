<!doctype>
<html>
	<body>
		<h3 class="sign-in-title">Sign Up</h3>
		<form method="post" action="">
			<input name="first-name" type="text" class="form-control signup-field" placeholder="First Name" style="margin-bottom: 2px;" required="" />

			<input name="surname" type="text" class="form-control signup-field" placeholder="Surname" required="" />

			<input name="address" type="text" class="form-control signup-field" placeholder="Address" style="margin-top: 10px; margin-bottom: 2px" required="" />

			<input name="town" type="text" class="form-control signup-field" placeholder="Town" style="margin-bottom: 2px" required="" />

			<input name="post-code" type="text" class="form-control signup-field" placeholder="Post Code" style="margin-bottom: 20px" required="" />

			<div id="email-div">
				<input name="email" type="email" class="form-control signup-field" placeholder="Email" required="" autofocus="" style="margin-bottom: 10px;" />
			</div>
			<div id="password-div" class="grid">
				<input name="password" type="password" class="form-control signup-field grid" placeholder="Password" required="" />
			</div>
			<div id="confirm-password-div" class="grid">
				<input name="confirm-password" type="password" class="form-control signup-field" placeholder="Confirm Password" required="" style="margin-top: 2px;" />
			</div>
            <input name="funct" type="hidden" value="signup" />
			<div class="container log-in-button">
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
			</div>
		</form>
		<script type="text/javascript">
			$('form').submit(function() {
		        
			});
		</script>
	</body>
</html>
