<?php
/*
 * _1_ : Users & Accounts
 * _2_ : Permissions
 * _3_ : Error Logs
 * _4_ : Data System
 * _5_ : Option Boxes
 * _6_ : Groups
 * _7_ : Admin Pages
 * _8_ : Themes
 *		_8.1_ : Navigations
 * _9_ : Slugs & Pages
 * _10_ : Admin Settings
 *
 *
 *
 */
//********** Users & Accounts : _1_ **********//

// Gets the current users username.
function getUsername() {
	session_start();
	return $_SESSION['username'];
}

// Checkes if a user is logged in.
function isLoggedIn() {
	if (isset($_SESSION['username'])) {
		return true;
	} else {
		return false;
	}
}

// Creates a user.
function createUser($username, $email, $password) {
	setDat('users/'.$username, 'user-information', 'username', $username);
	setDat('users/'.$username, 'user-information', 'email', $email);
	setDat('users/'.$username, 'user-information', 'email-status', 'not-verified');
	setDat('users/'.$username, 'user-information', 'email-code', rand(11111,99999));
	setUserPassword($username, $password, $email);
}

// Gets some data stored in a users info.
function getUserInfo($username, $data) {
	return getDat('users/'.$username, 'user-information', $data);
}

// Sets some data in a users info.
function setUserInfo($username, $data, $value) {
	setDat('users/'.$username, 'user-information', $data, $value);
}

// Sets a users password.
function setUserPassword($username, $password, $email) {
	$final = $email.$password;
	$final_pass = md5($final);
	setDat('users/'.$username, 'user-information', 'pass-hash', $final_pass);
}

// Gets a users stored hash.
function getUserHash($username) {
	return getDat('users/'.$username, 'user-information', 'pass-hash');
}

// Hashes a password.
function hashPassword($username, $password, $email) {
	$final = $email.$password;
	return md5($final);
}

// Checks if a password matches the users stored hash.
function checkUserPassword($username, $password) {
	$stored_hash = getUserHash($username);
	$email = getUserInfo($username, 'email');
	$final_pass = hashPassword($username, $password, $email);
	if ($final_pass == $stored_hash) {
		return true;
	} else {
		return false;
	}
}

// Checks if a user exists.
function userExists($user) {
	global $INS_DIR;
	$file = $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-users/' . $user . '.php';
	if (file_exists($file)) {
		return true;
	} else {
		return false;
	}
}

// Checks if a hash matches the users stored one.
function checkUserHash($username, $hash) {
	$stored_hash = getUserHash($username);
	if ($hash == $stored_hash) {
		return true;
	} else {
		return false;
	}
}

// Logs the user in.
function logUserIn($username, $password) {
	if (checkUserPassword($username, $password)) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['userhash'] = hashPassword($username, $password);
	}
}

// Logs the user out.
function logUserOut() {
	session_destroy();
}

