<?php
/*
  Plugin Name: ThemeMakers Layout Constructor
  Plugin URI: http://webtemplatemasters.com
  Description: Universal Layout Constructor (Accio)
  Author: ThemeMakers
  Version: 1.0.4
  Author URI: http://themeforest.net/user/ThemeMakers
 */

class TMM_Ext_LayoutConstructor {

	public static $grid_class = array();

	public static function register() {
		add_action('admin_head', array(__CLASS__, 'admin_head'), 1);
		add_action('save_post', array(__CLASS__, 'save_post'), 1);
		add_action('wp_ajax_get_lc_editor', array(__CLASS__, 'get_lc_editor'));
	}

	public static function get_application_path() {
		return plugin_dir_path(__FILE__);
	}

	public static function get_application_uri() {
		return plugin_dir_url(__FILE__);
	}

	public static function admin_init() {
		$is_tmm_theme_options = FALSE;
		if (isset($_GET['page'])) {
			if ($_GET['page'] == 'tmm_theme_options') {
				$is_tmm_theme_options = TRUE;
			}
		}

		if ($is_tmm_theme_options === FALSE) {
			wp_enqueue_style('tmm_ext_layout_constructor', self::get_application_uri() . 'css/admin.css');
			wp_enqueue_script('tmm_ext_layout_constructor', self::get_application_uri() . 'js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
			wp_enqueue_style('tmm_ext_layout_constructor_popup3', self::get_application_uri() . 'js/tmm_popup/styles.css');
			wp_enqueue_script('tmm_ext_layout_constructor_popup3', self::get_application_uri() . 'js/tmm_popup/tmm_advanced_wp_popup.js', array('jquery'));
			wp_enqueue_style('tmm_ext_layout_constructor_colorpicker', self::get_application_uri() . 'js/colorpicker/colorpicker.css');
			wp_enqueue_script('tmm_ext_layout_constructor_colorpicker', self::get_application_uri() . 'js/colorpicker/colorpicker.js', array('jquery'));
		}
		
		self::$grid_class = array(
			'' => esc_html__("No", 'tmm_layout_constructor'),
			'col-sm-3' => esc_attr("col-sm-3"),
			'col-sm-4' => esc_attr("col-sm-4"),
			'col-sm-5' => esc_attr("col-sm-5"),
			'col-sm-6' => esc_attr("col-sm-6"),
			'col-sm-7' => esc_attr("col-sm-7"),
			'col-sm-8' => esc_attr("col-sm-8"),
			'col-sm-9' => esc_attr("col-sm-9"),
			'col-sm-10' => esc_attr("col-sm-10"),
			'col-sm-11' => esc_attr("col-sm-11"),
			'col-sm-12' => esc_attr("col-sm-12"),
		);

		if ( class_exists( 'Classic_Editor' ) ) {
			add_meta_box("tmm_layout_constructor", esc_html__("ThemeMakers Layout Constructor", 'tmm_layout_constructor'), array(__CLASS__, 'draw_page_meta_box'), "page", "normal", "high");
			add_meta_box("tmm_layout_constructor", esc_html__("ThemeMakers Layout Constructor", 'tmm_layout_constructor'), array(__CLASS__, 'draw_page_meta_box'), "post", "normal", "high");

			if (class_exists('TMM_Portfolio')) {
				add_meta_box("tmm_layout_constructor", esc_html__("ThemeMakers Layout Constructor", 'tmm_layout_constructor'), array(__CLASS__, 'draw_page_meta_box'), TMM_Portfolio::$slug, "normal", "high");
			}
		}

	}

	public static function wp_head() {
		if (!class_exists('TMM')) {//if not TMM theme is activated
			wp_enqueue_style('tmm_ext_layout_constructor', self::get_application_uri() . 'css/front.css');
		}
	}

	public static function admin_head() {
		?>
		<script type="text/javascript">
			var lang_sure_item_delete = "<?php esc_html_e("Sure about column deleting?", 'tmm_layout_constructor') ?>";
			var lang_sure_row_delete = "<?php esc_html_e("Sure about row deleting?", 'tmm_layout_constructor') ?>";
			var lang_add_media = "<?php esc_html_e("Add Media", 'tmm_layout_constructor') ?>";
			var lang_empty = "<?php esc_html_e("Empty", 'tmm_layout_constructor') ?>";
			var lang_popup_title = "<?php esc_html_e("Column content editor", 'tmm_layout_constructor') ?>";
			var lang_popup_row_title = "<?php esc_html_e("Row editor", 'tmm_layout_constructor') ?>";
		</script>
		<?php
	}

	
	public static function draw_front($post_id, $is_onepage = FALSE) {
		$tmm_layout_constructor = get_post_meta($post_id, 'thememakers_layout_constructor', true);
		
		if (!empty($tmm_layout_constructor)) {
			$data = array();
			$data['tmm_layout_constructor'] = $tmm_layout_constructor;
			$data['tmm_layout_constructor_row'] = get_post_meta($post_id, 'thememakers_layout_constructor_row', true);
			$data['tmm_layout_constructor_group'] = get_post_meta($post_id, 'tmm_layout_constructor_group', true);

			if (!is_array($data['tmm_layout_constructor_row'])) {
				$data['tmm_layout_constructor_row'] = array();
			}
			
			if (!is_array($data['tmm_layout_constructor_group'])) {
				$data['tmm_layout_constructor_group'] = array();
			}

			if ( class_exists( 'TMM_Theme_Features' ) ) {
				echo TMM::draw_free_page(self::get_application_path() . '/views/front_output.php', $data);
			}

		}

	}

	public static function draw_page_meta_box() {
		$data = array();
		global $post;
		$data['post_id'] = $post->ID;
		$data['tmm_layout_constructor'] = get_post_meta($post->ID, 'thememakers_layout_constructor', true);
		$data['tmm_layout_constructor_row'] = get_post_meta($post->ID, 'thememakers_layout_constructor_row', true);
		$tmm_layout_constructor_group = get_post_meta($post->ID, 'tmm_layout_constructor_group', true);
		if(empty($tmm_layout_constructor_group) OR !is_array($tmm_layout_constructor_group)){
			$tmm_layout_constructor_group=array();
		}
		$data['tmm_layout_constructor_group']=$tmm_layout_constructor_group;
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
				if(isset($_POST['tmm_layout_constructor'])){
					update_post_meta($post->ID, 'thememakers_layout_constructor', $_POST['tmm_layout_constructor']);
				}
				if(isset($_POST['tmm_layout_constructor_row'])){
					update_post_meta($post->ID, 'thememakers_layout_constructor_row', $_POST['tmm_layout_constructor_row']);
				}
				if(isset($_POST['tmm_layout_constructor_group'])){
					update_post_meta($post->ID, 'tmm_layout_constructor_group', $_POST['tmm_layout_constructor_group']);
				}
			}
		}
	}

	
	public static function get_row_bg($tmm_layout_constructor_row, $row) {
		$style = array('style_border' => '', 'style_custom' => '', 'bg_type' => 'default');
		if (isset($tmm_layout_constructor_row[$row])) {
			$data = $tmm_layout_constructor_row[$row];
			$border_css_data = "";
			if (isset($data['border_color'])) {
				if ($data['border_width'] != 0) {
					$style['style_border'] = 'border-top:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';' . 'border-bottom:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';';
				}
			}

			if (isset($data['bg_type'])) {
				switch ($data['bg_type']) {
					case 'custom':
						$style['style_custom_color'] = 'style="background-color:' . $data['bg_color'] . ' ;' . $style['style_border'] . '"';
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
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<textarea id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>" class="js_shortcode_template_changer data-area" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>"><?php echo esc_attr( $data['default_value'] ) ?></textarea>
					<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
				</div><!--/ .field-group-->
				<?php
				break;
			case 'select':
				if (!isset($data['display'])) {
					$data['display'] = 1;
				}
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<?php if (!empty($data['options'])): ?>
						<select <?php if ($data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="js_shortcode_template_changer data-select <?php echo esc_attr( $data['css_classes'] ) ?>" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>">
							<?php foreach ($data['options'] as $key => $text) : ?>
								<option <?php if ($data['default_value'] == $key) echo 'selected' ?> value="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $text ) ?></option>
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
				</div><!--/ .field-group-->
				<?php
				break;
			case 'text':
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<input type="text" value="<?php echo esc_attr( $data['default_value'] ) ?>" class="js_shortcode_template_changer data-input" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>" />
					<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
				</div>
				<?php
				break;
			case 'color':
			    $uid = uniqid();
				?>
				<div class="field-group">
					<div class="list-item-color">
						<?php if (!empty($data['title'])): ?>
							<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
						<?php endif; ?>

						<input type="text" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>" value="<?php echo esc_attr( $data['default_value'] ) ?>" class="bg_hex_color text small js_shortcode_template_changer" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>">
						<div style="background-color: <?php echo $data['default_value'] ?>" class="bgpicker"></div>
						<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
					</div>
				</div>
				<?php
				break;
			case 'upload':
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<input type="text" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>" value="<?php echo esc_attr( $data['default_value'] ) ?>" class="js_shortcode_template_changer data-input data-upload <?php echo esc_attr( $data['css_classes'] ) ?>" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>" />
					<a title="" class="tmm_button_upload button-primary" href="#">
						<?php esc_html_e('Upload', 'tmm_accio_shortcodes'); ?>
					</a>
					<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
				</div>
				<?php
				break;
			case 'checkbox':
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<div class="radio-holder">
						<input <?php if ($data['is_checked']): ?>checked=""<?php endif; ?> type="checkbox" value="<?php if ($data['is_checked']): ?>1<?php else: ?>0<?php endif; ?>" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>">
						<label for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><span></span><i class="description"><?php echo esc_html( $data['description'] ) ?></i></label>
						<span class="preset_description"><?php // echo $data['description'] ?></span>
					</div><!--/ .radio-holder-->
				</div>
				<?php
				break;
			case 'radio':
                $uid = uniqid();
				?>
				<div class="field-group">
					<?php if (!empty($data['title'])): ?>
						<h4 class="label" for="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>"><?php echo esc_html( $data['title'] ) ?></h4>
					<?php endif; ?>

					<div class="radio-holder">
						<input <?php if ($data['values'][0]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo esc_attr( $data['name'] ) ?>" id="<?php echo esc_attr( $data['values'][0]['id'] . '_' . $uid ) ?>" value="<?php echo esc_attr( $data['values'][0]['value'] ) ?>" class="js_shortcode_radio_self_update" />
						<label for="<?php echo esc_attr( $data['values'][0]['id'] . '_' . $uid ) ?>" class="label-form"><span></span><?php echo esc_attr( $data['values'][0]['title'] ) ?></label>

						<input <?php if ($data['values'][1]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo esc_attr( $data['name'] ) ?>" id="<?php echo esc_attr( $data['values'][1]['id'] . '_' . $uid ) ?>" value="<?php echo esc_attr( $data['values'][1]['value'] ) ?>" class="js_shortcode_radio_self_update" />
						<label for="<?php echo esc_attr( $data['values'][1]['id'] . '_' . $uid ) ?>" class="label-form"><span></span><?php echo esc_attr( $data['values'][1]['title'] ) ?></label>

						<input type="hidden" id="<?php echo esc_attr( $data['hidden_id'] ) ?>" value="<?php echo esc_attr( $data['value'] ) ?>" class="js_shortcode_template_changer" data-shortcode-field="<?php echo esc_attr( $data['shortcode_field'] ) ?>" />
					</div><!--/ .radio-holder-->
					<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
				</div>
				<?php
				break;
			case 'slider':
                $uid = uniqid();
				?>
				<div class="field-group">
					<input data-default-value="<?php echo esc_attr( $data['default_value'] ) ?>" type="text" id="<?php echo esc_attr( $data['id'] . '_' . $uid ) ?>" name="<?php echo esc_attr( $data['name'] ) ?>" value="<?php echo esc_attr( $data['value'] ) ?>" data-min-value="<?php echo esc_attr( $data['min'] ) ?>" data-max-value="<?php echo esc_attr( $data['max'] ) ?>" class="ui_slider_item" />
					<span class="preset_description"><?php echo esc_html( $data['description'] ) ?></span>
				</div>
				<?php
				break;
		}
	}
	
	public static function get_lc_editor() {
		$content = $_REQUEST['content'];
		$editor_id = $_REQUEST['editor_id'];
		$settings = array(
			'default_editor'   => 'tinymce',
			'dfw'              => true,
			'drag_drop_upload' => false,
			'editor_height'    => 600,
			'tinymce'          => array(
				'resize'             => false,
				'add_unload_trigger' => false,
			),
		);
		wp_editor($content, $editor_id, $settings);
		exit;
	}

}

//***
add_action('init', array('TMM_Ext_LayoutConstructor', 'register'), 1);
add_action('wp_enqueue_scripts', array('TMM_Ext_LayoutConstructor', 'wp_head'), 1);
add_action("admin_enqueue_scripts", array('TMM_Ext_LayoutConstructor', 'admin_init'), 1);

/**
 * Load plugin textdomain.
 */
function tmm_lc_load_textdomain() {
	load_plugin_textdomain( 'tmm_layout_constructor', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'tmm_lc_load_textdomain' );