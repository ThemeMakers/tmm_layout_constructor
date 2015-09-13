<?php
/*
  Plugin Name: ThemeMakers Layout Constructor
  Plugin URI: http://webtemplatemasters.com
  Description: Universal Layout Constructor
  Author: ThemeMakers
  Version: 1.1.3
  Author URI: http://themeforest.net/user/ThemeMakers
 */

//10-06-2014
class TMM_Ext_LayoutConstructor {

	public static function register() {
		load_plugin_textdomain('tmm_layout_constructor', false, dirname(plugin_basename(__FILE__)) . '/languages');

		add_action("admin_enqueue_scripts", array(__CLASS__, 'admin_init'), 1);
		add_action('wp_enqueue_scripts', array(__CLASS__, 'wp_head'), 1);
		add_action('save_post', array(__CLASS__, 'save_post'), 1);
		add_action('wp_ajax_get_lc_editor', array(__CLASS__, 'get_lc_editor'));
		//add_filter('wp_default_editor', create_function('', 'return "tmce";')); //make visual tab always active after page reloads

		if (!class_exists('TMM')) {
			add_filter('the_content', array(__CLASS__, 'the_content'), 999);
		}
	}	
	
	public static function get_lc_editor() {
		$content = $_REQUEST['content'];
		$editor_id = $_REQUEST['editor_id'];
		$settings = array(
			'default_editor'   => 'tinymce',
			'dfw'              => true,
			'drag_drop_upload' => false,
			'editor_height'    => 360,
			'tinymce'          => array(
				'resize'             => false,
				'add_unload_trigger' => false,
			),
		);
		wp_editor($content, $editor_id, $settings);
		exit;
	}
	
	public static function get_application_path() {
		return plugin_dir_path(__FILE__);
	}

	public static function get_application_uri() {
		return plugin_dir_url(__FILE__);
	}
	
