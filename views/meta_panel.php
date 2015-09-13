<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="tmm_meta_saving" value="1" />
<a href="javascript:tmm_ext_layout_constructor.add_row(); void(0);" class="button button-primary button-large"><?php _e("Add New Row", 'tmm_layout_constructor') ?></a><br />
<?php $groups_array = array(); ?>
<ul id="layout_constructor_items" class="page-methodology" style="clear: both; display: none;">
	<?php if (!empty($tmm_layout_constructor)): ?>
		<?php foreach ($tmm_layout_constructor as $row => $row_data) : ?>
			<?php
			if (!is_integer($row)) {
				//continue;
			}
			?>
			<li id="layout_constructor_row_<?php echo $row ?>" class="layout_constructor_item">
				<table>
					<tr>
						<td>
							<a href="javascript:tmm_ext_layout_constructor.set_group(<?php echo $row ?>);void(0);" class="button-secondary button_set_group"><?php _e("Group", 'tmm_layout_constructor') ?> (<span><?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['row_group'] : 0) ?></span>)</a><br />
							<a href="javascript:tmm_ext_layout_constructor.add_column(<?php echo $row ?>);void(0);" class="button-secondary"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
							<a href="javascript:tmm_ext_layout_constructor.edit_row(<?php echo $row ?>);void(0);" class="button-secondary" style="display: none;"><?php _e("Edit", 'tmm_layout_constructor') ?></a>
							<a href="javascript:tmm_ext_layout_constructor.delete_row(<?php echo $row ?>);void(0);" class="button-secondary" ><?php _e("Delete", 'tmm_layout_constructor') ?></a>
						</td>
						<td class="col_items">
							<span class="row_columns_container" id="row_columns_container_<?php echo $row ?>">
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
											'grid_class' => @$column['grid_class'],
											'padding_top' => @$column['padding_top'],
											'padding_bottom' => @$column['padding_bottom'],
										);

										TMM_Ext_LayoutConstructor::draw_column_item($col_data);
										?>
									<?php endforeach; ?>
								<?php endif; ?>
							</span>
						</td>
						<td><div class="row-mover"><?php _e("Row Mover", 'tmm_layout_constructor') ?></div></td>
					</tr>
				</table>

				<input type="hidden" id="row_bg_custom_color_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_color]" />
				<input type="hidden" id="row_border_color_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_color]" />
				<input type="hidden" id="row_group_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['row_group'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][row_group]" />
				<?php $groups_array[@$tmm_layout_constructor_row[$row]['row_group']] = @$tmm_layout_constructor_row[$row]['row_group']; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<hr />

<script type="text/javascript">

	var groups_array = [];

	<?php if (!empty($groups_array)): ?>
		<?php foreach ($groups_array as $value): ?>
				groups_array.push("<?php echo $value; ?>");
		<?php endforeach; ?>
	<?php endif; ?>

</script>

