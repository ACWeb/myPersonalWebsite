<div class="option-box-wrap">
<?php

// Sort the option boxes into an array based on priority.
$box_order = array();
foreach($option_boxes as $box) {
	$box_priority = $box['priority'][0];
	while (isset($box_order[$box_priority])) {
		$box_priority = $box_priority + 1;
	}
	$box_order[$box_priority] = $box['name'][0];
}

// Sort the priority array into order.
ksort($box_order);

// Loop through option boxes in order of priority.
foreach($box_order as $box) {
	if (hasPermission($option_boxes[$box]['permission'][0])) {
?>
	<div class="option-box">
		<a href="<?php echo './?page='.$option_boxes[$box]['page'][0]; ?>">
			<div class="inner">
				<div class="content">
					<img alt="<?php echo $option_boxes[$box]['name'][0]; ?>" src="<?php echo $option_boxes[$box]['image_URL'][0]; ?>"/>
				</div>
			</div>
			<h3><?php echo $option_boxes[$box]['name'][0]; ?></h3>
		</a>
	</div>
<?php
	}
}
?>
</div>

