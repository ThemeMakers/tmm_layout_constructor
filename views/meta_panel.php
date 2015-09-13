<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="tmm_meta_saving" value="1" />
<a href="#add_row" class="tmm-lc-add-row button button-primary button-large"><?php _e("Add New Row", 'tmm_layout_constructor') ?></a><br />

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
							<div class="tmm-lc-wrapper">
                                <a class="tmm-lc-add-column button" data-row-id="<?php echo $row ?>"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
                                <a class="tmm-lc-edit-row button" data-row-id="<?php echo $row ?>"><?php _e("Edit", 'tmm_layout_constructor') ?></a>
                                <a class="tmm-lc-delete-row button" data-row-id="<?php echo $row ?>"><?php _e("Delete", 'tmm_layout_constructor') ?></a>
                            </div>
						</td>
						<td class="col_items">
							<span class="row_columns_container row-no-padding" id="row_columns_container_<?php echo $row ?>">
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
											'title' => $column['title']
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

				<input type="hidden" id="row_padding_top_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['padding_top'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][padding_top]" />
				<input type="hidden" id="row_padding_bottom_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['padding_bottom'] : 0) ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][padding_bottom]" />

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
			'value' => '1/4',
			'content' => '',
			'title' => ''
		);
		TMM_Ext_LayoutConstructor::draw_column_item($col_data);
		?>
	</div>
	<div id="layout_constructor_column_row">
		<li id="layout_constructor_row___ROW_ID__" class="layout_constructor_item">
			<table>
				<tr>
					<td>
						 <div class="tmm-lc-wrapper">
                            <a class="tmm-lc-add-column button" data-row-id="__ROW_ID__"><?php _e("Add Column", 'tmm_layout_constructor') ?></a><br />
                            <a class="tmm-lc-edit-row button" data-row-id="__ROW_ID__"><?php _e("Edit", 'tmm_layout_constructor') ?></a>
                            <a class="tmm-lc-delete-row button" data-row-id="__ROW_ID__"><?php _e("Delete", 'tmm_layout_constructor') ?></a>
                        </div>
					</td>
					<td class="col_items">
						<span class="row_columns_container row-no-padding" id="row_columns_container___ROW_ID__"></span>
					</td>
					<td><div class="row-mover"><?php _e("Row Mover", 'tmm_layout_constructor') ?></div></td>
				</tr>
			</table>
			
			<input type="hidden" id="row_padding_top___ROW_ID__" value="0" name="tmm_layout_constructor_row[__ROW_ID__][padding_top]" />
			<input type="hidden" id="row_padding_bottom___ROW_ID__" value="15" name="tmm_layout_constructor_row[__ROW_ID__][padding_bottom]" />
		</li>
	</div>


	<!-------------------------- DIALOGs TEMPLATES ----------------------------------------- -->


	<div style="display: none;">
		<div id="layout_constructor_layout_dialog"></div>
		<div id="layout_constructor_row_dialog">
			<div class="tmm_shortcode_template clearfix">
				<div class="one-half-grid">
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'title' => __('Padding top', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_padding_top',
						'type' => 'text',
						'description' => __('Default Value 0px', 'tmm_layout_constructor'),
						'default_value' => 0,
						'id' => 'row_padding_top'
					));
					?>
				</div>

				<div class="one-half-grid">
					<?php
					TMM_Ext_LayoutConstructor::draw_html_option(array(
						'title' => __('Padding bottom', 'tmm_layout_constructor'),
						'shortcode_field' => 'row_padding_bottom',
						'type' => 'text',
						'description' => __('Default Value 15px', 'tmm_layout_constructor'),
						'default_value' => 15,
						'id' => 'row_padding_bottom'
					));
					?>
				</div>
				
									
					</div>

			<div class="clear"></div>
					</div>
				</div>

			</div>

