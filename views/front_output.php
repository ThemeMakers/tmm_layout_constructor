<?php if (!defined('ABSPATH')) die('No direct access allowed');

$groups_array = array();

if (!empty($tmm_layout_constructor_row)) {
	foreach ($tmm_layout_constructor_row as $key => $value) {
		$value['columns'] = $tmm_layout_constructor[$key];
		$groups_array[$value['row_group']][] = $value;
	}
}

if (!empty($groups_array)) {
	
	foreach ($groups_array as $group => $rows) {
		
		if (!empty($rows)) {

			$is_mobile_touch = "";
            $bg_color_css = "";
            $bg_image_css = "";
            $opacity_css = "";
			$border_bottom_css = "";
			$container_class = "";
			$row_class = "";
			$full_bg_image = "";

			if (!empty($tmm_layout_constructor_group[$group]['border_bottom_color'])) {
				$border_bottom_css = "border-color:" . $tmm_layout_constructor_group[$group]['border_bottom_color'] . ';';
			}

			if (!empty($tmm_layout_constructor_group[$group]['bg_color'])) {
				$bg_color_css = "background-color:" . $tmm_layout_constructor_group[$group]['bg_color'] . ";";
			}

			if (!empty($tmm_layout_constructor_group[$group]['bg_image'])) {
				$bg_image_css = "background-image: url(" . $tmm_layout_constructor_group[$group]['bg_image'] . ");";
			}

			if (!empty($tmm_layout_constructor_group[$group]['opacity']) && $tmm_layout_constructor_group[$group]['opacity'] != '100') {
				$opacity_css = 'opacity:' . intval($tmm_layout_constructor_group[$group]['opacity']) / 100 . ';filter:alpha(opacity=' . $tmm_layout_constructor_group[$group]['opacity'] . ');';
			}

			$viewport_height_full = !empty($tmm_layout_constructor_group[$group]['viewport_height_full']) ? ' viewport-full' : '';

			$padding_top = !empty($tmm_layout_constructor_group[$group]['padding_top']) ? ' padding-top-off' : '';
			$padding_bottom = !empty($tmm_layout_constructor_group[$group]['padding_bottom']) ? ' padding-bottom-off' : '';
			$is_parallax = !empty($tmm_layout_constructor_group[$group]['is_parallax']) ? ' parallax' : '';
			$is_border = !empty($border_bottom_color) ? ' border' : '';
			$bg_attachment = !empty($tmm_layout_constructor_group[$group]['bg_attachment']) ? ' bg_attachment' : '';
			$bg_attachment_fixed = !empty($tmm_layout_constructor_group[$group]['bg_attachment']) ? ' full-bg-image-fixed' : '';

			if (!empty($tmm_layout_constructor_group[$group]['is_parallax']) && !empty($tmm_layout_constructor_group[$group]['bg_touch_image'])) {
				$is_mobile_touch = ' mobile-video-image';
				$full_bg_image = '<div class="full-bg-image" style="background-image: url(' . $tmm_layout_constructor_group[$group]['bg_touch_image'] . ');"></div>';
			}

			if (empty($tmm_layout_constructor_group[$group]['is_full_width'])) {
			    $container_class = ' class="container"';
			}

			if (empty($tmm_layout_constructor_group[$group]['is_full_width'])) {
			    $row_class = ' class="row"';
			}
			?>

            <section class="section<?php echo wp_kses_post( $padding_top . $padding_bottom . $viewport_height_full . $is_parallax . $is_border . $bg_attachment . $is_mobile_touch . '" style="' . $bg_color_css . $border_bottom_css . '"') ?>>

				<?php if (isset($tmm_layout_constructor_group[$group]['is_overlay']) && $tmm_layout_constructor_group[$group]['is_overlay']): ?>
					<div class="parallax-overlay"></div>
				<?php endif; ?>

				<?php if (!empty($tmm_layout_constructor_group[$group]['bg_image'])): ?>
					
					<div class="full-bg-image<?php echo wp_kses_post( $bg_attachment_fixed . '" style="' . $bg_image_css . $opacity_css . '"' ) ?>></div>
				
				<?php endif; ?>

				<?php echo wp_kses_post( $full_bg_image ); ?>

				<div<?php echo wp_kses_post( $container_class ) ?>>
					
					<?php foreach ($rows as $row): ?>

						<div<?php echo wp_kses_post( $row_class ) ?>>
							<?php if (!empty($row) && is_array($row)): ?>
								<?php if (!empty($row['columns']) && is_array($row['columns']) && !empty($row['columns'])): ?>

									<?php foreach ($row['columns'] as $col_id => $column) : ?>
										<div class="<?php if (!$tmm_layout_constructor_group[$group]['is_full_width']) echo $column['front_css_class'] . ' ' ?><?php echo $column['grid_class'] ?>">
											<?php echo preg_replace('/^<p>|<\/p>$/', '', do_shortcode($column['content'])); ?>
										</div>
									<?php endforeach; ?>

								<?php endif; ?>
							<?php endif; ?>
						</div><!--/ .row-->

					<?php endforeach; ?>
						
				</div><!--/ .container-->
					
			</section><!--/ .section-->

			<?php
		}
	}
}