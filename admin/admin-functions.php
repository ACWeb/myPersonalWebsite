<?php

//***** Define Admin Permissions *****//
definePermission('Admin', '*', 'Bypasses all permissions.');

// Admin option boxes
definePermission('Admin Option Boxes', 'blog-option-box', 'Shows the blog option box.');
definePermission('Admin Option Boxes', 'images-option-box', 'Shows the images option box.');
definePermission('Admin Option Boxes', 'pages-option-box', 'Shows the pages option box.');
definePermission('Admin Option Boxes', 'social-media-option-box', 'Shows the social media option box.');
definePermission('Admin Option Boxes', 'theme-option-box', 'Shows the theme option box.');
definePermission('Admin Option Boxes', 'plugins-option-box', 'Shows the plugin option box');
definePermission('Admin Option Boxes', 'users-option-box', 'Shows the users option box.');
definePermission('Admin Option Boxes', 'settings-option-box', 'Shows the settings option box.');
definePermission('Admin Option Boxes', 'more-option-box', 'Shows the more option box.');

// Admin Pages
definePermission('Admin Pages', 'admin-settings-page', 'Grants access to the settings page and various settings.');
definePermission('Admin Pages', 'admin-blog-page', 'Grants access to the blog page and other blog related features.');
definePermission('Admin Pages', 'admin-theme-page', 'Allows the user to change the theme and edit theme options.');
definePermission('Admin Pages', 'admin-more-page', 'Allows access to the more admin page.');
definePermission('Admin Pages', 'admin-users-page', 'Allows the user to manage other users.');

//***** Admin Option Boxes *****//
addOptionBox("Blog", "blog", "./theme-assets/Images/Icons/Pencil_edit_button_512.png", "blog-option-box", 10);
addOptionBox("Images", "images", "./theme-assets/Images/Icons/Photo_Camera_Sign_512.png", "images-option-box", 15);
addOptionBox("Pages", "pages", "./theme-assets/Images/Icons/Web_page_with_right_column_512.png", "pages-option-box", 20);
addOptionBox("Social Media", "social", "./theme-assets/Images/Icons/Network_connection_512.png", "social-media-option-box", 25);
addOptionBox("Theme", "theme", "./theme-assets/Images/Icons/Inclined_Brush_512-2.png", "theme-option-box", 30);
addOptionBox("Plugins", "plugins", "./theme-assets/Images/Icons/Black_rotated_puzzle_piece_512.png", "plugins-option-box", 40);
addOptionBox("Users", "users", "./theme-assets/Images/Icons/User_silhouette_512.png", "users-option-box", 43);
addOptionBox("Settings", "settings", "./theme-assets/Images/Icons/Settings_gears_512.png", "settings-option-box", 45);
addOptionBox("More", "more", "./theme-assets/Images/Icons/Plus_black_symbol_512.png", "more-option-box", 500);

//***** Admin Pages *****//
createAdminPage('settings', 'admin/theme-assets/admin-pages/settings-page.php', 'admin-settings-page');
createAdminPage('blog', 'admin/theme-assets/admin-pages/blog-page.php', 'admin-blog-page');
createAdminPage('theme', 'admin/theme-assets/admin-pages/theme-page.php', 'admin-theme-page');
createAdminPage('more', 'admin/theme-assets/admin-pages/more-page.php', 'admin-more-page');
createAdminPage('users', 'admin/theme-assets/admin-pages/users-page.php', 'admin-users-page');

//***** Default theme *****//
if (getTheme() == '') {
	setTheme('default');
}

//***** Slugs *****//
redirectSlug('example', '/themes/default/_about.html');


function set_example1() {
	?>
	
	<p>This is set_example1</p>
	
	<?php
}
addAdminSettings('set_example1', 'Example 1', 'edit-example-1');

function set_example2() {
	?>
	
	<p>This is set_example1</p>
	
	<?php
}
addAdminSettings('set_example2', 'Example 2', 'edit-example-2');
