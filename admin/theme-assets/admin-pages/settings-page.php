<div class="settings-page">
	<div class="main-title">
		<h2>Please only edit one section at a time.</h2>
	</div>
	<div class="content">
		<?php
		foreach ($admin_settings as $admin_setting) {
			if (function_exists($admin_setting['function'])) {
				if (hasPermission($admin_setting['permission'])) {
					?>
					<div class="section">
						<h3 class="title"><?php echo $admin_setting['title']; ?></h3>
						<hr>
					<?php $admin_setting['function'](); ?>
					</div>
					<?php
				}
			}
		}
		?>
	</div>
</div>