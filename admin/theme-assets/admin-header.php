<header>
	<p class="page-title"><?php 
	
	if (isset($_GET['page'])) {
		echo ucwords(str_replace("-", " ", strtolower(stripcslashes($_GET['page']))));
	} else {
		echo "Home";
	}
	
	 ?></p>
	 <a class="back-link" href="./"><img src="./theme-assets/Images/back-icon.png" alt="Back" /></a>
	 <?php if (isLoggedIn()) { ?>
	 <a class="user-icon" href="#account"><img src="./theme-assets/Images/user-icon.png" alt="Back" /></a>
	 <?php } ?>
</header>
<?php if (isLoggedIn()) { ?>
<div class="user-options">
	<a id="username"><?php echo getUsername(); ?></a>
	<a href="./?page=account">Account</a>
	<a href="./?action=logout">Logout</a>
</div>
<?php } ?>