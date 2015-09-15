<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="page-element <?php echo $css_class ?>" id="item_<?php echo $uniqid ?>">
	<div class="page-element-item">
		
		<div class="item-bar-left">
			<ul class="layout_constructor_column_sizes_list" style="display: none;" data-item-id="<?php echo $uniqid ?>"></ul>
			<div class="change-element-size-temp">
				<a href="#" class="add-element-size-plus" data-item-id="<?php echo $uniqid ?>"></a>
				<a href="#" class="add-element-size-minus" data-item-id="<?php echo $uniqid ?>"></a>
			</div>					
		</div>

		<span class="page-element-item-text"><?php echo (empty($title) ? __("Empty", 'tmm_layout_constructor') : $title) ?></span>

		<input type="hidden" class="js_title" value="<?php echo $title ?>" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][title]" />
		<input type="hidden" class="js_css_class" value="<?php echo $css_class ?>" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][css_class]" />
		<input type="hidden" class="js_front_css_class" value="<?php echo $front_css_class ?>" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][front_css_class]" />
		<input type="hidden" class="js_value" value="<?php echo $value ?>" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][value]" />
		<input type="hidden" class="js_effect" value="<?php echo @$effect ?>" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][effect]" />

		<textarea style="display: none;" class="js_content" name="tmm_layout_constructor[<?php echo $row ?>][<?php echo $uniqid ?>][content]"><?php echo $content ?></textarea>
		
		<div class="item-bar-right">
			<div class="element-size-text"><?php echo $value ?></div>
			<div class="change-element-property">
				<a title="<?php _e("Edit", 'tmm_layout_constructor') ?>" class="edit-element" data-item-id="<?php echo $uniqid ?>"></a>
				<a title="<?php _e("Delete", 'tmm_layout_constructor') ?>" class="delete-element" data-item-id="<?php echo $uniqid ?>"></a>
			</div>
		</div>


	</div>
</div>
