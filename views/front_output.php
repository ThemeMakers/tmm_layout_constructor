<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php foreach ($tmm_layout_constructor as $row => $row_data) : ?>

	<?php if (!empty($row_data)): ?>

			<?php
			$padding_top = 0;

			if (!isset($tmm_layout_constructor_row[$row]['padding_top'])) {
				$padding_top = 0;
			} else {
				$padding_top = $tmm_layout_constructor_row[$row]['padding_top'];
			}

			if ($padding_top === 0) {
				$padding_top = 0;
			}
			if (empty($padding_top) AND $padding_top != 0) {
				$padding_top = 0;
			}

			//***

			$padding_bottom = 0;

			if (!isset($tmm_layout_constructor_row[$row]['padding_bottom'])) {
				$padding_bottom = 0;
			} else {
				$padding_bottom = $tmm_layout_constructor_row[$row]['padding_bottom'];
			}

			if ($padding_bottom === 0) {
				$padding_bottom = 0;
			}
			if (empty($padding_bottom) AND $padding_bottom != 0) {
				$padding_bottom = 0;
			}

			?>

		<div class="row" style="padding-top: <?php echo $padding_top ?>px; padding-bottom: <?php echo $padding_bottom ?>px;">

			<?php foreach ($row_data as $uniqid => $column) : ?>

				<?php $content = preg_replace('/^<p>|<\/p>$/', '', do_shortcode($column['content'])); ?>
				<div class="<?php echo $column['front_css_class'] ?>"><?php echo $content ?></div>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>

<?php endforeach; ?>