<ul id="groups_list">
	<?php if (!empty($groups_array)): ?>
		<?php foreach ($groups_array as $group_name): ?>
			<li data-group-name="<?php echo $group_name ?>">

				<a href="javascript:tmm_ext_layout_constructor.group_settings('<?php echo $group_name ?>');void(0);" class="button-secondary button_group_settings" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Edit Group", 'tmm_layout_constructor') ?> (<span><?php echo $group_name ?></span>)</a><br />

				<div style="display: none;" class="group_settings_html">

					<div class="one-half-grid">
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Full Width', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_full_width',
							'id' => 'is_full_width',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['is_full_width'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['is_full_width'],
							'description' => __('On / Off', 'tmm_layout_constructor'),
						));
						?>		
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Disable Padding Top', 'tmm_layout_constructor'),
							'shortcode_field' => 'padding_top',
							'id' => 'padding_top',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['padding_top'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['padding_top'],
							'description' => __('On / Off', 'tmm_layout_constructor'),
						));
						?>
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Disable Padding Bottom', 'tmm_layout_constructor'),
							'shortcode_field' => 'padding_bottom',
							'id' => 'padding_bottom',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['padding_bottom'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['padding_bottom'],
							'description' => __('On / Off', 'tmm_layout_constructor'),
						));
						?>	
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Transparent Section', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_parallax',
							'id' => 'is_parallax',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['is_parallax'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['is_parallax'],
							'description' => __('Set transparent section background for using video background and set white color to section text', 'tmm_layout_constructor'),
						));
						?>
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Background Attachment', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_attachment',
							'id' => 'bg_attachment',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['bg_attachment'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['bg_attachment'],
							'description' => __('Fixed / Scroll', 'tmm_layout_constructor'),
						));
						?>	
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => __('Background Color', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_color',
							'type' => 'color',
							'description' => '',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['bg_color'],
							'id' => 'row_background_color'
						));
						?>	

					</div>
					
					<div class="one-half-grid">
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'upload',
							'title' => __('Background Image', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_image',
							'id' => '',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['bg_image'],
							'description' => ''
						));
						?>	
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'upload',
							'title' => __('Image instead of video', 'tmm_layout_constructor'),
							'shortcode_field' => 'bg_touch_image',
							'id' => '',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['bg_touch_image'],
							'description' => '(for touch devices)'
						));
						?>	
						
						<?php 
							if (empty($tmm_layout_constructor_group[$group_name]['opacity'])) {
								$tmm_layout_constructor_group[$group_name]['opacity'] = 100;
							}
						?>
						
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => __('Opacity', 'tmm_layout_constructor'),
							'shortcode_field' => 'opacity',
							'type' => 'text',
							'description' => '(add color shade over background image) min: 0, max: 100',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['opacity'],
							'id' => 'value_opacity'
						));
						?>		

						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => __('Border Bottom Color', 'tmm_layout_constructor'),
							'shortcode_field' => 'border_bottom_color',
							'type' => 'color',
							'description' => '',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['border_bottom_color'],
							'id' => 'row_border_bottom_color'
						));
						?>	
				
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('Overlay', 'tmm_layout_constructor'),
							'shortcode_field' => 'is_overlay',
							'id' => 'is_overlay',
							'default_value' => @$tmm_layout_constructor_group[$group_name]['is_overlay'],
							'is_checked' => (bool) @$tmm_layout_constructor_group[$group_name]['is_overlay'],
							'description' => __('Set overlay on background image', 'tmm_layout_constructor'),
						));
						?>

					</div>

				</div>
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][bg_image]" data-attr="bg_image" value="<?php echo @$tmm_layout_constructor_group[$group_name]['bg_image'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][bg_touch_image]" data-attr="bg_touch_image" value="<?php echo @$tmm_layout_constructor_group[$group_name]['bg_touch_image'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][bg_color]" data-attr="bg_color" value="<?php echo @$tmm_layout_constructor_group[$group_name]['bg_color'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][border_bottom_color]" data-attr="border_bottom_color" value="<?php echo @$tmm_layout_constructor_group[$group_name]['border_bottom_color'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][is_overlay]" data-attr="is_overlay" value="<?php echo @$tmm_layout_constructor_group[$group_name]['is_overlay'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][is_parallax]" data-attr="is_parallax" value="<?php echo @$tmm_layout_constructor_group[$group_name]['is_parallax'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][is_full_width]" data-attr="is_full_width" value="<?php echo @$tmm_layout_constructor_group[$group_name]['is_full_width'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][bg_attachment]" data-attr="bg_attachment" value="<?php echo @$tmm_layout_constructor_group[$group_name]['bg_attachment'] ?>" />
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][opacity]" data-attr="opacity" value="<?php echo @$tmm_layout_constructor_group[$group_name]['opacity'] ?>" />				
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][padding_top]" data-attr="padding_top" value="<?php echo @$tmm_layout_constructor_group[$group_name]['padding_top'] ?>" />				
				<input type="hidden" name="tmm_layout_constructor_group[<?php echo $group_name ?>][padding_bottom]" data-attr="padding_bottom" value="<?php echo @$tmm_layout_constructor_group[$group_name]['padding_bottom'] ?>" />				
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
						<a href="javascript:tmm_ext_layout_constructor.set_group(__ROW_ID__);void(0);" class="button-secondary button_set_group" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Group", 'tmm_layout_constructor') ?> (<span>0</span>)</a><br />
						<a href="javascript:tmm_ext_layout_constructor.add_column(__ROW_ID__);void(0);" class="button-secondary"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
						<a href="javascript:tmm_ext_layout_constructor.edit_row(__ROW_ID__);void(0);" class="button-secondary" style="display: none;"><?php _e("Edit", 'tmm_layout_constructor') ?></a>
						<a href="javascript:tmm_ext_layout_constructor.delete_row(__ROW_ID__);void(0);" class="button-secondary"><?php _e("Delete", 'tmm_layout_constructor') ?></a>
					</td>
					<td class="col_items">
						<span class="row_columns_container" id="row_columns_container___ROW_ID__"></span>
					</td>
					<td><div class="row-mover"><?php _e("Row Mover", 'tmm_layout_constructor') ?></div></td>
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
			'label' => __("Layout constructor", 'tmm_layout_constructor'),
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
