<?php

// Everything is done in this file using variables and includes.
// Do not post data to this page. Use AJAX to post data to the upload.php file.
//
//
//
//
//

// Start the session
session_start();

// Get the installation directory
include('../installation-configs/ins-directory.php');

// Make sure the installation directory is loaded.
if (!isset($INS_DIR)) {
	die('We could not load the installation directory.');
}

// Load the API
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'load.php');

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	logUserOut();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>myPersonalWebsite</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./theme-assets/CSS/admin.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="./theme-assets/JS/admin.js"></script>
	</head>
	<body>
		<?php 
		include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'admin/theme-assets/admin-header.php');
		if (!isLoggedIn()) {
			if (isset($_GET['page']) && strtolower($_GET['page']) == 'login') {
		 		include('./theme-assets/login-form.php');
		 	} else {
			 	header('Location: ./?page=login');
		 	}
		} else {
			if (hasPermission('view-admin-page')) {
				if (isset($_GET['page']) && strtolower($_GET['page']) != 'home') {
					if (adminPageExists($_GET['page'])) {
						if (hasPermission(getAdminPageData($_GET['page'], 'permission'))) {
							include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . getAdminPageData($_GET['page'], 'location'));
						} else {
							echo '<p>You do not have permission to view this page.</p>';
						}
					} else {
						http_response_code(404);
						?>
							<div class="four-zero-four-error">
								<h2>404 - Page not found</h2>
								<p>We cannot find the page you are looking for.</p>
							</div>
						<?php
					}
				} else {
					include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'admin/theme-assets/options-page.php');
				}
			} else {
				echo '<p>You do not have permission to access this area.</p>';
			}
		}
		?>
	<p id="MPW-credits"><a href="http://www.mypersonalwebsite.com/">myPersonalWebsite</a></p>
	</body>
</html>