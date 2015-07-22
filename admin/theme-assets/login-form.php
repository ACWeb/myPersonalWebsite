<div class="login-form">
	<?php if (isset($_GET['action']) && $_GET['action'] == "login") { 
			if ($_POST['username'] != "" && $_POST['password'] != "") {
				$username = $_POST['username'];
				$password = $_POST['password'];
				if (userExists($username)) {
					if (!userIsDisabled($username)) {
						$email_status = getUserInfo($_POST['username'], 'email-status');
						if ($email_status == 'verified') {
							if (checkUserPassword($username, $password)) {
								echo '<p>Username and password correct!</p>';
								logUserIn($username, $password);
								header('Location: ./');
							} else {
								echo '<p>Incorrect username or password.</p>';
							}
						} else {
							echo '<p>Please verify your account to login.<br/>Check your email.</p>';
						}
					} else {
						echo '<p>Your account has been disabled.</p>';
					}
				} else {
					echo '<p>Incorrect username or password.</p>';
				}
			} else {
				echo '<p>Please enter your username & password.</p>';
			}
			?> <a href="./?page=login">Go Back</a> <?php
		} else if (isset($_GET['action']) && $_GET['action'] == "create-account") {
			if ($_POST['username'] != "" && $_POST['email'] != "" && $_POST['password'] != "" && $_POST['confirm-password'] != "") {
				if (!preg_match('/[^A-Za-z0-9]/', $_POST['username'])) {
					if (!userExists($_POST['username'])) {
						if ($_POST['password'] == $_POST['confirm-password']) {
							createUser($_POST['username'], $_POST['email'], $_POST['password']);
							echo 'Account Created!<br/><br/>Your username is '.$_POST['username'].'.<br/>You will use your username to login so make sure you\'ll remember it.<br/><br/>An email has been sent to '.$_POST['email'].'. Click the link in the email to access your account.<br/><br/>Note: Your account will be deleted in 24Hours if you do not verify your email.<br/><br/>';
						} else {
							echo '<p>The submitted passwords do not match.</p>';
						}
					} else {
						echo '<p>Sorry, that username has already been taken.</p>';
					}
				} else {
					echo '<p>Usernames can only contain letters and numbers.<br/>(A-Z and 0-9)<br/>Note: It cannot contain, spaces, any symbols or non-english characters.</p>';
				}
			} else {
				echo '<p>Please fill in all of the details.</p>';
			}
			?> <a href="./?page=login&action=register">Go Back</a> <?php
		} else {
		if (isset($_GET['action']) && $_GET['action'] == "register") { ?>
			<form action="?page=login&action=create-account" method="post">
				<label>Username</label>
				<input name="username" type="text"/>
				<label>Email</label>
				<input name="email" type="email"/>
				<label>Password</label>
				<input name="password" type="password"/>
				<label>Confirm Password</label>
				<input name="confirm-password" type="password"/>
				<input type="submit"/>
			</form>
			<p>Have an account?<br/><a href="./?page=login">Click here to login.</a></p>
		<?php } else { 

	?>
	<form action="?page=login&action=login" method="post">
		<label>Username</label>
		<input name="username" type="text"/>
		<label>Password</label>
		<input name="password" type="password"/>
		<input type="submit"/>
	</form>
	<p>Don't have an account?<br/><a href="./?page=login&action=register">Click here to register.</a></p>
	<?php }
	} ?>
</div>
