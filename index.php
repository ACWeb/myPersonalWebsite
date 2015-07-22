<?php

// Get the installation directory.
include('./installation-configs/ins-directory.php');

// Make sure the installation directory is loaded.
if (!isset($INS_DIR)) {
	die('We could not load the installation directory.');
}

// Load the API.
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'load.php');

/*
 *	This section goes through the URL sent by IIS letter by letter and splits it into
 *	sections called slugs. These slugs can be used to load content and be used as 
 *	variables by plugins or the system.
 *
 *	Note; any real system paths or paths within the admin area are not sent to
 *	this file.
 *
 */
$url = $_GET['url'];
$url_count = strlen( $url );
$slug_number = 1;
$slug = array();
for( $i = 0; $i <= $url_count; $i++ ) {
    $letter = substr( $url, $i, 1 );
    if ($letter == '/' || $letter == '') {
	    $slug_number++;
    } else {
	    $slug[$slug_number] .= $letter;
    }
}
    
/*
 *	This section decides wether the user is requesting the homepage or another page.
 *	It does this by checking wether slug 1 is defined, if not then it will load the
 *	home page.
 *
 *	If the root slug is defined then it will decide what file to load by accessing
 *	the page data and getting a file URL.
 *
 */
if (!isset($slug[1])) {
	include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . getTheme() . '/home-page.php');
} else {
	if (slugActive($slug[1])) {
		include(getSlugLocation($slug[1]));
	} else {
		include $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . getTheme() . '/404.php';
	}
}