// Returns an array of all the users.
function getAllUsers() {
	global $INS_DIR;
	return glob($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-users/*.php', GLOB_BRACE);
}

function disableUser($username) {
	setUserInfo($username, 'disabled', true);
}

function enableeUser($username) {
	setUserInfo($username, 'disabled', false);
}

function userIsDisabled($username) {
	$status = getUserInfo($username, 'disabled');
	if ($status) {
		return true;
	} else {
		return false;
	}
}

//********** Permissions : _2_ **********//

// Returns true if the stated user has access to a permission.
function userHasPermission($username, $permission) {
	if (getDat('users/'.$username, 'permissions', '*') == true) {
		return true;
	} else {
		return getDat('users/'.$username, 'permissions', $permission);
	}
	
}

// Returns true if the current user has access to a permission
function hasPermission($permission) {
	$username = getUsername();
	if (getDat('users/'.$username, 'permissions', '*') == true) {
		return true;
	} else {
		return getDat('users/'.$username, 'permissions', $permission);
	}
}

// Sets the access to the permission (True/False)
function setPermission($username, $permission, $value) {
	if (userExists($username)) { 
		setDat('users/'.$username, 'permissions', $permission, $value);
		return true;
	} else {
		return false;
	}
}

function definePermission($category, $permission, $description) {
	global $permissions_list;
	$permissions_list[$category][$permission]['description'] = $description;
}
//********** Error Logs : _3_ **********//

// Logs an error.
function logError($message) {
	global $INS_DIR;
	$file_location = $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'logs/error-logs/'.date('z-Y').'.html';
	$file = fopen($file_location, 'a');
	$final_message = '<p><span style="color: red; font-weight: 900;">'.date("h:i A").'</span> - '.$message.'</p>';
	echo fwrite($file, $final_message);
	fclose($file);
}


//********** Data System : _4_ **********//

// ---- Documentation ---- //

// Setting Data
// setDat($dat_file, $sec, $subsec, $val);

// Getting Data
// getDat($dat_file, $sec, $subsec)

// Deleting Data
// delDat($dat_file, $sec) // Deletes an entire section
// OR
// delDat($dat_file, $sec, $subsec) // Deletes a subsection

// ----               ---- //

// Sets some data.
function setDat($dat_file, $sec, $subsec, $val) {
	global $INS_DIR;
	$dat_file_dat = json_decode(str_replace("<?php die(); ", "", file_get_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php')), true);
	$dat_file_dat[$sec][$subsec] = [$val];
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php', "<?php die(); ".json_encode($dat_file_dat));
}

// Gets the requested data.
function getDat($dat_file, $sec, $subsec) {
	global $INS_DIR;
	$dat_file_dat = json_decode(str_replace("<?php die(); ", "", file_get_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php')), true);
	return $dat_file_dat[$sec][$subsec][0];
}

// Deletes a an entire section or sub-section.
function delDat($dat_file, $sec, $subsec=false) {
	global $INS_DIR;
	$dat_file_dat = json_decode(str_replace("<?php die(); ", "", file_get_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php')), true);
	if ($subsec == false) {
		unset($dat_file_dat[$sec]);
	} else {
		unset($dat_file_dat[$sec][$subsec]);
	}
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php', "<?php die(); ".json_encode($dat_file_dat));
}

// Gets the entire array from a file.
function getAllDat($dat_file) {
	global $INS_DIR;
	$dat_file_dat = json_decode(str_replace("<?php die(); ", "", file_get_contents($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'data/dat-'.$dat_file.'.php')), true);
	return $dat_file_dat;
}

//********** Option Boxes : _5_ **********//

// Adds an option box to the admin page.
/*function addOptionBox($name, $page, $image_URL, $permission, $priority) {
	setDat('option-boxes', $name, 'name', $name);
	setDat('option-boxes', $name, 'page', $page);
	setDat('option-boxes', $name, 'image_URL', $image_URL);
	setDat('option-boxes', $name, 'enabled', true);
	setDat('option-boxes', $name, 'permission', $permission);
	setDat('option-boxes', $name, 'priority', $priority);
}*/
function addOptionBox($name, $page, $image_URL, $permission, $priority) {
	global $option_boxes;
	$option_boxes[$name]['name'] = [$name];
	$option_boxes[$name]['page'] = [$page];
	$option_boxes[$name]['image_URL'] = [$image_URL];
	$option_boxes[$name]['permission'] = [$permission];
	$option_boxes[$name]['priority'] = [$priority];
}

// Hides an option box from the home page
function disableOptionBox($name) {
	setDat('option-boxes', $name, 'enabled', false);
}

// Shows a hidden option box from the home page.
function enableOptionBox($name) {
	setDat('option-boxes', $name, 'enabled', true);
}

function deleteOptionBox($name) {
	delDat('option-boxes', $name);
}

//********** Groups : _6_ **********//

// Creates a group.
function createGroup($name) {
	setDat('groups/'.$name, 'group-information', 'name', $name);
}

// Creates a group.
function setGroupPermission($group, $permission, $value) {
	$data = setDat('groups/'.$group, 'permissions', $permission, $value);
	if ($data == "") {
		return false;
	} else {
		return $data;
	}
}

//********** Admin Pages : _7_ **********//

// Creates an admin page.
function createAdminPage($name, $file_location, $permission) {
	global $admin_pages;
	$admin_pages[$name]['location'] = [$file_location];
	$admin_pages[$name]['permission'] = [$permission];
}

// Gets data on an admin page.
function getAdminPageData($name, $data) {
	global $admin_pages;
	return $admin_pages[$name][$data][0];
}

// Updates data on an admin page.
function setAdminPageData($name, $data, $val) {
	global $admin_pages;
	$admin_pages[$name][$data] = [$val];
}

// Checks if an admin page exists.
function adminPageExists($name) {
	global $admin_pages;
	if (isset($admin_pages[$name])) {
		return true;
	} else {
		return false;
	}
}

//********** Themes : _8_ **********//

function setTheme($name) {
	setDat('website-settings', 'theme', 'active', $name);
}

function getTheme() {
	return getDat('website-settings', 'theme', 'active');
}

function getHeader() {
	global $INS_DIR;
	include $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . '/themes/' . getTheme() . '/header.php';
	
}

function getFooter() {
	global $INS_DIR;
	include $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . '/themes/' . getTheme() . '/footer.php';
}

function addCSS($url) {
	global $css_list;
	$css_list[] = $url;
}

function getCSS() {
	global $INS_DIR;
	global $css_list;
	$css_final = '<link type="text/css" rel="stylesheet" href="http://'.$_SERVER['HTTP_HOST'].$INS_DIR.'themes/'.getTheme().'/style.css"/>';
	foreach ($css_list as $css_link) {
		$css_final .= '<link type="text/css" rel="stylesheet" href="http://'.$_SERVER['HTTP_HOST'].$INS_DIR.$css_link.'"/>';
	}
	return $css_final;
	
}

//********** Themes - Navigations : _8.1_ **********//

/*function addNavigation($name, $display_name, $url, $position) {
	setDat('navigations', $name, 'display-name', $display_name);
}

function removeNavigation($name) {
	setDat('navigations', $name, 'display-name', $display_name);
}

function getNavigation($name) {
	$nav_file = getAllDat('navigations');
	return $nav_file[$name];
}*/

//********** Slugs & Pages : _9_ **********//

// Redirect a slug.
function redirectSlug($slug, $file_location) {
	global $active_slugs;
	$active_slugs[$slug] = [$file_location];
}

// Checks if an slug is active.
function slugActive($slug) {
	global $active_slugs;
	if (isset($active_slugs[$slug])) {
		return true;
	} else {
		return false;
	}
}

// Gets the location of a redirected slug.
function getSlugLocation($slug) {
	global $active_slugs;
	if (slugActive($slug)) {
		return $active_slugs[$slug][0];
	} else {
		return false;
	}
}

//********** Admin Settings : _10_ **********//

function addAdminSettings($function, $title, $permission) {
	global $admin_settings;
	$admin_settings[$function]['function'] = $function;
	$admin_settings[$function]['title'] = $title;
	$admin_settings[$function]['permission'] = $permission;
}











