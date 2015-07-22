<?php 
	$action = $_GET['action'];
	$user = $_GET['user'];	
	// List all users if no action is set.
	if (!isset($_GET['action'])) {
?>
<div class="users-page">
	<div class="actions">
		<ul>
			<li>
				<a href="./?page=users&action=create">
					Create User
				</a>
			</li>
			<li>
				<a href="#groups">
					Manage Groups
				</a>
			</li>
			<li>
				<a href="#permissions">
					View All Permissions
				</a>
			</li>
		</ul>
	</div>
	<div class="users">
		<table>
			<tr>
				<th>
					<i class="fa fa-square-o"></i>
				</th>
				<th>
					Username
				</th>
				<th>
					Email Address
				</th>
				<th>
					Group(s)
				</th>
				<th>
					Permissions
				</th>
			</tr>
			<?php
				$users = getAllUsers();
				foreach ($users as $user) {
					$username = str_replace('.php', '', basename($user));
					if ($username != 'index') {
					?>
						<tr>
							<th>
								<a href="./?page=users&action=edit&user=<?php echo $username; ?>">
									<i class="fa fa-pencil-square-o"></i>
								</a>
							</th>
							<th>
								<?php echo $username; ?>
							</th>
							<th>
								<?php echo getUserInfo($username, 'email'); ?>
							</th>
							<th>
								<?php echo 'None'; ?>
							</th>
							<th>
								<?php 
									$userdata = getAllDat('users/'.$username);
									if(!empty($userdata['permissions'])) {
										foreach ($userdata['permissions'] as $permission => $value) {
											if (userHasPermission($username, $permission)) {
												echo $permission.' ';
											}
										}
									} else {
										echo 'None';
									}
									
								 ?>
							</th>
						</tr>
					
					<?php
					}
				}
			?>
		</table>
	</div>
</div>
<?php } else {
	if ($action == 'edit') {
		if (userExists($user)) {
			?>
				<div class="users-page edit-user">
					<div class="title">
						<h2>
							Edit User - <?php echo $user; ?>
						</h2>
					</div>
					<div class="content">
						<p>This needs all of the editable options for a user. It also needs a function to allow plugins to add sections to this page.</p>
					</div>
				</div>
			<?php
		} else {
			echo 'Unknown User';
		}
	} else if ($action == 'delete') {
		echo 'Delete User';
	} else if ($action == 'create') {
		?>
			<div class="users-page create-user">
				<form action="./?page=users&action=submit-create" method="post">
					<label>*Username</label>
					<input name="username"/>
					<label>*Email</label>
					<input name="email"/>
					<label>*Email Status</label>
					<select name="email_status">
						<option value="1">Verified</option>
						<option value="0">Not-Verified</option>
					</select>
					<label>First Name</label>
					<input name="first_name"/>
					<label>Last Name</label>
					<input name="last_name"/>
					<label>*Password</label>
					<input name="password"/>
					<label>*Confirm Password</label>
					<input name="confirm_password"/>
					<button type="submit">Create</button>
				</form>
			</div>
		<?php
	} else if ($action == 'submit-create') {
		
		if (isset($_POST['username']) && $_POST['username'] != '') {
			$username = $_POST['username'];
			if (isset($_POST['email']) && $_POST['email'] != '') {
				$email = $_POST['email'];
				if (isset($_POST['email_status']) && $_POST['email_status'] != '') {
					$email_status = $_POST['email_status'];
					if (isset($_POST['password']) && $_POST['password'] != '') {
						$password = $_POST['password'];
						if (isset($_POST['confirm_password']) && $_POST['confirm_password'] != '') {
							$confirm_password = $_POST['confirm_password'];
			
						} else {
							echo 'Please fill in all the required* fields.';
						}
					} else {
						echo 'Please fill in all the required* fields.';
					}
				} else {
					echo 'Please fill in all the required* fields.';
				}
			} else {
				echo 'Please fill in all the required* fields.';
			}
		} else {
			echo 'Please fill in all the required* fields.';
		}
		
		
		
	} else if ($action == 'disable') {
		echo 'Disable User';
	} else if ($action == 'enable') {
		echo 'Enable User';
	} else {
		echo 'Unknown Action';
	}
}






















