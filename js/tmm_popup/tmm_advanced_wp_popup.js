var TMM_ADVANCED_WP_POPUP3 = function() {
	var self = {
		zindex: 1010,
		popup_li: null,
		params: null,
		init: function() {
			jQuery('body').prepend('<ul id="tmm_advanced_wp_popup3"></ul>');
			jQuery('body').prepend('<div id="advanced_wp_popup_overlay" class="advanced_wp_popup_overlay_lc"></div>');
			//***
			jQuery('.advanced_wp_popup_close3').live('click', function() {
				self.close(jQuery(this));
			});
			jQuery('.advanced_wp_popup_close3').live('click', function() {
				self.close(jQuery(this));
			});
		},
		popup: function(params) {
			self.params = self.validate_params(params);
			params = self.validate_params(params);
			jQuery('#tmm_advanced_wp_popup3').append('<li class="tmm_advanced_wp_popup_li" style="width:' + params.width + 'px; height:' + params.height + 'px;margin-left:-' + params.width / 2 + 'px;">');
			this.popup_li = jQuery('#tmm_advanced_wp_popup3 li:last-child');
			jQuery(this.popup_li).css('z-index', self.zindex++);
			jQuery(this.popup_li).append('<div class="advanced_wp_popup_container">');
			jQuery(this.popup_li).append('<div class="advanced_wp_popup_buttons">');
			var popup = jQuery(this.popup_li).find('.advanced_wp_popup_container');
			/***/
			if (params.title.length > 0) {
				popup.append('<div class="tmm_titlebar" />');
				popup.children('.tmm_titlebar').append('<h6>').children('h6').html(params.title);
				popup.children('.tmm_titlebar').append('<a href="javascript:void(0);" class="advanced_wp_popup_close3"></a>');
			}
			/***/
			jQuery(popup).append('<div class="advanced_wp_popup_content">');
			jQuery(popup).find('.advanced_wp_popup_content').html(params.content);
			jQuery(popup).find('.advanced_wp_popup_content').find('input[type=text]').life('keyup', function() {
				jQuery(this).attr('value', jQuery(this).val());
			});
			jQuery(popup).find('.advanced_wp_popup_content').find('input[type=text]').life('change', function() {
				jQuery(this).attr('value', jQuery(this).val());
			});
			jQuery(popup).find('.advanced_wp_popup_content').find('input[type=checkbox]').life('click', function() {
				var check = jQuery(this).is(':checked');
				if (check) {
					jQuery(this).attr('checked', 'checked');
				} else {
					jQuery(this).removeAttr('checked');
				}
			});
			jQuery(popup).find('.advanced_wp_popup_content').find('textarea').life('keyup', function() {
				jQuery(this).text(jQuery(this).val());
			});
			jQuery(popup).find('.advanced_wp_popup_content').find('select').life('change', function() {
				var value = jQuery(this).val();
				jQuery(this).find("option").filter(function() {
					//may want to use $.trim in here
					return jQuery(this).val() == value;
				}).attr('selected', true);
			});
			
			jQuery(this.popup_li).draggable({
				handle: '.tmm_titlebar'
			});
			jQuery(this.popup_li).fadeTo(200, 1);
			self.overlay(params.overlay, self.zindex - 1);
			//***
			self.open(params, this.popup_li);
		},
		overlay: function(mode, zindex) {
			if (mode) {
				jQuery('#advanced_wp_popup_overlay.advanced_wp_popup_overlay_lc').show();
			} else {
				jQuery('#advanced_wp_popup_overlay.advanced_wp_popup_overlay_lc').hide();
			}
		},
		open: function(params, popup_li) {
			self.params = params;
			jQuery.each(params.buttons, function(index, button) {
				if (button.action == 'close') {
					if (button.close !== undefined) {
						button.close();
					}

					jQuery(popup_li).find('.advanced_wp_popup_buttons').append('<a href="javascript:void(0);" class="tmm_button advanced_wp_popup_close3">' + button.name + '</a>');
					return;
				}

	
				jQuery(popup_li).find('.advanced_wp_popup_buttons').append('<a href="javascript:tmm_advanced_wp_popup3.do_action(' + index + ');void(0);" class="tmm_button">' + button.name + '</a>');

			});
	
			if (params.open !== undefined) {
				params.open();
			}
		},
		get_content: function() {
			return jQuery(this.popup_li).find('.advanced_wp_popup_content').html();
		},
		close: function(_this) {
			var popup = jQuery(_this).parents('li.tmm_advanced_wp_popup_li');
			window.setTimeout(function() {
				jQuery(popup).fadeOut(150, function() {
					jQuery(this).remove();
					self.overlay(0);
				});
			}, 100);
			//***
			if (self.params !== undefined) {
				if (self.params.close !== undefined) {
					self.params.close();
				}
			}

		},
		do_action: function(index) {
			jQuery.each(self.params.buttons, function(i, button) {
				if (i == index) {
					button.action(self);
					if (button.close !== undefined) {
						if (button.close == 1) {
							//TODO
						}
					}
					return false;
				}
			});
		},
		validate_params: function(params) {
			if (params.title === undefined) {
				params.title = "";
			}

			if (params.overlay === undefined) {
				params.overlay = 0;
			}

			if (params.width === undefined || params.width === null) {
				params.width = 800;
			}

			if (params.height === undefined || params.height === null) {
				params.height = 600;
			}

			if (params.buttons === undefined) {
				params.buttons = {
					0: {
						name: 'Cancel',
						action: 'close'
					}
				};
			}

			return params;
		}
	};
	return self;
};
//*****

var tmm_advanced_wp_popup3 = null;
jQuery(document).ready(function() {
	tmm_advanced_wp_popup3 = new TMM_ADVANCED_WP_POPUP3();
	tmm_advanced_wp_popup3.init();
});

