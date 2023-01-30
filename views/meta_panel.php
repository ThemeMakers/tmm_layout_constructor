<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="tmm_meta_saving" value="1" />
<a href="javascript:tmm_ext_layout_constructor.add_row(); void(0);" class="button button-primary button-large"><?php esc_html_e("Add New Row", 'tmm_layout_constructor') ?></a><br />
<?php $groups_array = array(); ?>
<ul id="layout_constructor_items" class="page-methodology" style="clear: both; display: none;">
	<?php if (!empty($tmm_layout_constructor)): ?>
		<?php foreach ($tmm_layout_constructor as $row => $row_data) : ?>
			<?php
			if (!is_integer($row)) {
				//continue;
			}
			?>
			<li id="layout_constructor_row_<?php echo esc_attr( $row ) ?>" class="layout_constructor_item">
				<table>
					<tr>
						<td>
							<a href="javascript:tmm_ext_layout_constructor.set_group(<?php echo esc_attr( $row ) ?>);void(0);" class="button-secondary button_set_group"><?php esc_html_e("Group", 'tmm_layout_constructor') ?> (<span><?php echo (isset($tmm_layout_constructor_row[$row]) ? $tmm_layout_constructor_row[$row]['row_group'] : 0) ?></span>)</a><br />
							<a href="javascript:tmm_ext_layout_constructor.add_column(<?php echo esc_attr( $row ) ?>);void(0);" class="button-secondary"><?php esc_html_e("Add Column", 'tmm_layout_constructor') ?></a><br />
							<a href="javascript:tmm_ext_layout_constructor.edit_row(<?php echo esc_attr( $row ) ?>);void(0);" class="button-secondary" style="display: none;"><?php esc_html_e("Edit", 'tmm_layout_constructor') ?></a>
							<a href="javascript:tmm_ext_layout_constructor.delete_row(<?php echo esc_attr( $row ) ?>);void(0);" class="button-secondary" ><?php esc_html_e("Delete", 'tmm_layout_constructor') ?></a>
						</td>
						<td class="col_items">
							<span class="row_columns_container" id="row_columns_container_<?php echo esc_attr( $row ) ?>">
								<?php if (!empty($row_data)): ?>
									<?php foreach ($row_data as $uniqid => $column) : ?>
										<?php
										if ($uniqid == 'row_data') {
											continue;
										}
									
										$col_data = array(
											'row' => $row,
											'uniqid' => $uniqid,
											'css_class' => $column['css_class'],
											'front_css_class' => $column['front_css_class'],
											'value' => $column['value'],
											'content' => $column['content'],
											'title' => $column['title'],
											'grid_class' => $column['grid_class'],
											'viewport_height_full' => isset($column['viewport_height_full']) ? $column['viewport_height_full'] : '',
											'padding_top' => isset($column['padding_top']) ? $column['padding_top'] : '',
											'padding_bottom' => isset($column['padding_bottom']) ? $column['padding_bottom'] : '',
										);

										TMM_Ext_LayoutConstructor::draw_column_item($col_data);
										?>
									<?php endforeach; ?>
								<?php endif; ?>
							</span>
						</td>
						<td><div class="row-mover"><?php esc_html_e("Row Mover", 'tmm_layout_constructor') ?></div></td>
					</tr>
				</table>

				<input type="hidden" id="row_bg_custom_color_<?php echo esc_attr( $row ) ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? $tmm_layout_constructor_row[$row]['bg_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo esc_attr( $row ) ?>][bg_color]" />
				<input type="hidden" id="row_border_color_<?php echo esc_attr( $row ) ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? $tmm_layout_constructor_row[$row]['border_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo esc_attr( $row ) ?>][border_color]" />
				<input type="hidden" id="row_group_<?php echo esc_attr( $row ) ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? $tmm_layout_constructor_row[$row]['row_group'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo esc_attr( $row ) ?>][row_group]" />
				<?php $groups_array[$tmm_layout_constructor_row[$row]['row_group']] = $tmm_layout_constructor_row[$row]['row_group']; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<hr />

<script type="text/javascript">

	var groups_array = [];

	<?php if (!empty($groups_array)): ?>
		<?php foreach ($groups_array as $value): ?>
				groups_array.push("<?php echo esc_attr( $value ) ?>");
		<?php endforeach; ?>
	<?php endif; ?>

</script>