	public static function admin_init() {
		wp_enqueue_style('tmm_ext_layout_constructor_grid', self::get_application_uri() . 'css/tmm-lc-grid.css');

		wp_enqueue_style('tmm_ext_layout_constructor', self::get_application_uri() . 'css/admin.css');
		wp_enqueue_script('tmm_ext_layout_constructor', self::get_application_uri() . 'js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
		
		wp_enqueue_style('tmm_ext_layout_constructor_colorpicker', self::get_application_uri() . 'js/colorpicker/colorpicker.css');
		wp_enqueue_script('tmm_ext_layout_constructor_colorpicker', self::get_application_uri() . 'js/colorpicker/colorpicker.js', array('jquery'));

		add_meta_box("tmm_layout_constructor", __("ThemeMakers Layout Constructor", 'tmm_layout_constructor'), array(__CLASS__, 'draw_page_meta_box'), "page", "normal", "high");
		add_meta_box("tmm_layout_constructor", __("ThemeMakers Layout Constructor", 'tmm_layout_constructor'), array(__CLASS__, 'draw_page_meta_box'), "post", "normal", "high");
	
		?>
		<script type="text/javascript">
			var lang_sure_item_delete = "<?php _e("Sure about column deleting?", 'tmm_layout_constructor') ?>";
			var lang_sure_row_delete = "<?php _e("Sure about row deleting?", 'tmm_layout_constructor') ?>";
			var lang_add_media = "<?php _e("Add Media", 'tmm_layout_constructor') ?>";
			var lang_empty = "<?php _e("Empty", 'tmm_layout_constructor') ?>";
			var lang_popup_title = "<?php _e("Column content editor", 'tmm_layout_constructor') ?>";
			var lang_popup_row_title = "<?php _e("Row editor", 'tmm_layout_constructor') ?>";
		</script>
		<?php
	}

	public static function wp_head() {
//		wp_enqueue_style('tmm_ext_layout_constructor_grid', self::get_application_uri() . 'css/tmm-lc-grid.css');
	}

	public static function the_content($content) {
		if (is_single() OR is_page()) {
			global $post;
			$content = $content . self::get_front_html($post->ID);
		}

		return $content;
	}

	public static function draw_front($post_id) {
		$tmm_layout_constructor = get_post_meta($post_id, 'thememakers_layout_constructor', true);
		if (!empty($tmm_layout_constructor)) {
			$data = array();
			$data['tmm_layout_constructor'] = $tmm_layout_constructor;
			$data['tmm_layout_constructor_row'] = get_post_meta($post_id, 'thememakers_layout_constructor_row', true);

			if (!is_array($data['tmm_layout_constructor_row'])) {
				$data['tmm_layout_constructor_row'] = array();
			}

			echo TMM::draw_free_page(self::get_application_path() . '/views/front_output.php', $data);
		}

		echo "";
	}

	public static function draw_page_meta_box() {
		$data = array();
		global $post;
		$data['post_id'] = $post->ID;
		$data['tmm_layout_constructor'] = get_post_meta($post->ID, 'thememakers_layout_constructor', true);
		$data['tmm_layout_constructor_row'] = get_post_meta($post->ID, 'thememakers_layout_constructor_row', true);
		echo self::render_html('views/meta_panel.php', $data);
	}

	//in backend
	public static function draw_column_item($col_data) {
		global $post;
		$col_data['post_id'] = $post->ID;
		echo self::render_html('views/column_item.php', $col_data);
	}

	public static function save_post() {
		if (!empty($_POST)) {
			if (isset($_POST['tmm_layout_constructor'])) {
				global $post;
				unset($_POST['tmm_layout_constructor']['__ROW_ID__']); //unset column html template
				unset($_POST['tmm_layout_constructor_row']['__ROW_ID__']); //unset column html template
				update_post_meta($post->ID, 'thememakers_layout_constructor', $_POST['tmm_layout_constructor']);
				update_post_meta($post->ID, 'thememakers_layout_constructor_row', $_POST['tmm_layout_constructor_row']);
			}
		}
	}

	public static function get_front_html($post_id) {
		$tmm_layout_constructor = get_post_meta($post_id, 'thememakers_layout_constructor', true);
		if (!empty($tmm_layout_constructor)) {
			$data = array();
			$data['tmm_layout_constructor'] = $tmm_layout_constructor;
			$data['tmm_layout_constructor_row'] = get_post_meta($post_id, 'thememakers_layout_constructor_row', true);

			if (!is_array($data['tmm_layout_constructor_row'])) {
				$data['tmm_layout_constructor_row'] = array();
			}

			return self::render_html('views/front_output.php', $data);
		}

		return "";
	}

	public static function get_row_bg($tmm_layout_constructor_row, $row) {
		$style = array('style_border' => '', 'style_custom' => '', 'bg_type' => 'default');
		if (isset($tmm_layout_constructor_row[$row])) {
			$data = $tmm_layout_constructor_row[$row];
			//***
			$border_css_data = "";
			if (isset($data['border_color'])) {
				if ($data['border_width'] != 0) {
					$style['style_border'] = 'border-top:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';' . 'border-bottom:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';';
				}
			}

			//***
			if (isset($data['bg_type'])) {
				switch ($data['bg_type']) {
					case 'custom':
						$style['style_custom_color'] = 'style="background-color:' . $data['bg_color'] . ' !important;' . $style['style_border'] . '"';
						$style['style_custom_image'] = 'style="background-image: url(' . $data['bg_image'] . ');"';
						$style['bg_type'] = 'custom';
						break;
					default:
						break;
				}
			}
		}

		return $style;
	}

	public static function render_html($pagepath, $data = array()) {
		$pagepath = self::get_application_path() . '/' . $pagepath;
		@extract($data);
		ob_start();
		include($pagepath);
		return ob_get_clean();
	}

	public static function draw_html_option($data) {
		switch ($data['type']) {
			case 'textarea':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<textarea id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer data-area" data-shortcode-field="<?php echo $data['shortcode_field'] ?>"><?php echo $data['default_value'] ?></textarea>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'select':
				if (!isset($data['display'])) {
					$data['display'] = 1;
				}
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<?php if (!empty($data['options'])): ?>
					<select <?php if ($data['display'] == 0): ?> style="display: none;"<?php endif; ?> class="js_shortcode_template_changer data-select <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>">
						<?php foreach ($data['options'] as $key => $text) : ?>
							<option <?php if ($data['default_value'] == $key) echo 'selected' ?> value="<?php echo $key ?>"><?php echo $text ?></option>
						<?php endforeach; ?>

					</select>
				<?php endif; ?>
				<?php
				break;
			case 'text':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>" />
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'color':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" value="<?php echo $data['default_value'] ?>" class="bg_hex_color text small js_shortcode_template_changer" id="<?php echo $data['id'] ?>">
				<div style="background-color: <?php echo $data['default_value'] ?>" class="bgpicker"></div>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'upload':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" id="<?php echo $data['id'] ?>" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input data-upload <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
				<a title="" class="tmm_button_upload button-primary" href="#">
					<?php _e('Upload', 'tmm_layout_constructor'); ?>
				</a>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'checkbox':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<div class="radio-holder">
					<input <?php if ($data['is_checked']): ?>checked=""<?php endif; ?> type="checkbox" value="<?php if ($data['is_checked']): ?>1<?php else: ?>0<?php endif; ?>" id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="<?php echo $data['shortcode_field'] ?>">
					<label for="<?php echo $data['id'] ?>"><span></span><i class="description"><?php echo $data['description'] ?></i></label>
					<span class="preset_description"><?php echo $data['description'] ?></span>
				</div><!--/ .radio-holder-->
				<?php
				break;
			case 'radio':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<div class="radio-holder">
					<input <?php if ($data['values'][0]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][0]['id'] ?>" value="<?php echo $data['values'][0]['value'] ?>" class="js_shortcode_radio_self_update" />
					<label for="<?php echo $data['values'][0]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][0]['title'] ?></label>

					<input <?php if ($data['values'][1]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][1]['id'] ?>" value="<?php echo $data['values'][1]['value'] ?>" class="js_shortcode_radio_self_update" />
					<label for="<?php echo $data['values'][1]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][1]['title'] ?></label>

					<input type="hidden" id="<?php echo @$data['hidden_id'] ?>" value="<?php echo $data['value'] ?>" class="js_shortcode_template_changer" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
				</div><!--/ .radio-holder-->
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
		}
	}

}

//***
add_action('init', array('TMM_Ext_LayoutConstructor', 'register'), 1);

/* fix WPML plugin notices, which appears on plugins init */
$wp_query = new WP_Query();// call to is_feed() trigger notice because $wp_query not exist
//if(!defined('ICL_DISABLE_CACHE')){ define('ICL_DISABLE_CACHE', false); } // the constant ICL_DISABLE_CACHE is called in sitepress class before it has been defined