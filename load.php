<?php

// Load functions
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'admin/functions.php');

// Load admin functions (Functions to run, not functions to call)
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'admin/admin-functions.php');

// Load theme functions file. (Functions to run, not functions to call)
include($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . getTheme() . '/functions.php');