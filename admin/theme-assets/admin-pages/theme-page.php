<?php
	$theme = $_GET['theme'];
	$action = $_GET['action'];
	$active_theme = getTheme();
?>
<div class="theme-page">
	<?php if ($action == 'customize-theme') { 
		
			if ($theme == $active_theme) {
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . $theme . '/_customize.php')) {
					include ($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . $theme . '/_customize.php');
				} else {
					echo 'This theme does not allow customizations.';
				}
			} else {
				echo 'You can only edit your active theme.';
			}
		} else {
	?>
	<div class="section" id="left">
		<div class="title">
			<h2>
				<a href="./?page=theme"><i class="fa fa-chevron-left"></i></a>  
			<?php
			if ($action == 'view-theme') {
					echo 'Theme information';
				} else if ($action == 'change-theme') {
					echo 'Change Theme';
				} else {
					echo 'Theme Help';
				}	
			
			?>
			</h2>
		</div>
		<div class="content">
			<?php if ($action == 'view-theme') {
				$theme_about_file = $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . $theme . '/_about.html';
						if (file_exists($theme_about_file)) {
							include($theme_about_file);
						} else {
							echo 'This theme has not given any more information.';
						}
						?>
						<br/>
						<a href="./?page=theme&action=change-theme&theme=<?php echo $theme; ?>">Change to this theme</a>
						<?php
					} else if ($action == 'change-theme') {
							if ($active_theme != $theme) {
								if (file_exists($_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes/' . $theme)) {
									setTheme($theme);
									echo '
										<p>Theme Changed!</p>
										<p><a href="./?page=theme&action=customize-theme&theme='.$theme.'">Customize theme.</a></p>
										';
								} else {
									echo '<p>Unknown Theme</p>';
								}
							} else {
								echo '<p>Theme already enabled.</p>';
							}
					} else { ?>
					
						<p>Welcome to the theme page.</p>
						<p>Here you can manage your themes and customize your site.</p>
						<hr>
						<p>Select a theme from the installed theme section to view it's details, or look below to customize your current theme.</p>
						<hr>
						<p><a href="./?page=theme&action=customize-theme&theme=<?php echo $active_theme; ?>">Customize your current theme. (<?php echo $active_theme; ?>)</a></p>
					
						
					<?php }	
			?>
		</div>
	</div>
	<div class="section" id="right">
		<div class="title">
			<h2>Available Themes</h2>
		</div>
		<div class="content">
		<?php
			$themes_file = $_SERVER['DOCUMENT_ROOT'] . $INS_DIR . 'themes' . '/*';
			$theme_location = glob($themes_file , GLOB_ONLYDIR);
			foreach ($theme_location as $theme_name) { 
				$theme_id = basename($theme_name);
			?>
				<div class="theme-wrap">
					<img src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $INS_DIR . 'themes/' . $theme_id . '/_theme_image.png' ?>"/>
					<div class="inner-content">
						<p class="theme-name"><?php echo basename($theme_name); ?></p>
						<a href="./?page=theme&action=view-theme&theme=<?php echo basename($theme_name); ?>" class="view-theme">View this theme</a>
					</div>
				</div>
			<?php }
		?>
		</div>
	</div>
	<?php } // End of if customize-theme ?>
</div>