<?php

// Load the installation directory
include('./installation-configs/ins-directory.php');

// Load the API
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'load.php');

if (isset($_GET['username'])) {
	$v_username = $_GET['username'];
	if (isset($_GET['id'])) {
		$v_id = $_GET['id'];
		if (userExists($v_username)) {
			$v_email_status = getUserInfo($v_username, 'email-status');
			if ($v_email_status == 'not-verified') {
				$v_email_code = getUserInfo($v_username, 'email-code');
				if ($v_id == $v_email_code) {
					setUserInfo($v_username, 'email-status', 'verified');
					echo 'Account Verified';
				} else {
					die('Invalid Verification Link');
				}
			} else if ($v_email_status == 'verified'){
				die('This account is already verified.');
			} else {
				die('There was a problem with this link.');
			}
		} else {
			die('Invalid Verification Link');
		}
	} else {
		die('Invalid Verification Link');
	}
} else {
	die('Invalid Verification Link');
}

