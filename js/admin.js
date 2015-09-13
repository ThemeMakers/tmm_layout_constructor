(function($){
    var tmm_layout_constructor = function() {
		var self = {
				columns: null,
				active_editor_id: null,
				init: function() {
					
					 $.fn.life = function(types, data, fn) {
						"use strict";
						$(this.context).on(types, this.selector, data, fn);
						return this;
					};
					
					self.columns = [
						{
							'value': '1/4',
							'name': 'col-md-3',
							'css_class': 'col-md-3',
							'front_css_class': 'col-md-3'
						},
						{
							'value': '1/3',
							'name': 'col-md-4',
							'css_class': 'col-md-4',
							'front_css_class': 'col-md-4'
						},
						{
							'value': '5/12',
							'name': 'col-md-5',
							'css_class': 'col-md-5',
							'front_css_class': 'col-md-5'
						},
						{
							'value': '1/2',
							'name': 'col-md-6',
							'css_class': 'col-md-6',
							'front_css_class': 'col-md-6'
						},
						{
							'value': '7/12',
							'name': 'col-md-7',
							'css_class': 'col-md-7',
							'front_css_class': 'col-md-7'
						},
						{
							'value': '2/3',
							'name': 'col-md-8',
							'css_class': 'col-md-8',
							'front_css_class': 'col-md-8'
						},
						{
							'value': '3/4',
							'name': 'col-md-9',
							'css_class': 'col-md-9',
							'front_css_class': 'col-md-9'
						},
						{
							'value': '5/6',
							'name': 'col-md-10',
							'css_class': 'col-md-10',
							'front_css_class': 'col-md-10'
						},
						{
							'value': '11/12',
							'name': 'col-md-11',
							'css_class': 'col-md-11',
							'front_css_class': 'col-md-11'
						},
						{
							'value': 'Fullwidth',
							'name': 'col-md-12',
							'css_class': 'col-md-12',
							'front_css_class': 'col-md-12'
						}
					];

                /* Preload layout constructor editor */
                var data = {
                    action: "get_lc_editor",
                    content: '',
                    editor_id: 'layout_constructor_editor'
                },
                lc_editor = '';

                $.post(ajaxurl, data, function(response) {
                    lc_editor = response;
                });

                /* Init sortable items */
                $('#layout_constructor_items').sortable();
                $('.row_columns_container').sortable();

                /* Create hidden popup area for changing column width */
                $.each(self.columns, function(index, column) {

                    var link = $('<a>')
                        .attr('href', '#')
                        .attr('data-value', column.value)
                        .attr('data-css-class', column.css_class)
                        .attr('data-front-css-class', column.front_css_class)
                        .addClass('change_column_size')
                        .html(column.name);

                    $('<li class="css-class-' + column.css_class + '">')
                        .append(link)
                        .appendTo('.layout_constructor_column_sizes_list');

                });

                /* Events handlers */
                $('.tmm-lc-add-row').life('click', function(){
                    self.add_row();
                    return false;
                });
                
                $('.tmm-lc-add-column').life('click', function(){
                    self.add_column($(this).data('row-id'));
                    return false;
                });
                
                $('.tmm-lc-edit-row').life('click', function(){
                    self.edit_row($(this).data('row-id'));
                    return false;
                });
                
                $('.tmm-lc-delete-row').life('click', function(){
                    self.delete_row($(this).data('row-id'));
                    return false;
                });
                
                $("#layout_constructor_items .delete-element").life('click', function() {
                    if (confirm(lang_sure_item_delete)) {
                        $("#item_" + $(this).data('item-id')).remove();
                    }
                    return false;
                });

                $("#layout_constructor_items .edit-element").life('click', function() {

                    if ($(".tmm-lc-column-title").length > 0) {
                        return;
                    }

                    show_static_info_popup(lang_loading);

                    var default_id = 'content',
                        ed = tinymce.get( default_id ),
                        wrap_id = 'wp-' + default_id + '-wrap',
                        DOM = tinymce.DOM;

                    if (!ed) {
                        tinymce.init(tinyMCEPreInit.mceInit[default_id]);

                        DOM.removeClass( wrap_id, 'html-active' );
                        DOM.addClass( wrap_id, 'tmce-active' );
                        setUserSetting( 'editor', 'tmce' );
                    } 

                    var item_id = $(this).data('item-id'),
                        title = $("#item_" + item_id).find('.page-element-item-text').html(),
                        text = $("#item_" + item_id).find('.js_content').text(),
                        popup_params = {};

                    if (title === lang_empty) {
                        title = "";
                    }

                    popup_params = {
                        content: lc_editor,
                        title: lang_popup_title,
                        popup_class: '',
                        open: function() {
                            self.active_editor_id = 'layout_constructor_editor';
                            /* setup tinyMCE */
                            tinyMCE.execCommand('mceAddEditor', false, self.active_editor_id);
                            if(tinyMCE.get(self.active_editor_id)){
                                tinyMCE.execCommand('mceSetContent', false, text);
                            }else{
                                setTimeout(function(){
                                    tinyMCE.execCommand('mceSetContent', false, text);
                                }, 1000);
                            }
                            /* setup Editor Text tab buttons */
                            quicktags(self.active_editor_id);
                            QTags._buttonsInit();
                            /* add custom elements */
                            var lc_title = '<input type="text" placeholder="' + lang_empty + '" value="' + title + '" class="tmm-lc-column-title" /><br />',
                                lc_column_options = '&nbsp;<ul id="layout_constructor_column_options"></ul>';
                            $('#wp-'+self.active_editor_id+'-editor-tools').prepend(lc_title).find('#wp-'+self.active_editor_id+'-media-buttons').append(lc_column_options);
                            hide_static_info_popup();
                        },
                        close: function() {
                            tinyMCE.execCommand('mceRemoveEditor', false, self.active_editor_id);                                                
                            self.active_editor_id = null;
                            $(".tmm-lc-column-title").remove();
                        },
                        save: function() {
                            var new_title = $(".tmm-lc-column-title").val(),
                                active_tab = $('#wp-'+self.active_editor_id+'-wrap').hasClass('tmce-active') ? 'tmce' : 'html',
                                content = '';

                            if (new_title.length == 0) {
                                new_title = lang_empty;
                            }

                            if(active_tab === 'tmce'){
                                content = tinyMCE.get(self.active_editor_id).getContent();
                            }else{
                                content = $('#' + self.active_editor_id).val();
                            }

                            $("#item_" + item_id)
                                .find('.js_title').val(new_title == lang_empty ? "" : new_title)
                                .end().find('.page-element-item-text').html(new_title)
                                .end().find('.js_content').text(content);
                        }
                    };

                    /* open popup if layout constructor editor already loaded */
                    if(lc_editor === ''){
                        var interval_id = setInterval(function(){
                            if(lc_editor !== ''){
                                popup_params.content = lc_editor;
                                clearInterval(interval_id);
                                $.tmm_popup(popup_params);
                            }
                        }, 500)
                    }else{
                        $.tmm_popup(popup_params);
                    }

                });

                $("#layout_constructor_items .add-element-size-plus").life('click', function() {
                    
                    var item_id = $(this).data('item-id'),
                        css_class = $("#item_" + item_id).find('.js_css_class').val(),
                        next_li = $("#item_" + item_id + " li.css-class-" + css_class).next('li');
                        
                    if (next_li.length > 0) {
                        $(next_li).find('a').trigger('click');
                    }
                    
                    return false;
                    
                });

                $("#layout_constructor_items .add-element-size-minus").life('click', function() {
                    
                    var item_id = $(this).data('item-id'),
                        css_class = $("#item_" + item_id).find('.js_css_class').val(),
                        prev_li = $("#item_" + item_id + " li.css-class-" + css_class).prev('li');
                    
                    if (prev_li.length > 0) {
                            $(prev_li).find('a').trigger('click');
                    }
                    
                    return false;
                    
                });

                $(".change_column_size").life('click', function() {

                    var parent = $(this).parent().parent();

                    if ($(this).data('value') == 0) {
                        $(parent).hide(200);
                        return false;
                    }

                    var item_id = $(parent).data('item-id');

                    $("#item_" + item_id).removeAttr('class').addClass('page-element').addClass($(this).data('css-class'));
                    $("#item_" + item_id).find('.element-size-text').html($(this).data('value'));

                    $("#item_" + item_id).find('.js_css_class').val($(this).data('css-class'));
                    $("#item_" + item_id).find('.js_front_css_class').val($(this).data('front-css-class'));
                    $("#item_" + item_id).find('.js_value').val($(this).data('value'));
                    $(parent).hide(200);

                    return false;
                });

                self._is_rows_exists();

            },
            add_column: function(row_id) {
                var html = $("#layout_constructor_column_item").html();
                var unique_id = uniqid();
                html = html.replace(/__UNIQUE_ID__/gi, unique_id);
                html = html.replace(/__ROW_ID__/gi, row_id);
                $("#row_columns_container_" + row_id).append(html);
                $('#layout_constructor_items').sortable();
            },
            add_row: function() {
                var html = $("#layout_constructor_column_row").html();
                var row_id = uniqid();
                html = html.replace(/__ROW_ID__/gi, row_id);
                $("#layout_constructor_items").append(html);
                $('.row_columns_container').sortable();
                self._is_rows_exists();
                self.colorizator();
            },
            edit_row: function(row_id) {

                var popup_params = {
                    content: $('#layout_constructor_row_dialog').html(),
                    title: lang_popup_row_title,
                    popup_class: 'tmm-popup-edit-row',
                    open: function() {
                        
                        var cur_popup = $('.tmm-popup-edit-row'),
                            padding_top = $('#row_padding_top_' + row_id).val(),
                            padding_bottom = $('#row_padding_bottom_' + row_id).val();
                                        
                        cur_popup.find('#row_padding_top').val(padding_top);
                        cur_popup.find('#row_padding_bottom').val(padding_bottom);
                        self.colorizator();	
                                          
                    },
                    close:function(){},
                    save: function() {
                        var cur_popup = $('.tmm-popup-edit-row'),
                            padding_top = cur_popup.find('#row_padding_top').val(),
                            padding_bottom = cur_popup.find('#row_padding_bottom').val();
                   
                        $('#row_padding_top_' + row_id).val(padding_top);
                        $('#row_padding_bottom_' + row_id).val(padding_bottom);
                        
                    }
                };
                $.tmm_popup(popup_params);
                
            },
            delete_row: function(row_id) {
                
                if (confirm(lang_sure_row_delete)) {
                    $("#layout_constructor_row_" + row_id).remove();
                }

                self._is_rows_exists();
            },
            _is_rows_exists: function() {
                
                var rows_wrapper = $("#layout_constructor_items"),
                    rows_count = rows_wrapper.find('li').size();
                if (rows_count === 0) {
                    rows_wrapper.hide();
                } else {
                    rows_wrapper.show();
                }

                return rows_count;
            },
            colorizator: function() {
                var pickers = $('.bgpicker');

                $.each(pickers, function(key, picker) {

                        var bg_hex_color = $(picker).prev('.bg_hex_color');

                        if (!$(bg_hex_color).val()) {
                                $(bg_hex_color).val();
                        }

                        $(picker).css('background-color', $(bg_hex_color).val()).ColorPicker({
                                color: $(bg_hex_color).val(),
                                onChange: function(hsb, hex, rgb) {
                                        $(picker).css('backgroundColor', '#' + hex);
                                        $(bg_hex_color).val('#' + hex);
                                        $(bg_hex_color).trigger('change');
                                }
                        });

                });
            }
        };

        return self;
    };

    $(function() {
        
        var layout_constructor = new tmm_layout_constructor();
        layout_constructor.init();
        if(window.QTags){
            QTags.addButton( 'eg_paragraph', 'p', '<p>', '</p>', 'p', '', 1 );
        }
    });

}(jQuery));