<ul id="groups_list">
	<?php if (!empty($groups_array)): ?>
		<?php foreach ($groups_array as $group_name): ?>
			<li data-group-name="<?php echo esc_attr( $group_name ) ?>">

				<a href="javascript:tmm_ext_layout_constructor.group_settings('<?php echo esc_attr( $group_name ) ?>');void(0);" class="button-secondary button_group_settings" style="width: 110px;text-align:center;margin-right:5px;"><?php esc_html_e("Edit Group", 'tmm_layout_constructor') ?> (<span><?php echo esc_attr( $group_name ) ?></span>)</a><br />

				<div style="display: none;" class="group_settings_html">

					<div class="one-half-grid">
						<?php
                        $tmm_is_full_width = isset($tmm_layout_constructor_group[$group_name]['is_full_width']) ? $tmm_layout_constructor_group[$group_name]['is_full_width'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Full Width', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_full_width',
							'id' => 'is_full_width',
							'default_value' => $tmm_is_full_width,
							'is_checked' => (bool) $tmm_is_full_width,
							'description' => esc_html__('On / Off', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>
						
						<?php
                        $tmm_viewport_height_full = isset($tmm_layout_constructor_group[$group_name]['viewport_height_full']) ? $tmm_layout_constructor_group[$group_name]['viewport_height_full'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Scale section height', 'tmm_layout_constructor'),
							'shortcode_field' => 'viewport_height_full',
							'id' => 'viewport_height_full',
							'default_value' => $tmm_viewport_height_full,
							'is_checked' => (bool) $tmm_viewport_height_full,
							'description' => esc_html__('Set viewport size height to 100%', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>

						<?php
                        $tmm_padding_top = isset($tmm_layout_constructor_group[$group_name]['padding_top']) ? $tmm_layout_constructor_group[$group_name]['padding_top'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Disable Padding Top', 'tmm_layout_constructor'),
							'shortcode_field' => 'padding_top',
							'id' => 'padding_top',
							'default_value' => $tmm_padding_top,
							'is_checked' => (bool) $tmm_padding_top,
							'description' => esc_html__('On / Off', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>
						
						<?php
                        $tmm_padding_bottom = isset($tmm_layout_constructor_group[$group_name]['padding_bottom']) ? $tmm_layout_constructor_group[$group_name]['padding_bottom'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Disable Padding Bottom', 'tmm_layout_constructor'),
							'shortcode_field' => 'padding_bottom',
							'id' => 'padding_bottom',
							'default_value' => $tmm_padding_bottom,
							'is_checked' => (bool) $tmm_padding_bottom,
							'description' => esc_html__('On / Off', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>	
						
						<?php
                        $tmm_is_parallax = isset($tmm_layout_constructor_group[$group_name]['is_parallax']) ? $tmm_layout_constructor_group[$group_name]['is_parallax'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Transparent Section', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_parallax',
							'id' => 'is_parallax',
							'default_value' => $tmm_is_parallax,
							'is_checked' => (bool) $tmm_is_parallax,
							'description' => esc_html__('Set transparent section background for using video background and set white color to section text', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>
						
						<?php
                        $tmm_bg_attachment = isset($tmm_layout_constructor_group[$group_name]['bg_attachment']) ? $tmm_layout_constructor_group[$group_name]['bg_attachment'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Background Attachment', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_attachment',
							'id' => 'bg_attachment',
							'default_value' => $tmm_bg_attachment,
							'is_checked' => (bool) $tmm_bg_attachment,
							'description' => esc_html__('Fixed / Scroll', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>	
						
						<?php
                        $tmm_bg_color = isset($tmm_layout_constructor_group[$group_name]['bg_color']) ? $tmm_layout_constructor_group[$group_name]['bg_color'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => esc_html__('Background Color', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_color',
							'type' => 'color',
							'description' => '',
							'default_value' => $tmm_bg_color,
							'id' => 'row_background_color',
							'css_classes' => ''
						));
						?>	

					</div>
					
					<div class="one-half-grid">
						
						<?php
                        $tmm_bg_image = isset($tmm_layout_constructor_group[$group_name]['bg_image']) ? $tmm_layout_constructor_group[$group_name]['bg_image'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'upload',
							'title' => esc_html__('Background Image', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_image',
							'id' => '',
							'default_value' => $tmm_bg_image,
							'description' => '',
							'css_classes' => ''
						));
						?>	
						
						<?php
                        $tmm_bg_touch_image = isset($tmm_layout_constructor_group[$group_name]['bg_touch_image']) ? $tmm_layout_constructor_group[$group_name]['bg_touch_image'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'upload',
							'title' => esc_html__('Image instead of video', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_touch_image',
							'id' => '',
							'default_value' => $tmm_bg_touch_image,
							'description' => '(for touch devices)',
							'css_classes' => ''
						));
						?>	
						
						<?php 
                        $tmm_opacity = isset($tmm_layout_constructor_group[$group_name]['opacity']) ? $tmm_layout_constructor_group[$group_name]['opacity'] : 100;
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => esc_html__('Opacity', 'tmm_layout_constructor'),
							'shortcode_field' => 'opacity',
							'type' => 'text',
							'description' => '(add color shade over background image) min: 0, max: 100',
							'default_value' => $tmm_opacity,
							'id' => 'value_opacity',
							'css_classes' => ''
						));
						?>		

						<?php
                        $tmm_border_bottom_color = isset($tmm_layout_constructor_group[$group_name]['border_bottom_color']) ? $tmm_layout_constructor_group[$group_name]['border_bottom_color'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => esc_html__('Border Bottom Color', 'tmm_layout_constructor'),
							'shortcode_field' => 'border_bottom_color',
							'type' => 'color',
							'description' => '',
							'default_value' => $tmm_border_bottom_color,
							'id' => 'row_border_bottom_color',
							'css_classes' => ''
						));
						?>	
				
						<?php
                        $tmm_is_overlay = isset($tmm_layout_constructor_group[$group_name]['is_overlay']) ? $tmm_layout_constructor_group[$group_name]['is_overlay'] : '';
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => esc_html__('Overlay', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_overlay',
							'id' => 'is_overlay',
							'default_value' => $tmm_is_overlay,
							'is_checked' => (bool) $tmm_is_overlay,
							'description' => esc_html__('Set overlay on background image', 'tmm_layout_constructor'),
							'css_classes' => ''
						));
						?>

					</div>

				</div>
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][bg_image]" data-attr="bg_image" value="<?php echo esc_attr( $tmm_bg_image ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][bg_touch_image]" data-attr="bg_touch_image" value="<?php echo esc_attr( $tmm_bg_touch_image ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][bg_color]" data-attr="bg_color" value="<?php echo esc_attr( $tmm_bg_color ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][border_bottom_color]" data-attr="border_bottom_color" value="<?php echo esc_attr( $tmm_border_bottom_color ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][is_overlay]" data-attr="is_overlay" value="<?php echo esc_attr( $tmm_is_overlay ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][is_parallax]" data-attr="is_parallax" value="<?php echo esc_attr( $tmm_is_parallax ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][is_full_width]" data-attr="is_full_width" value="<?php echo esc_attr( $tmm_is_full_width ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][bg_attachment]" data-attr="bg_attachment" value="<?php echo esc_attr( $tmm_bg_attachment ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][opacity]" data-attr="opacity" value="<?php echo esc_attr( $tmm_opacity ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][viewport_height_full]" data-attr="viewport_height_full" value="<?php echo esc_attr( $tmm_viewport_height_full ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][padding_top]" data-attr="padding_top" value="<?php echo esc_attr( $tmm_padding_top ) ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo esc_attr( $group_name ) ?>][padding_bottom]" data-attr="padding_bottom" value="<?php echo esc_attr( $tmm_padding_bottom ) ?>" />
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<div style="display: none;">
	
	<div id="layout_constructor_column_item">
		<?php
		$col_data = array(
			'row' => '__ROW_ID__',
			'uniqid' => '__UNIQUE_ID__',
			'css_class' => 'col-md-3',
			'front_css_class' => 'col-md-3',
			'value' => 'col-md-3',
			'content' => '',
			'title' => '',
			'grid_class' => ''
		);
		TMM_Ext_LayoutConstructor::draw_column_item($col_data);
		?>
	</div>
	
	<div id="layout_constructor_column_row">
		<li id="layout_constructor_row___ROW_ID__" class="layout_constructor_item">
			<table>
				<tr>
					<td>
						<a href="javascript:tmm_ext_layout_constructor.set_group(__ROW_ID__);void(0);" class="button-secondary button_set_group" style="width: 110px;text-align:center;margin-right:5px;"><?php esc_html_e("Group", 'tmm_layout_constructor') ?> (<span>0</span>)</a><br />
						<a href="javascript:tmm_ext_layout_constructor.add_column(__ROW_ID__);void(0);" class="button-secondary"><?php esc_html_e("Add Column", 'tmm_layout_constructor') ?></a><br />
						<a href="javascript:tmm_ext_layout_constructor.edit_row(__ROW_ID__);void(0);" class="button-secondary" style="display: none;"><?php esc_html_e("Edit", 'tmm_layout_constructor') ?></a>
						<a href="javascript:tmm_ext_layout_constructor.delete_row(__ROW_ID__);void(0);" class="button-secondary"><?php esc_html_e("Delete", 'tmm_layout_constructor') ?></a>
					</td>
					<td class="col_items">
						<span class="row_columns_container" id="row_columns_container___ROW_ID__"></span>
					</td>
					<td><div class="row-mover"><?php esc_html_e("Row Mover", 'tmm_layout_constructor') ?></div></td>
				</tr>
			</table>
			<input type="hidden" id="row_bg_custom_color___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_color]" />			
			<input type="hidden" id="row_border_color___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_color]" />
			<input type="hidden" id="row_group___ROW_ID__" value="0" name="tmm_layout_constructor_row[__ROW_ID__][row_group]" />

		</li>
	</div>
	
	<div id="layout_constructor_grid_class">
		<?php
		TMM_Ext_LayoutConstructor::draw_html_option(array(
			'type' => 'select',
			'title' => '',
			'label' => esc_html__("Layout constructor", 'tmm_layout_constructor'),
			'shortcode_field' => 'grid_selector',
			'id' => '',
			'options' => TMM_Ext_LayoutConstructor::$grid_class,
			'default_value' => '',
			'description' => '',
			'css_classes' => 'grid_selector'
		));
		?>
	</div>

</div>
