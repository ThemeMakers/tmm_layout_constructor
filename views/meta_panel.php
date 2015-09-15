<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="tmm_meta_saving" value="1" />
<a href="javascript:tmm_ext_layout_constructor.add_row(); void(0);" class="button button-primary button-large"><?php _e("Add New Row", 'tmm_layout_constructor') ?></a><br />

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
							<a href="javascript:tmm_ext_layout_constructor.add_column(<?php echo $row ?>);void(0);" class="button" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
							<a href="javascript:tmm_ext_layout_constructor.edit_row(<?php echo $row ?>);void(0);" class="button" style="width: 45px;"><?php _e("Edit", 'tmm_layout_constructor') ?></a><a href="javascript:tmm_ext_layout_constructor.delete_row(<?php echo $row ?>);void(0);" class="button" style="width: 60px;margin:0 0 0 5px;"><?php _e("Delete", 'tmm_layout_constructor') ?></a>
						</td>
						<td class="col_items">
							<span class="row_columns_container" id="row_columns_container_<?php echo $row ?>">
								<?php if (!empty($row_data)): ?>
									<?php foreach ($row_data as $uniqid => $column) : ?>
										<?php
										if ($uniqid == 'row_data') {
											continue;
										}
										?>
										<?php
										$col_data = array(
											'row' => $row,
											'uniqid' => $uniqid,
											'css_class' => $column['css_class'],
											'front_css_class' => $column['front_css_class'],
											'value' => $column['value'],
											'content' => $column['content'],
											'title' => $column['title'],
											'effect' => @$column['effect'],
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

				<input type="hidden" id="row_full_width_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['full_width'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][full_width]" />
				<input type="hidden" id="row_bg_type_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_type'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_type]" />
				<input type="hidden" id="row_bg_data_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_data'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_data]" />
				<input type="hidden" id="row_bg_custom_color_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_color]" />
				<input type="hidden" id="row_bg_custom_image_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_image'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_image]" />
				<input type="hidden" id="row_bg_custom_opacity_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_opacity'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_opacity]" />
				<input type="hidden" id="row_bg_is_cover_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_cover'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_cover]" />
				<input type="hidden" id="row_bg_attachment_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_attachment'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_attachment]" />
				<input type="hidden" id="row_border_type_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_type'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_type]" />
				<input type="hidden" id="row_border_width_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_width'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_width]" />
				<input type="hidden" id="row_border_color_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_color]" />
				<input type="hidden" id="row_padding_top_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['padding_top'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][padding_top]" />
				<input type="hidden" id="row_padding_bottom_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['padding_bottom'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][padding_bottom]" />

			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>


<div style="display: none;">
	
	<div id="layout_constructor_grid_class">
		<?php
		$effects = array(
			'' => __("No effects", 'tmm_layout_constructor'),
			'elementFade' => __('Element Fade', 'tmm_layout_constructor'),
			'opacityEffect' => __('Opacity', 'tmm_layout_constructor'),
			'scaleEffect' => __('Scale', 'tmm_layout_constructor'),
			'rotateEffect' => __('Rotate', 'tmm_layout_constructor'),
			'slideRightEffect' => __('Slide Right', 'tmm_layout_constructor'),
			'slideLeftEffect' => __('Slide Left', 'tmm_layout_constructor'),
			'slideDownEffect' => __('Slide Down', 'tmm_layout_constructor'),
			'slideUpEffect' => __('Slide Up', 'tmm_layout_constructor'),
		);

		TMM_Ext_LayoutConstructor::draw_html_option(array(
			'type' => 'select',
			'title' => '',
			'label' => __("Layout constructor", 'tmm_layout_constructor'),
			'shortcode_field' => 'grid_selector',
			'id' => '',
			'options' => $effects,
			'default_value' => '',
			'description' => '',
			'css_classes' => 'grid_selector'
		));
		?>
	</div>
	
	<div id="layout_constructor_column_item">
		<?php
		$col_data = array(
			'row' => '__ROW_ID__',
			'uniqid' => '__UNIQUE_ID__',
			'css_class' => 'element1-4',
			'front_css_class' => 'four columns',
			'value' => '1/4',
			'content' => '',
			'title' => '',
			'effect' => '',
		);
		TMM_Ext_LayoutConstructor::draw_column_item($col_data);
		?>
	</div>
	<div id="layout_constructor_column_row">
		<li id="layout_constructor_row___ROW_ID__" class="layout_constructor_item">
			<table>
				<tr>
					<td>
						<a href="javascript:tmm_ext_layout_constructor.add_column(__ROW_ID__);void(0);" class="button" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
						<a href="javascript:tmm_ext_layout_constructor.edit_row(__ROW_ID__);void(0);" class="button" style="width: 45px;"><?php _e("Edit", 'tmm_layout_constructor') ?></a><a href="javascript:tmm_ext_layout_constructor.delete_row(__ROW_ID__);void(0);" class="button" style="width: 60px;margin:0 0 0 5px;"><?php _e("Delete", 'tmm_layout_constructor') ?></a>
					</td>
					<td class="col_items">
						<span class="row_columns_container" id="row_columns_container___ROW_ID__"></span>
					</td>
					<td><div class="row-mover"><?php _e("Row Mover", 'tmm_layout_constructor') ?></div></td>
				</tr>
			</table>
			<input type="hidden" id="row_full_width___ROW_ID__" value="0" name="tmm_layout_constructor_row[__ROW_ID__][full_width]" />
			<input type="hidden" id="row_bg_type___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_type]" />
			<input type="hidden" id="row_bg_data___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_data]" />
			<input type="hidden" id="row_bg_custom_color___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_color]" />
			<input type="hidden" id="row_bg_custom_image___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_image]" />
			<input type="hidden" id="row_bg_custom_opacity___ROW_ID__" value="30" name="tmm_layout_constructor_row[__ROW_ID__][bg_opacity]" />
			<input type="hidden" id="row_bg_is_cover___ROW_ID__" value="0" name="tmm_layout_constructor_row[__ROW_ID__][bg_cover]" />
			<input type="hidden" id="row_bg_attachment___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_attachment]" />
			<input type="hidden" id="row_border_type___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_type]" />
			<input type="hidden" id="row_border_width___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_width]" />
			<input type="hidden" id="row_border_color___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_color]" />
			<input type="hidden" id="row_padding_top___ROW_ID__" value="50" name="tmm_layout_constructor_row[__ROW_ID__][padding_top]" />
			<input type="hidden" id="row_padding_bottom___ROW_ID__" value="50" name="tmm_layout_constructor_row[__ROW_ID__][padding_bottom]" />
		</li>
	</div>

	<div id="layout_constructor_effects">
		<?php
		TMM_Ext_LayoutConstructor::draw_html_option(array(
			'type' => 'select',
			'title' => '',
			'label' => __("Layout constructor", 'tmm_layout_constructor'),
			'shortcode_field' => 'effects_selector',
			'id' => '',
			'options' => TMM_Ext_LayoutConstructor::$effects,
			'default_value' => '',
			'description' => '',
			'css_classes' => 'effects_selector'
		));
		?>
	</div>

	<!-------------------------- DIALOGs TEMPLATES ----------------------------------------- -->


	<div style="display: none;">
		<div id="layout_constructor_layout_dialog"></div>
		<div id="layout_constructor_row_dialog">
			
			<div class="tmm_shortcode_template clearfix">
				
				<div class="one-half-grid">
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'type' => 'select',
						'title' => __('Row Full Width', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_full_width',
						'id' => 'row_full_width',
						'options' => array(
							0 => __('No', 'tmm_layout_constructor'),
							1 => __('Yes', 'tmm_layout_constructor')
						),
						'default_value' => 0,
						'description' => ''
					));
					?>
					
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'type' => 'select',
						'title' => __('Row Background Type', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_background_type',
						'id' => 'row_background_type',
						'options' => array(
							'default' => __('Default Theme Color', 'tmm_layout_constructor'),
							'custom' => __('Custom', 'tmm_layout_constructor'),
						),
						'default_value' => 'default',
						'description' => ''
					));
					?>
					
					<div id="row_background_color_box" style="display: none;">
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => __('Background Color', 'tmm_layout_constructor'),
							'shortcode_field' => 'row_background_color',
							'type' => 'color',
							'description' => '',
							'default_value' => '',
							'id' => 'row_background_color'
						));
						?>
					</div>

					<div id="row_background_image_box" style="display: none;">
						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'upload',
							'title' => __('Background Image', 'tmm_layout_constructor'),
							'shortcode_field' => 'row_background_image',
							'id' => 'row_background_image',
							'default_value' => '',
							'description' => ''
						));
						?>

						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'select',
							'title' => __('Background Attachment', 'tmm_layout_constructor'),
							'shortcode_field' => 'row_bg_attachment',
							'id' => 'row_bg_attachment',
							'options' => array(
								'scroll' => 'scroll',
								'fixed' => 'fixed'
							),
							'default_value' => 'scroll',
							'description' => ''
						));
						?>

						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'type' => 'checkbox',
							'title' => __('', 'tmm_layout_constructor'),
							'shortcode_field' => 'row_background_is_cover',
							'id' => 'row_background_is_cover',
							'default_value' => 0,
							'is_checked'=>false,
							'description' => __('Background Size no is cover', 'tmm_layout_constructor'),
						));
						?>

					</div>
					
					<div id="row_background_opacity_box" style="display: none;">					

						<?php
						TMM_Ext_LayoutConstructor::draw_html_option(array(
							'title' => __('Opacity', 'tmm_layout_constructor'),
							'shortcode_field' => 'row_background_opacity',
							'type' => 'text',
							'description' => 'min:0, max:100',
							'default_value' => 100,
							'id' => 'row_background_opacity'
						));
						?>

					</div>		
					
				</div>
				
				<div class="one-half-grid">
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'type' => 'select',
						'title' => __('Border Width', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_border_width',
						'id' => 'row_border_width',
						'options' => array(
							0 => 0,
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
						),
						'default_value' => 0,
						'description' => ''
					));
					?>
					
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'type' => 'select',
						'title' => __('Border type', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_border_type',
						'id' => 'row_border_type',
						'options' => array(
							'solid' => __('Solid', 'tmm_layout_constructor'),
							'dashed' => __('Dashed', 'tmm_layout_constructor'),
							'dotted' => __('Dotted', 'tmm_layout_constructor'),
						),
						'default_value' => 'solid',
						'description' => ''
					));
					?>
					
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'title' => __('Border Color', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_border_color',
						'type' => 'color',
						'description' => '',
						'default_value' => '',
						'id' => 'row_border_color'
					));
					?>
				</div>
				
				<div class="one-half-grid">
					  &nbsp;
					
				</div>

				<div class="one-half-grid">
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'title' => __('Padding top', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_padding_top',
						'type' => 'text',
						'description' => 'Default Value 50px',
						'default_value' => 50,
						'id' => 'row_padding_top'
					));
					?>
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'title' => __('Padding bottom', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_padding_bottom',
						'type' => 'text',
						'description' => 'Default Value 50px',
						'default_value' => 50,
						'id' => 'row_padding_bottom'
					));
					?>
				</div>

			</div>

		</div>
	</div>

</div>