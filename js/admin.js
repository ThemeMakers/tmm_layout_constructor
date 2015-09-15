var TMM_APP_CONTENT_CONSTRUCTOR = function() {
	var self = {
		columns: null,
		active_editor_id: null,
		init: function() {
			jQuery.fn.life = function(types, data, fn) {
				"use strict";
				jQuery(this.context).on(types, this.selector, data, fn);
				return this;
			};
			//***
			self.columns = [
				{
					'value': '1/4',
					'name': 'One fourth',
					'css_class': 'element1-4',
					'front_css_class': 'four columns'
				},
				{
					'value': '1/3',
					'name': 'One third',
					'css_class': 'element1-3',
					'front_css_class': 'one-third column'
				},
				{
					'value': '1/2',
					'name': 'One half',
					'css_class': 'element1-2',
					'front_css_class': 'eight columns'
				},
				{
					'value': '2/3',
					'name': 'Two thirds',
					'css_class': 'element2-3',
					'front_css_class': 'two-thirds column'
				},
				{
					'value': '3/4',
					'name': 'Three Fourth',
					'css_class': 'element3-4',
					'front_css_class': 'twelve columns'
				},
				{
					'value': '1',
					'name': 'Full width',
					'css_class': 'element1-1',
					'front_css_class': ''
				}
			];

			jQuery('#layout_constructor_items').sortable();
			jQuery('.row_columns_container').sortable();

			//create hidden popup area wor changing column width
			jQuery.each(self.columns, function(index, column) {

				var link = jQuery('<a>')
						.attr('href', '#')
						.attr('data-value', column.value)
						.attr('data-css-class', column.css_class)
						.attr('data-front-css-class', column.front_css_class)
						.addClass('change_column_size')
						.html(column.name);

				jQuery('<li class="css-class-' + column.css_class + '">')
						.append(link)
						.appendTo('.layout_constructor_column_sizes_list');

			});


			//*****

			jQuery("#layout_constructor_items .delete-element").life('click', function() {
				if (jQuery(".layout_constructor_layout_dialog_desc").length > 0) {
					return;
				}

				if (confirm(lang_sure_item_delete)) {
					jQuery("#item_" + jQuery(this).data('item-id')).remove();
				}

				return false;
			});


			jQuery("#layout_constructor_items .edit-element").life('click', function() {

                        if (jQuery(".layout_constructor_layout_dialog_desc").length > 0) {
                            return;
                        }

                        var default_id = 'content',
                                ed = tinymce.get(default_id),
                                wrap_id = 'wp-' + default_id + '-wrap',
                                DOM = tinymce.DOM;

                        if (!ed) {
                            tinymce.init(tinyMCEPreInit.mceInit[default_id]);

                            DOM.removeClass(wrap_id, 'html-active');
                            DOM.addClass(wrap_id, 'tmce-active');
                            setUserSetting('editor', 'tmce');
                        }


                        var item_id = jQuery(this).data('item-id'),
                                title = jQuery("#item_" + item_id).find('.page-element-item-text').html(),
                                text = jQuery("#item_" + item_id).find('.js_content').text(),
                                data = {
                                    action: "get_lc_editor",
                                    content: '',
                                    editor_id: 'layout_constructor_editor'
                                },
                        popup_params = {};

                        if (title === lang_empty) {
                            title = "";
                        }

                        popup_params = {
                            content: '',
                            title: lang_popup_title,
                            overlay: true,
                            width: 800,
                            height: 600,
                            open: function() {
                                self.active_editor_id = 'layout_constructor_editor';
                                /* setup tinyMCE */
                                tinyMCE.execCommand('mceAddEditor', false, self.active_editor_id);
                                tinyMCE.execCommand('mceSetContent', false, text);
                                /* setup Editor Text tab buttons */
                                quicktags(self.active_editor_id);
                                QTags._buttonsInit();
                                QTags.addButton('eg_paragraph', 'p', '<p>', '</p>', 'p', 'Paragraph tag', 1);
                                /* add custom elements*/
                                var lc_title = '<input type="text" placeholder="' + lang_empty + '" value="' + title + '" class="layout_constructor_layout_dialog_desc" /><br />',
                                        lc_column_options = '&nbsp;<ul id="layout_constructor_column_options"></ul>';
                                jQuery('#wp-' + self.active_editor_id + '-editor-tools').prepend(lc_title).find('#wp-' + self.active_editor_id + '-media-buttons').append(lc_column_options);
                                jQuery('#layout_constructor_column_options').append('<li>' + jQuery('#layout_constructor_grid_class').html() + '</li>');
	                            var selected_opt = jQuery("#item_" + item_id).find('.js_effect').val();
	                            if(selected_opt) {
		                            jQuery('.grid_selector').val(selected_opt).find('[value='+selected_opt+']').attr('selected', 'selected');
	                            }
                                jQuery('.grid_selector').change(function() {
                                    jQuery("#item_" + item_id).find('.js_effect').val(jQuery(this).val());
                                });
                            },
                            close: function() {
                                jQuery('#tmm_advanced_wp_popup3 li').hide();
                                tinyMCE.execCommand('mceRemoveEditor', false, self.active_editor_id);
                                self.active_editor_id = null;
                                jQuery(".layout_constructor_layout_dialog_desc").remove();
                                jQuery('.grid_selector').val('');
                            },
                            buttons: {
                                0: {
                                    name: 'Apply',
                                    action: function(__self) {
                                        var new_title = jQuery(".layout_constructor_layout_dialog_desc").val(),
                                                active_tab = jQuery('#wp-' + self.active_editor_id + '-wrap').hasClass('tmce-active') ? 'tmce' : 'html',
                                                content = '';

                                        if (new_title.length == 0) {
                                            new_title = lang_empty;
                                        }

                                        if (active_tab === 'tmce') {
                                            content = tinyMCE.get(self.active_editor_id).getContent();
                                        } else {
                                            content = jQuery('#' + self.active_editor_id).val();
                                        }

	                                    var effect = jQuery('.grid_selector').val();

                                        jQuery("#item_" + item_id).find('.js_title').val(new_title == lang_empty ? "" : new_title);
                                        jQuery("#item_" + item_id).find('.page-element-item-text').html(new_title);
                                        jQuery("#item_" + item_id).find('.js_content').text(content);
                                        jQuery("#item_" + item_id).find('.js_effect').val(effect);
                                        jQuery('.advanced_wp_popup_close3').trigger('click');
                                    },
                                    close: false
                                },
                                1: {
                                    name: 'Close',
                                    action: 'close'
                                }
                            }
                        };

                        jQuery.post(ajaxurl, data, function(response) {
                            popup_params.content = response;
                            tmm_advanced_wp_popup3.popup(popup_params);
                            return false;
                        });

                        return false;
                    });


			jQuery("#layout_constructor_items .add-element-size-plus").life('click', function() {
				var item_id = jQuery(this).data('item-id');
				var css_class = jQuery("#item_" + item_id).find('.js_css_class').val();
				var next_li = jQuery("#item_" + item_id + " li.css-class-" + css_class).next('li');
				if (next_li.length > 0) {
					jQuery(next_li).find('a').trigger('click');
				}

				return false;
			});


			jQuery("#layout_constructor_items .add-element-size-minus").life('click', function() {
				var item_id = jQuery(this).data('item-id');
				var css_class = jQuery("#item_" + item_id).find('.js_css_class').val();
				var prev_li = jQuery("#item_" + item_id + " li.css-class-" + css_class).prev('li');
				if (prev_li.length > 0) {
					jQuery(prev_li).find('a').trigger('click');
				}
				return false;
			});




			jQuery(".change_column_size").life('click', function() {

				var parent = jQuery(this).parent().parent();

				if (jQuery(this).data('value') == 0) {
					jQuery(parent).hide(200);
					return false;
				}
				//*****

				var item_id = jQuery(parent).data('item-id');

				jQuery("#item_" + item_id).removeAttr('class').addClass('page-element').addClass(jQuery(this).data('css-class'));
				jQuery("#item_" + item_id).find('.element-size-text').html(jQuery(this).data('value'));

				jQuery("#item_" + item_id).find('.js_css_class').val(jQuery(this).data('css-class'));
				jQuery("#item_" + item_id).find('.js_front_css_class').val(jQuery(this).data('front-css-class'));
				jQuery("#item_" + item_id).find('.js_value').val(jQuery(this).data('value'));
				jQuery(parent).hide(200);

				return false;
			});

			//****
			jQuery('#row_background_type').life('change', function() {
				var val = jQuery(this).val();
				switch (val) {
					case 'custom':
						jQuery('#row_background_color_box').show();
						jQuery('#row_background_image_box').show();
						jQuery('#row_background_opacity_box').show();
						break;
					case 'default':
						jQuery('#row_background_color_box').hide();
						jQuery('#row_background_image_box').hide();
						jQuery('#row_background_opacity_box').hide();
						break;
				}
			});

			jQuery('.tmm_button_upload').life('click', function()
			{
				var input_object = jQuery(this).prev('input, textarea');
				window.send_to_editor = function(html)
				{
					if (!jQuery("#html_buffer").length) {
						jQuery('body').append('<div id="html_buffer"></div>')
					}
					//***
					jQuery("#html_buffer").html(html);
					var imgurl = jQuery('#html_buffer').find('a').eq(0).attr('href');
					jQuery("#html_buffer").html("");
					jQuery(input_object).val(imgurl);
					jQuery(input_object).trigger('change');
					tb_remove();
				};
				tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');

				return false;
			});

			//****
			self._is_rows_exists();
		},
		add_column: function(row_id) {
			var html = jQuery("#layout_constructor_column_item").html();
			var unique_id = self.get_time_miliseconds();
			html = html.replace(/__UNIQUE_ID__/gi, unique_id);
			html = html.replace(/__ROW_ID__/gi, row_id);
			jQuery("#row_columns_container_" + row_id).append(html);
			jQuery('#layout_constructor_items').sortable();
		},
		add_row: function() {
			var html = jQuery("#layout_constructor_column_row").html();
			var row_id = self.get_time_miliseconds();
			html = html.replace(/__ROW_ID__/gi, row_id);
			jQuery("#layout_constructor_items").append(html);
			jQuery('.row_columns_container').sortable();
			self._is_rows_exists();
			self.colorizator();
		},
		edit_row: function(row_id) {

			var popup_params = {
				content: jQuery('#layout_constructor_row_dialog').html(),
				title: lang_popup_row_title,
				overlay: true,
				width: 790,
				height: 'auto',
				close: function() {
				},
				open: function() {

					jQuery('#row_background_image').val('');
					jQuery('#row_background_opacity').val(30);
					jQuery('#row_bg_attachment').val('scroll');
					jQuery('#row_background_is_cover').val(0);
					jQuery('#row_background_is_cover').removeAttr('checked');
					jQuery('#row_background_color').val('');
					jQuery('#row_background_color').next('.bgpicker').css('background-color', '');
					//***
					var bg_type = jQuery('#row_bg_type_' + row_id).val();
					jQuery('#row_background_type').val(bg_type);
					switch (bg_type) {
						case 'default':
							//***
							break;
						case 'custom':
							jQuery('#row_background_opacity').val(jQuery('#row_bg_custom_opacity_' + row_id).val());
							jQuery('#row_background_color').val(jQuery('#row_bg_custom_color_' + row_id).val());
							jQuery('#row_background_color').next('.bgpicker').css('background-color', jQuery('#row_bg_custom_color_' + row_id).val());
							jQuery('#row_background_image').val(jQuery('#row_bg_custom_image_' + row_id).val());
							jQuery('#row_bg_attachment').val(jQuery('#row_bg_attachment_' + row_id).val());
							jQuery('#row_background_is_cover').val(jQuery('#row_bg_is_cover_' + row_id).val());
							if (jQuery('#row_bg_is_cover_' + row_id).val() == 1) {
								jQuery('#row_background_is_cover').attr('checked', 'checked');
							}
							break;
					}
					jQuery('#row_background_type').trigger('change');
					//*** borders init
					jQuery('#row_full_width').val(jQuery('#row_full_width_' + row_id).val());
					jQuery('#row_border_type').val(jQuery('#row_border_type_' + row_id).val());
					jQuery('#row_border_width').val(jQuery('#row_border_width_' + row_id).val());
					jQuery('#row_border_color').val(jQuery('#row_border_color_' + row_id).val());
					jQuery('#row_border_color').next('.bgpicker').css('background-color', jQuery('#row_border_color_' + row_id).val());
					jQuery('#row_padding_top').val(jQuery('#row_padding_top_' + row_id).val());
					jQuery('#row_padding_bottom').val(jQuery('#row_padding_bottom_' + row_id).val());
					self.colorizator();
					//***					
				},
				buttons: {
					0: {
						name: 'Apply',
						action: function(__self) {
							var bg_type = jQuery('#row_background_type').val();
							jQuery('#row_bg_type_' + row_id).val(bg_type);
							var bg_val = '';
							switch (bg_type) {
								case 'custom':
									jQuery('#row_bg_custom_color_' + row_id).val(jQuery('#row_background_color').val());
									jQuery('#row_bg_custom_opacity_' + row_id).val(jQuery('#row_background_opacity').val());
									jQuery('#row_bg_custom_image_' + row_id).val(jQuery('#row_background_image').val());
									jQuery('#row_bg_attachment_' + row_id).val(jQuery('#row_bg_attachment').val());
									bg_val = 'theme-custom-bg';
									break;
								case 'default':
									bg_val = 'theme-default-bg';
									break;
							}
							jQuery('#row_bg_data_' + row_id).val(bg_val);
							//*** apply borders
							jQuery('#row_full_width_' + row_id).val(jQuery('#row_full_width').val());
							jQuery('#row_border_type_' + row_id).val(jQuery('#row_border_type').val());
							jQuery('#row_border_width_' + row_id).val(jQuery('#row_border_width').val());
							jQuery('#row_border_color_' + row_id).val(jQuery('#row_border_color').val());
							jQuery('#row_padding_top_' + row_id).val(jQuery('#row_padding_top').val());
							jQuery('#row_padding_bottom_' + row_id).val(jQuery('#row_padding_bottom').val());
							jQuery('#row_bg_is_cover_' + row_id).val(jQuery('#row_background_is_cover').val());
							//***
							jQuery('.advanced_wp_popup_close3').trigger('click');
						},
						close: false
					},
					1: {
						name: 'Close',
						action: 'close'
					}
				}
			};
			tmm_advanced_wp_popup3.popup(popup_params);

			return false;
		},
		delete_row: function(row_id) {
			if (jQuery(".layout_constructor_layout_dialog_desc").length > 0) {
				return;
			}

			if (confirm(lang_sure_row_delete)) {
				jQuery("#layout_constructor_row_" + row_id).remove();
			}

			self._is_rows_exists();
		},
		_is_rows_exists: function() {
			if (jQuery("#layout_constructor_items > li").size() === 0) {
				jQuery("#layout_constructor_items").hide();
				return false;
			} else {
				jQuery("#layout_constructor_items").show();
			}

			return true;
		},
		get_time_miliseconds: function() {
			var d = new Date();
			return d.getTime();
		},
		colorizator: function() {
			var pickers = jQuery('.bgpicker');

			jQuery.each(pickers, function(key, picker) {

				var bg_hex_color = jQuery(picker).prev('.bg_hex_color');

				if (!jQuery(bg_hex_color).val()) {
					jQuery(bg_hex_color).val();
				}

				jQuery(picker).css('background-color', jQuery(bg_hex_color).val()).ColorPicker({
					color: jQuery(bg_hex_color).val(),
					onChange: function(hsb, hex, rgb) {
						jQuery(picker).css('backgroundColor', '#' + hex);
						jQuery(bg_hex_color).val('#' + hex);
						jQuery(bg_hex_color).trigger('change');
					}
				});

			});
		}
	};

	return self;
};
//*****

var tmm_ext_layout_constructor = null;
jQuery(document).ready(function() {
	tmm_ext_layout_constructor = new TMM_APP_CONTENT_CONSTRUCTOR();
	tmm_ext_layout_constructor.init();
});


