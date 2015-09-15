<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php foreach ($tmm_layout_constructor as $row => $row_data) : ?>

	<?php if (!empty($row_data)): ?>
		<?php $row_style = TMM_Ext_LayoutConstructor::get_row_bg($tmm_layout_constructor_row, $row); ?>

		<div class="section-full-width <?php if (!empty($tmm_layout_constructor_row[$row]['bg_image'])): ?> parallax <?php endif; ?> <?php echo (isset($row_data['front_css_class']) ? @$row_data['front_css_class'] : ''); ?> <?php if (isset($tmm_layout_constructor_row[$row]['bg_type']) AND $tmm_layout_constructor_row[$row]['bg_type'] == 'default'): ?>theme-default-bg<?php endif; ?>" <?php if (isset($tmm_layout_constructor_row[$row]['bg_type']) AND $tmm_layout_constructor_row[$row]['bg_type'] == 'custom'): ?><?php echo $row_style['style_custom_color']; ?><?php else: ?>style="<?php echo $row_style['style_border']; ?>"<?php endif; ?>>

			<?php if (isset($row_style['bg_type']) AND $row_style['bg_type'] == 'custom'): ?>
				<div style="<?php if (!empty($tmm_layout_constructor_row[$row]['bg_image'])): ?>background-image: url(<?php echo $tmm_layout_constructor_row[$row]['bg_image'] ?>); <?php if ($tmm_layout_constructor_row[$row]['bg_cover'] == 1): ?>background-size: auto;<?php endif; ?><?php endif; ?>opacity: <?php echo((float) $tmm_layout_constructor_row[$row]['bg_opacity'] / 100) ?>;filter: alpha(opacity = <?php echo $tmm_layout_constructor_row[$row]['bg_opacity'] ?>);" class="full-bg-image full-bg-image-<?php echo $tmm_layout_constructor_row[$row]['bg_attachment'] ?>"></div>
			<?php endif; ?>

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
			//***
			if (!isset($tmm_layout_constructor_row[$row]['full_width'])) {
				$tmm_layout_constructor_row[$row]['full_width'] = 0;
			}
			?>

			<?php if ($tmm_layout_constructor_row[$row]['full_width'] == 0): ?>
				<div class="clearfix row_container container" style="padding-top: <?php echo $padding_top ?>px; padding-bottom: <?php echo $padding_bottom ?>px;">
				<?php endif; ?>

				<?php foreach ($row_data as $uniqid => $column) : ?>
					<?php $content = preg_replace('/^<p>|<\/p>$/', '', do_shortcode($column['content'])); ?>
					<div class="clearfix <?php echo @$column['effect'] ?> <?php echo $column['front_css_class'] ?>"><?php echo $content ?></div>

				<?php endforeach; ?>

				<?php if ($tmm_layout_constructor_row[$row]['full_width'] == 0): ?>
				</div>
			<?php endif; ?>

		</div>

	<?php endif; ?>

<?php endforeach; ?>
