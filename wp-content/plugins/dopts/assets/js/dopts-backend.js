/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : dopts-backend.js
* File Version            : 1.5
* Created / Last Modified : 01 October 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Admin Scripts.
*/

//Declare global variables.
var currScroller = 0,
currImage = 0,
clearClick = true,
imageDisplay = false,
imageWidth = 0,
imageHeight = 0,
$jDOPTS = jQuery.noConflict();

$jDOPTS(document).ready(function(){
    if (DOPTS_curr_page == undefined){
        DOPTS_curr_page = 'Scrollers List';
    }
    
    doptsResize();

    $jDOPTS(window).resize(function(){
        doptsResize();
    });
    
    $jDOPTS(document).scroll(function(){
        doptsResize();
    });

    switch (DOPTS_curr_page){
        case 'Scrollers List':
            doptsShowScrollers();
            break;
    }
});

function doptsResize(){// ResiE admin panel.
    $jDOPTS('.column2', '.DOPTS-admin').width(($jDOPTS('.DOPTS-admin').width()-$jDOPTS('.column1', '.DOPTS-admin').width()-2)/2);
    $jDOPTS('.column3', '.DOPTS-admin').width(($jDOPTS('.DOPTS-admin').width()-$jDOPTS('.column1', '.DOPTS-admin').width()-2)/2);
    $jDOPTS('.column-separator', '.DOPTS-admin').height(0);
    $jDOPTS('.column-separator', '.DOPTS-admin').height($jDOPTS('.DOPTS-admin').height()-$jDOPTS('h2', '.DOPTS-admin').height()-parseInt($jDOPTS('h2', '.DOPTS-admin').css('padding-top'))-parseInt($jDOPTS('h2', '.DOPTS-admin').css('padding-bottom')));
    $jDOPTS('.main', '.DOPTS-admin').css('display', 'block');

    $jDOPTS('.column-input', '.DOPTS-admin').width($jDOPTS('.column-content', '.column3', '.DOPTS-admin').width()-32);
    $jDOPTS('.column-image', '.DOPTS-admin').width($jDOPTS('.column-input', '.DOPTS-admin').width()+10);
    
    if (imageDisplay){
        $jDOPTS('span', '.column-image', '.DOPTS-admin').width($jDOPTS('.column-image', '.DOPTS-admin').width());
        $jDOPTS('span', '.column-image', '.DOPTS-admin').height($jDOPTS('.column-image', '.DOPTS-admin').width()*imageHeight/imageWidth);
        $jDOPTS('img', '.column-image', '.DOPTS-admin').width($jDOPTS('span', '.column-image', '.DOPTS-admin').width());
        $jDOPTS('img', '.column-image', '.DOPTS-admin').height($jDOPTS('span', '.column-image', '.DOPTS-admin').height());
        $jDOPTS('img', '.column-image', '.DOPTS-admin').css('margin-top', 0);
        $jDOPTS('img', '.column-image', '.DOPTS-admin').css('margin-left', 0);
    }
}

// Scrollers

function doptsShowScrollers(){// Show all scrollers.
    doptsRemoveColumns(2);
    doptsToggleMessage('show', DOPTS_LOAD);
    
    $jDOPTS.post(ajaxurl, {action:'dopts_show_scrollers'}, function(data){
        $jDOPTS('.column-content', '.column1', '.DOPTS-admin').html(data);
        doptsScrollersEvents();
        doptsToggleMessage('hide', DOPTS_SCROLLERS_LOADED);
    });
}

function doptsAddScroller(){// Add scroller via AJAX.
    if (clearClick){
        doptsRemoveColumns(2);
        doptsToggleMessage('show', DOPTS_ADD_SCROLLER_SUBMITED);
        
        $jDOPTS.post(ajaxurl, {action:'dopts_add_scroller'}, function(data){
            $jDOPTS('.column-content', '.column1', '.DOPTS-admin').html(data);
            doptsScrollersEvents();
            doptsToggleMessage('hide', DOPTS_ADD_GALERRY_SUCCESS);
        });
    }
}

function doptsShowDefaultSettings(){// Show default settings.
    if (clearClick){
        $jDOPTS('li', '.column1', '.DOPTS-admin').removeClass('item-selected');
        currScroller = 0;
        currImage = 0;
        doptsRemoveColumns(2);
        $jDOPTS('#scroller_id').val(0);
        doptsToggleMessage('show', DOPTS_LOAD);
        
        $jDOPTS.post(ajaxurl, {action: 'dopts_show_scroller_settings',
                               scroller_id: $jDOPTS('#scroller_id').val(),
                               settings_id: 0}, function(data){
            var HeaderHTML = new Array(),
            json = $jDOPTS.parseJSON(data);

            HeaderHTML.push('<input type="button" name="DOPTS_scroller_submit" class="submit-style" onclick="doptsEditScrollerSettings()" title="'+DOPTS_EDIT_SCROLLERS_SUBMIT+'" value="'+DOPTS_SUBMIT+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPTS_SCROLLERS_EDIT_INFO_HELP+'</span></a>');

            $jDOPTS('.column-header', '.column2', '.DOPTS-admin').html(HeaderHTML.join(''));
            doptsSettingsForm(json, 2);

            doptsResize();
            doptsToggleMessage('hide', DOPTS_SCROLLER_LOADED);
        });
    }
}

function doptsShowScrollerSettings(){// Show scroller settings.
    if (clearClick){
        $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
        doptsRemoveColumns(3);
        doptsToggleMessage('show', DOPTS_LOAD);
        
        $jDOPTS.post(ajaxurl, {action: 'dopts_show_scroller_settings',
                               scroller_id: $jDOPTS('#scroller_id').val(),
                               settings_id: 0}, function(data){            
            var HeaderHTML = new Array(),
            json = $jDOPTS.parseJSON(data);
            
            HeaderHTML.push('<input type="button" name="DOPTS_scroller_submit" class="submit-style" onclick="doptsEditScrollerSettings()" title="'+DOPTS_EDIT_SCROLLER_SUBMIT+'" value="'+DOPTS_SUBMIT+'" />');
            HeaderHTML.push('<input type="button" name="DOPTS_scroller_delete" class="submit-style" onclick="doptsDeleteScroller('+$jDOPTS('#scroller_id').val()+')" title="'+DOPTS_DELETE_SCROLLER_SUBMIT+'" value="'+DOPTS_DELETE+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_SCROLLER_EDIT_INFO_HELP+'</span></a>');
            HeaderHTML.push('<input type="button" name="DOPTS_scroller_delete" class="submit-style right" onclick="doptsDefaultScroller()" title="'+DOPTS_DEFAULT+'" value="'+DOPTS_DEFAULT+'" />');
            HeaderHTML.push('<select name="DOPTS_scroller_predefined_settings" id="DOPTS_scroller_predefined_settings" class="select-style right">'+json['predefined_settings']+'</select>');
            
            $jDOPTS('.column-header', '.column3', '.DOPTS-admin').html(HeaderHTML.join(''));
            doptsSettingsForm(json, 3);
            
            doptsResize();
            doptsToggleMessage('hide', DOPTS_SCROLLER_LOADED);
        });
    }
}

function doptsEditScrollerSettings(){// Edit Scroller Settings.
    if (clearClick){
        doptsToggleMessage('show', DOPTS_SAVE);
        
        $jDOPTS.post(ajaxurl, {action:'dopts_edit_scroller_settings',
                               scroller_id: $jDOPTS('#scroller_id').val(),
                               name: $jDOPTS('#name').val(),
                               data_parse_method: $jDOPTS('#data_parse_method').val(),
                               width: $jDOPTS('#width').val(),
                               height: $jDOPTS('#height').val(),
                               bg_color: $jDOPTS('#bg_color').val(),
                               bg_alpha: $jDOPTS('#bg_alpha').val(),
                               bg_border_size: $jDOPTS('#bg_border_size').val(),
                               bg_border_color: $jDOPTS('#bg_border_color').val(),
                               images_order: $jDOPTS('#images_order').val(),
                               responsive_enabled: $jDOPTS('#responsive_enabled').is(':checked') ? 'true':'false',
                               ultra_responsive_enabled: $jDOPTS('#ultra_responsive_enabled').is(':checked') ? 'true':'false',
                               thumbnails_position: $jDOPTS('#thumbnails_position').val(),
                               thumbnails_bg_color: $jDOPTS('#thumbnails_bg_color').val(),
                               thumbnails_bg_alpha: $jDOPTS('#thumbnails_bg_alpha').val(),
                               thumbnails_border_size: $jDOPTS('#thumbnails_border_size').val(),
                               thumbnails_border_color: $jDOPTS('#thumbnails_border_color').val(),
                               thumbnails_spacing: $jDOPTS('#thumbnails_spacing').val(),
                               thumbnails_margin_top: $jDOPTS('#thumbnails_margin_top').val(),
                               thumbnails_margin_right: $jDOPTS('#thumbnails_margin_right').val(),
                               thumbnails_margin_bottom: $jDOPTS('#thumbnails_margin_bottom').val(),
                               thumbnails_margin_left: $jDOPTS('#thumbnails_margin_left').val(),
                               thumbnails_padding_top: $jDOPTS('#thumbnails_padding_top').val(),
                               thumbnails_padding_right: $jDOPTS('#thumbnails_padding_right').val(),
                               thumbnails_padding_bottom: $jDOPTS('#thumbnails_padding_bottom').val(),
                               thumbnails_padding_left: $jDOPTS('#thumbnails_padding_left').val(),
                               thumbnails_info: $jDOPTS('#thumbnails_info').val(),
                               thumbnails_navigation_easing: $jDOPTS('#thumbnails_navigation_easing').val(),
                               thumbnails_navigation_loop: $jDOPTS('#thumbnails_navigation_loop').is(':checked') ? 'true':'false',
                               thumbnails_navigation_mouse_enabled: $jDOPTS('#thumbnails_navigation_mouse_enabled').is(':checked') ? 'true':'false',
                               thumbnails_navigation_scroll_enabled: $jDOPTS('#thumbnails_navigation_scroll_enabled').is(':checked') ? 'true':'false',
                               thumbnails_scroll_position: $jDOPTS('#thumbnails_scroll_position').val(),
                               thumbnails_scroll_size: $jDOPTS('#thumbnails_scroll_size').val(),
                               thumbnails_scroll_scrub_color: $jDOPTS('#thumbnails_scroll_scrub_color').val(),
                               thumbnails_scroll_bar_color: $jDOPTS('#thumbnails_scroll_bar_color').val(), 
                               thumbnails_navigation_arrows_enabled: $jDOPTS('#thumbnails_navigation_arrows_enabled').is(':checked') ? 'true':'false',
                               thumbnails_navigation_arrows_no_items_slide: $jDOPTS('#thumbnails_navigation_arrows_no_items_slide').val(),
                               thumbnails_navigation_arrows_speed: $jDOPTS('#thumbnails_navigation_arrows_speed').val(),
                               thumbnail_width: $jDOPTS('#thumbnail_width').val(),
                               thumbnail_height: $jDOPTS('#thumbnail_height').val(),
                               thumbnail_alpha: $jDOPTS('#thumbnail_alpha').val(),
                               thumbnail_alpha_hover: $jDOPTS('#thumbnail_alpha_hover').val(),
                               thumbnail_bg_color: $jDOPTS('#thumbnail_bg_color').val(),
                               thumbnail_bg_color_hover: $jDOPTS('#thumbnail_bg_color_hover').val(),
                               thumbnail_border_size: $jDOPTS('#thumbnail_border_size').val(),
                               thumbnail_border_color: $jDOPTS('#thumbnail_border_color').val(),
                               thumbnail_border_color_hover: $jDOPTS('#thumbnail_border_color_hover').val(),
                               thumbnail_padding_top: $jDOPTS('#thumbnail_padding_top').val(),
                               thumbnail_padding_right: $jDOPTS('#thumbnail_padding_right').val(),
                               thumbnail_padding_bottom: $jDOPTS('#thumbnail_padding_bottom').val(),
                               thumbnail_padding_left: $jDOPTS('#thumbnail_padding_left').val(),
                               lightbox_enabled: $jDOPTS('#lightbox_enabled').is(':checked') ? 'true':'false',
                               lightbox_display_time: $jDOPTS('#lightbox_display_time').val(),
                               lightbox_window_color: $jDOPTS('#lightbox_window_color').val(),
                               lightbox_window_alpha: $jDOPTS('#lightbox_window_alpha').val(),
                               lightbox_bg_color: $jDOPTS('#lightbox_bg_color').val(),
                               lightbox_bg_alpha: $jDOPTS('#lightbox_bg_alpha').val(),
                               lightbox_border_size: $jDOPTS('#lightbox_border_size').val(),
                               lightbox_border_color: $jDOPTS('#lightbox_border_color').val(),
                               lightbox_caption_text_color: $jDOPTS('#lightbox_caption_text_color').val(),       
                               lightbox_margin_top: $jDOPTS('#lightbox_margin_top').val(),
                               lightbox_margin_right: $jDOPTS('#lightbox_margin_right').val(),
                               lightbox_margin_bottom: $jDOPTS('#lightbox_margin_bottom').val(),
                               lightbox_margin_left: $jDOPTS('#lightbox_margin_left').val(),
                               lightbox_padding_top: $jDOPTS('#lightbox_padding_top').val(),
                               lightbox_padding_right: $jDOPTS('#lightbox_padding_right').val(),
                               lightbox_padding_bottom: $jDOPTS('#lightbox_padding_bottom').val(),
                               lightbox_padding_left: $jDOPTS('#lightbox_padding_left').val(),
                               lightbox_navigation_info_bg_color: $jDOPTS('#lightbox_navigation_info_bg_color').val(),
                               lightbox_navigation_info_text_color: $jDOPTS('#lightbox_navigation_info_text_color').val(),                        
                               lightbox_navigation_display_time: $jDOPTS('#lightbox_navigation_display_time').val(),
                               lightbox_navigation_touch_device_swipe_enabled: $jDOPTS('#lightbox_navigation_touch_device_swipe_enabled').is(':checked') ? 'true':'false',
                               social_share_enabled: $jDOPTS('#social_share_enabled').is(':checked') ? 'true':'false',
                               tooltip_bg_color: $jDOPTS('#tooltip_bg_color').val(),
                               tooltip_stroke_color: $jDOPTS('#tooltip_stroke_color').val(),
                               tooltip_text_color: $jDOPTS('#tooltip_text_color').val(),
                               label_position: $jDOPTS('#label_position').val(),
                               label_always_visible: $jDOPTS('#label_always_visible').is(':checked') ? 'true':'false',           
                               label_under_height: $jDOPTS('#label_under_height').val(),            
                               label_bg_color: $jDOPTS('#label_bg_color').val(),
                               label_bg_alpha: $jDOPTS('#label_bg_alpha').val(),  
                               label_text_color: $jDOPTS('#label_text_color').val(),
                               slideshow_enabled: $jDOPTS('#slideshow_enabled').is(':checked') ? 'true':'false',
                               slideshow_time: $jDOPTS('#slideshow_time').val(),
                               slideshow_loop: $jDOPTS('#slideshow_loop').is(':checked') ? 'true':'false'}, function(data){
            if ($jDOPTS('#scroller_id').val() != '0'){
                $jDOPTS('.name', '#DOPTS-ID-'+$jDOPTS('#scroller_id').val()).html(doptsShortName($jDOPTS('#name').val(), 25));
                doptsToggleMessage('hide', DOPTS_EDIT_SCROLLER_SUCCESS);
            }
            else{
                doptsToggleMessage('hide', DOPTS_EDIT_SCROLLERS_SUCCESS);
            }
        });
    }
}

function doptsDefaultScroller(){// Add default settings to scroller.
    if (clearClick){
        if (confirm(DOPTS_EDIT_SCROLLER_USE_DEFAULT_CONFIRMATION)){
            doptsToggleMessage('show', DOPTS_SAVE);
            
            $jDOPTS.post(ajaxurl, {action: 'dopts_show_scroller_settings',
                                   scroller_id: 0,
                                   settings_id: $jDOPTS('#DOPTS_scroller_predefined_settings').val()}, function(data){
                data = $jDOPTS.parseJSON(data);
                
                $jDOPTS('#width').val(data['width']);
                $jDOPTS('#height').val(data['height']);
                $jDOPTS('#bg_color').val(data['bg_color']);
                $jDOPTS('#bg_alpha').val(data['bg_alpha']);
                $jDOPTS('#bg_border_size').val(data['bg_border_size']);
                $jDOPTS('#bg_border_color').val(data['bg_border_color']);
                $jDOPTS('#images_order').val(data['images_order']);
                data['responsive_enabled'] == 'true' ? $jDOPTS('#responsive_enabled').attr('checked', 'checked'):$jDOPTS('#responsive_enabled').removeAttr('checked');
                data['ultra_responsive_enabled'] == 'true' ? $jDOPTS('#ultra_responsive_enabled').attr('checked', 'checked'):$jDOPTS('#ultra_responsive_enabled').removeAttr('checked');
                
                $jDOPTS('#thumbnails_position').val(data['thumbnails_position']);
                $jDOPTS('#thumbnails_bg_color').val(data['thumbnails_bg_color']);
                $jDOPTS('#thumbnails_bg_alpha').val(data['thumbnails_bg_alpha']);
                $jDOPTS('#thumbnails_border_size').val(data['thumbnails_border_size']);
                $jDOPTS('#thumbnails_border_color').val(data['thumbnails_border_color']);
                $jDOPTS('#thumbnails_spacing').val(data['thumbnails_spacing']);
                $jDOPTS('#thumbnails_margin_top').val(data['thumbnails_margin_top']);
                $jDOPTS('#thumbnails_margin_right').val(data['thumbnails_margin_right']);
                $jDOPTS('#thumbnails_margin_bottom').val(data['thumbnails_margin_bottom']);
                $jDOPTS('#thumbnails_margin_left').val(data['thumbnails_margin_left']);
                $jDOPTS('#thumbnails_padding_top').val(data['thumbnails_padding_top']);
                $jDOPTS('#thumbnails_padding_right').val(data['thumbnails_padding_right']);
                $jDOPTS('#thumbnails_padding_bottom').val(data['thumbnails_padding_bottom']);
                $jDOPTS('#thumbnails_padding_left').val(data['thumbnails_padding_left']);
                $jDOPTS('#thumbnails_info').val(data['thumbnails_info']);
        
                $jDOPTS('#thumbnails_navigation_easing').val(data['thumbnails_navigation_easing']);
                data['thumbnails_navigation_loop'] == 'true' ? $jDOPTS('#thumbnails_navigation_loop').attr('checked', 'checked'):$jDOPTS('#thumbnails_navigation_loop').removeAttr('checked');
                
                data['thumbnails_navigation_mouse_enabled'] == 'true' ? $jDOPTS('#thumbnails_navigation_mouse_enabled').attr('checked', 'checked'):$jDOPTS('#thumbnails_navigation_mouse_enabled').removeAttr('checked');
                
                data['thumbnails_navigation_scroll_enabled'] == 'true' ? $jDOPTS('#thumbnails_navigation_scroll_enabled').attr('checked', 'checked'):$jDOPTS('#thumbnails_navigation_scroll_enabled').removeAttr('checked');
                $jDOPTS('#thumbnails_scroll_position').val(data['thumbnails_scroll_position']);
                $jDOPTS('#thumbnails_scroll_size').val(data['thumbnails_scroll_size']);
                $jDOPTS('#thumbnails_scroll_scrub_color').val(data['thumbnails_scroll_scrub_color']);
                $jDOPTS('#thumbnails_scroll_bar_color').val(data['thumbnails_scroll_bar_color']); 
                
                data['thumbnails_navigation_arrows_enabled'] == 'true' ? $jDOPTS('#thumbnails_navigation_arrows_enabled').attr('checked', 'checked'):$jDOPTS('#thumbnails_navigation_arrows_enabled').removeAttr('checked');
                $jDOPTS('#thumbnails_navigation_arrows_no_items_slide').val(data['thumbnails_navigation_arrows_no_items_slide']);
                $jDOPTS('#thumbnails_navigation_arrows_speed').val(data['thumbnails_navigation_arrows_speed']);
                $jDOPTS('#thumbnails_navigation_prev_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_prev']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#thumbnails_navigation_prev_hover_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_prev_hover']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#thumbnails_navigation_prev_disabled_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_prev_disabled']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#thumbnails_navigation_next_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_next']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#thumbnails_navigation_next_hover_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_next_hover']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');           
                $jDOPTS('#thumbnails_navigation_next_disabled_image').html('<img src="'+DOPTS_plugin_url+data['thumbnails_navigation_next_disabled']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');                           
                
                $jDOPTS('#thumbnail_loader_image').html('<img src="'+DOPTS_plugin_url+data['thumbnail_loader']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#thumbnail_width').val(data['thumbnail_width']);
                $jDOPTS('#thumbnail_height').val(data['thumbnail_height']);
                $jDOPTS('#thumbnail_alpha').val(data['thumbnail_alpha']);
                $jDOPTS('#thumbnail_alpha_hover').val(data['thumbnail_alpha_hover']);
                $jDOPTS('#thumbnail_bg_color').val(data['thumbnail_bg_color']);
                $jDOPTS('#thumbnail_bg_color_hover').val(data['thumbnail_bg_color_hover']);
                $jDOPTS('#thumbnail_border_size').val(data['thumbnail_border_size']);
                $jDOPTS('#thumbnail_border_color').val(data['thumbnail_border_color']);
                $jDOPTS('#thumbnail_border_color_hover').val(data['thumbnail_border_color_hover']);
                $jDOPTS('#thumbnail_padding_top').val(data['thumbnail_padding_top']);
                $jDOPTS('#thumbnail_padding_right').val(data['thumbnail_padding_right']);
                $jDOPTS('#thumbnail_padding_bottom').val(data['thumbnail_padding_bottom']);
                $jDOPTS('#thumbnail_padding_left').val(data['thumbnail_padding_left']);
                   
                data['lightbox_enabled'] == 'true' ? $jDOPTS('#lightbox_enabled').attr('checked', 'checked'):$jDOPTS('#lightbox_enabled').removeAttr('checked');
                $jDOPTS('#lightbox_display_time').val(data['lightbox_display_time']);
                $jDOPTS('#lightbox_window_color').val(data['lightbox_window_color']);
                $jDOPTS('#lightbox_window_alpha').val(data['lightbox_window_alpha']);
                $jDOPTS('#lightbox_loader_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_loader']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');                           
                $jDOPTS('#lightbox_bg_color').val(data['lightbox_bg_color']);
                $jDOPTS('#lightbox_bg_alpha').val(data['lightbox_bg_alpha']);
                $jDOPTS('#lightbox_border_size').val(data['lightbox_border_size']);
                $jDOPTS('#lightbox_border_color').val(data['lightbox_border_color']);
                $jDOPTS('#lightbox_caption_text_color').val(data['lightbox_caption_text_color']); 
                $jDOPTS('#lightbox_margin_top').val(data['lightbox_margin_top']);
                $jDOPTS('#lightbox_margin_right').val(data['lightbox_margin_right']);
                $jDOPTS('#lightbox_margin_bottom').val(data['lightbox_margin_bottom']);
                $jDOPTS('#lightbox_margin_left').val(data['lightbox_margin_left']);
                $jDOPTS('#lightbox_padding_top').val(data['lightbox_padding_top']);
                $jDOPTS('#lightbox_padding_right').val(data['lightbox_padding_right']);
                $jDOPTS('#lightbox_padding_bottom').val(data['lightbox_padding_bottom']);
                $jDOPTS('#lightbox_padding_left').val(data['lightbox_padding_left']);
                
                $jDOPTS('#lightbox_navigation_prev_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_prev']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_prev_hover_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_prev_hover']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_next_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_next']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_next_hover_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_next_hover']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_close_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_close']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_close_hover_image').html('<img src="'+DOPTS_plugin_url+data['lightbox_navigation_close_hover']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                $jDOPTS('#lightbox_navigation_info_bg_color').val(data['lightbox_navigation_info_bg_color']);
                $jDOPTS('#lightbox_navigation_info_text_color').val(data['lightbox_navigation_info_text_color']);
                $jDOPTS('#lightbox_navigation_display_time').val(data['lightbox_navigation_display_time']);
                data['lightbox_navigation_touch_device_swipe_enabled'] == 'true' ? $jDOPTS('#lightbox_navigation_touch_device_swipe_enabled').attr('checked', 'checked'):$jDOPTS('#lightbox_navigation_touch_device_swipe_enabled').removeAttr('checked');
                
                data['social_share_enabled'] == 'true' ? $jDOPTS('#social_share_enabled').attr('checked', 'checked'):$jDOPTS('#social_share_enabled').removeAttr('checked');
                $jDOPTS('#social_share_lightbox_image').html('<img src="'+DOPTS_plugin_url+data['social_share_lightbox']+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                
                $jDOPTS('#tooltip_bg_color').val(data['tooltip_bg_color']);
                $jDOPTS('#tooltip_stroke_color').val(data['tooltip_bg_color']);
                $jDOPTS('#tooltip_text_color').val(data['tooltip_text_color']);
                
                $jDOPTS('#label_position').val(data['label_position']); 
                data['label_always_visible'] == 'true' ? $jDOPTS('#label_always_visible').attr('checked', 'checked'):$jDOPTS('#label_always_visible').removeAttr('checked');
                $jDOPTS('#label_under_height').val(data['label_under_height']);   
                $jDOPTS('#label_bg_color').val(data['label_bg_color']);
                $jDOPTS('#label_bg_alpha').val(data['label_bg_alpha']);  
                $jDOPTS('#label_text_color').val(data['label_text_color']);
                
                data['slideshow_enabled'] == 'true' ? $jDOPTS('#slideshow_enabled').attr('checked', 'checked'):$jDOPTS('#slideshow_enabled').removeAttr('checked');
                $jDOPTS('#slideshow_time').val(data['slideshow_time']);
                data['slideshow_loop'] == 'true' ? $jDOPTS('#slideshow_loop').attr('checked', 'checked'):$jDOPTS('#slideshow_loop').removeAttr('checked');
                
                $jDOPTS('#bg_color').removeAttr('style').css({'background-color': '#'+data['bg_color'],
                                                              'color': doptsIdealTextColor(data['bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#bg_border_color').removeAttr('style').css({'background-color': '#'+data['bg_border_color'],
                                                                     'color': doptsIdealTextColor(data['bg_border_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnails_bg_color').removeAttr('style').css({'background-color': '#'+data['thumbnails_bg_color'],
                                                                         'color': doptsIdealTextColor(data['thumbnails_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnails_border_color').removeAttr('style').css({'background-color': '#'+data['thumbnails_border_color'],
                                                                             'color': doptsIdealTextColor(data['thumbnails_border_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnails_scroll_scrub_color').removeAttr('style').css({'background-color': '#'+data['thumbnails_scroll_scrub_color'],
                                                                                   'color': doptsIdealTextColor(data['thumbnails_scroll_scrub_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnails_scroll_bar_color').removeAttr('style').css({'background-color': '#'+data['thumbnails_scroll_bar_color'],
                                                                                 'color': doptsIdealTextColor(data['thumbnails_scroll_bar_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnail_bg_color').removeAttr('style').css({'background-color': '#'+data['thumbnail_bg_color'],
                                                                        'color': doptsIdealTextColor(data['thumbnail_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnail_bg_color_hover').removeAttr('style').css({'background-color': '#'+data['thumbnail_bg_color_hover'],
                                                                              'color': doptsIdealTextColor(data['thumbnail_bg_color_hover']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnail_border_color').removeAttr('style').css({'background-color': '#'+data['thumbnail_border_color'],
                                                                            'color': doptsIdealTextColor(data['thumbnail_border_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#thumbnail_border_color_hover').removeAttr('style').css({'background-color': '#'+data['thumbnail_border_color_hover'],
                                                                                  'color': doptsIdealTextColor(data['thumbnail_border_color_hover']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_window_color').removeAttr('style').css({'background-color': '#'+data['lightbox_window_color'],
                                                                           'color': doptsIdealTextColor(data['lightbox_window_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_bg_color').removeAttr('style').css({'background-color': '#'+data['lightbox_bg_color'],
                                                                       'color': doptsIdealTextColor(data['lightbox_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_border_color').removeAttr('style').css({'background-color': '#'+data['lightbox_border_color'],
                                                                           'color': doptsIdealTextColor(data['lightbox_border_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_navigation_info_bg_color').removeAttr('style').css({'background-color': '#'+data['lightbox_navigation_info_bg_color'],
                                                                                       'color': doptsIdealTextColor(data['lightbox_navigation_info_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_navigation_info_text_color').removeAttr('style').css({'background-color': '#'+data['lightbox_navigation_info_text_color'],
                                                                                         'color': doptsIdealTextColor(data['lightbox_navigation_info_text_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#lightbox_caption_text_color').removeAttr('style').css({'background-color': '#'+data['lightbox_caption_text_color'],
                                                                                 'color': doptsIdealTextColor(data['lightbox_caption_text_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#tooltip_bg_color').removeAttr('style').css({'background-color': '#'+data['tooltip_bg_color'],
                                                                      'color': doptsIdealTextColor(data['tooltip_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#tooltip_stroke_color').removeAttr('style').css({'background-color': '#'+data['tooltip_stroke_color'],
                                                                          'color': doptsIdealTextColor(data['tooltip_stroke_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#tooltip_text_color').removeAttr('style').css({'background-color': '#'+data['tooltip_text_color'],
                                                                        'color': doptsIdealTextColor(data['tooltip_text_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#label_bg_color').removeAttr('style').css({'background-color': '#'+data['label_bg_color'],
                                                                    'color': doptsIdealTextColor(data['label_bg_color']) == 'white' ? '#ffffff':'#0000000'});
                $jDOPTS('#label_text_color').removeAttr('style').css({'background-color': '#'+data['label_text_color'],
                                                                      'color': doptsIdealTextColor(data['label_text_color']) == 'white' ? '#ffffff':'#0000000'});
    
                $jDOPTS.post(ajaxurl, {action:'dopts_edit_scroller_settings',
                                       scroller_id: $jDOPTS('#scroller_id').val(),
                                       name: $jDOPTS('#name').val(),
                                       data_parse_method: $jDOPTS('#data_parse_method').val(),
                                       width: $jDOPTS('#width').val(),
                                       height: $jDOPTS('#height').val(),
                                       bg_color: $jDOPTS('#bg_color').val(),
                                       bg_alpha: $jDOPTS('#bg_alpha').val(),
                                       bg_border_size: $jDOPTS('#bg_border_size').val(),
                                       bg_border_color: $jDOPTS('#bg_border_color').val(),
                                       images_order: $jDOPTS('#images_order').val(),
                                       responsive_enabled: $jDOPTS('#responsive_enabled').is(':checked') ? 'true':'false',
                                       ultra_responsive_enabled: $jDOPTS('#ultra_responsive_enabled').is(':checked') ? 'true':'false',
                                       thumbnails_position: $jDOPTS('#thumbnails_position').val(),
                                       thumbnails_bg_color: $jDOPTS('#thumbnails_bg_color').val(),
                                       thumbnails_bg_alpha: $jDOPTS('#thumbnails_bg_alpha').val(),
                                       thumbnails_border_size: $jDOPTS('#thumbnails_border_size').val(),
                                       thumbnails_border_color: $jDOPTS('#thumbnails_border_color').val(),
                                       thumbnails_spacing: $jDOPTS('#thumbnails_spacing').val(),
                                       thumbnails_margin_top: $jDOPTS('#thumbnails_margin_top').val(),
                                       thumbnails_margin_right: $jDOPTS('#thumbnails_margin_right').val(),
                                       thumbnails_margin_bottom: $jDOPTS('#thumbnails_margin_bottom').val(),
                                       thumbnails_margin_left: $jDOPTS('#thumbnails_margin_left').val(),
                                       thumbnails_padding_top: $jDOPTS('#thumbnails_padding_top').val(),
                                       thumbnails_padding_right: $jDOPTS('#thumbnails_padding_right').val(),
                                       thumbnails_padding_bottom: $jDOPTS('#thumbnails_padding_bottom').val(),
                                       thumbnails_padding_left: $jDOPTS('#thumbnails_padding_left').val(),
                                       thumbnails_info: $jDOPTS('#thumbnails_info').val(),
                                       thumbnails_navigation_easing: $jDOPTS('#thumbnails_navigation_easing').val(),
                                       thumbnails_navigation_loop: $jDOPTS('#thumbnails_navigation_loop').is(':checked') ? 'true':'false',
                                       thumbnails_navigation_mouse_enabled: $jDOPTS('#thumbnails_navigation_mouse_enabled').is(':checked') ? 'true':'false',
                                       thumbnails_navigation_scroll_enabled: $jDOPTS('#thumbnails_navigation_scroll_enabled').is(':checked') ? 'true':'false',
                                       thumbnails_scroll_position: $jDOPTS('#thumbnails_scroll_position').val(),
                                       thumbnails_scroll_size: $jDOPTS('#thumbnails_scroll_size').val(),
                                       thumbnails_scroll_scrub_color: $jDOPTS('#thumbnails_scroll_scrub_color').val(),
                                       thumbnails_scroll_bar_color: $jDOPTS('#thumbnails_scroll_bar_color').val(), 
                                       thumbnails_navigation_arrows_enabled: $jDOPTS('#thumbnails_navigation_arrows_enabled').is(':checked') ? 'true':'false',
                                       thumbnails_navigation_arrows_no_items_slide: $jDOPTS('#thumbnails_navigation_arrows_no_items_slide').val(),
                                       thumbnails_navigation_arrows_speed: $jDOPTS('#thumbnails_navigation_arrows_speed').val(),
                                       thumbnails_navigation_prev: data['thumbnails_navigation_prev'],
                                       thumbnails_navigation_prev_hover: data['thumbnails_navigation_prev_hover'],
                                       thumbnails_navigation_prev_disabled: data['thumbnails_navigation_prev_disabled'],
                                       thumbnails_navigation_next: data['thumbnails_navigation_next'],
                                       thumbnails_navigation_next_hover: data['thumbnails_navigation_next_hover'],      
                                       thumbnails_navigation_next_disabled: data['thumbnails_navigation_next_disabled'],
                                       thumbnail_loader: data['thumbnail_loader'],
                                       thumbnail_width: $jDOPTS('#thumbnail_width').val(),
                                       thumbnail_height: $jDOPTS('#thumbnail_height').val(),
                                       thumbnail_alpha: $jDOPTS('#thumbnail_alpha').val(),
                                       thumbnail_alpha_hover: $jDOPTS('#thumbnail_alpha_hover').val(),
                                       thumbnail_bg_color: $jDOPTS('#thumbnail_bg_color').val(),
                                       thumbnail_bg_color_hover: $jDOPTS('#thumbnail_bg_color_hover').val(),
                                       thumbnail_border_size: $jDOPTS('#thumbnail_border_size').val(),
                                       thumbnail_border_color: $jDOPTS('#thumbnail_border_color').val(),
                                       thumbnail_border_color_hover: $jDOPTS('#thumbnail_border_color_hover').val(),
                                       thumbnail_padding_top: $jDOPTS('#thumbnail_padding_top').val(),
                                       thumbnail_padding_right: $jDOPTS('#thumbnail_padding_right').val(),
                                       thumbnail_padding_bottom: $jDOPTS('#thumbnail_padding_bottom').val(),
                                       thumbnail_padding_left: $jDOPTS('#thumbnail_padding_left').val(),
                                       lightbox_enabled: $jDOPTS('#lightbox_enabled').is(':checked') ? 'true':'false',
                                       lightbox_display_time: $jDOPTS('#lightbox_display_time').val(),
                                       lightbox_window_color: $jDOPTS('#lightbox_window_color').val(),
                                       lightbox_window_alpha: $jDOPTS('#lightbox_window_alpha').val(),
                                       lightbox_loader: data['lightbox_loader'],
                                       lightbox_bg_color: $jDOPTS('#lightbox_bg_color').val(),
                                       lightbox_bg_alpha: $jDOPTS('#lightbox_bg_alpha').val(),
                                       lightbox_border_size: $jDOPTS('#lightbox_border_size').val(),
                                       lightbox_border_color: $jDOPTS('#lightbox_border_color').val(),
                                       lightbox_caption_text_color: $jDOPTS('#lightbox_caption_text_color').val(),   
                                       lightbox_margin_top: $jDOPTS('#lightbox_margin_top').val(),
                                       lightbox_margin_right: $jDOPTS('#lightbox_margin_right').val(),
                                       lightbox_margin_bottom: $jDOPTS('#lightbox_margin_bottom').val(),
                                       lightbox_margin_left: $jDOPTS('#lightbox_margin_left').val(),
                                       lightbox_padding_top: $jDOPTS('#lightbox_padding_top').val(),
                                       lightbox_padding_right: $jDOPTS('#lightbox_padding_right').val(),
                                       lightbox_padding_bottom: $jDOPTS('#lightbox_padding_bottom').val(),
                                       lightbox_padding_left: $jDOPTS('#lightbox_padding_left').val(),
                                       lightbox_navigation_prev: data['lightbox_navigation_prev'],
                                       lightbox_navigation_prev_hover: data['lightbox_navigation_prev_hover'],
                                       lightbox_navigation_next: data['lightbox_navigation_next'],
                                       lightbox_navigation_next_hover: data['lightbox_navigation_next_hover'],
                                       lightbox_navigation_close: data['lightbox_navigation_close'],
                                       lightbox_navigation_close_hover: data['lightbox_navigation_close_hover'],
                                       lightbox_navigation_info_bg_color: $jDOPTS('#lightbox_navigation_info_bg_color').val(),
                                       lightbox_navigation_info_text_color: $jDOPTS('#lightbox_navigation_info_text_color').val(),
                                       lightbox_navigation_display_time: $jDOPTS('#lightbox_navigation_display_time').val(),
                                       lightbox_navigation_touch_device_swipe_enabled: $jDOPTS('#lightbox_navigation_touch_device_swipe_enabled').is(':checked') ? 'true':'false',                                  
                                       social_share_enabled: $jDOPTS('#social_share_enabled').is(':checked') ? 'true':'false',
                                       social_share_lightbox: data['social_share_lightbox'],
                                       tooltip_bg_color: $jDOPTS('#tooltip_bg_color').val(),
                                       tooltip_stroke_color: $jDOPTS('#tooltip_stroke_color').val(),
                                       tooltip_text_color: $jDOPTS('#tooltip_text_color').val(),
                                       label_position: $jDOPTS('#label_position').val(),  
                                       label_always_visible: $jDOPTS('#label_always_visible').is(':checked') ? 'true':'false',
                                       label_under_height: $jDOPTS('#label_under_height').val(),
                                       label_bg_color: $jDOPTS('#label_bg_color').val(),
                                       label_bg_alpha: $jDOPTS('#label_bg_alpha').val(),  
                                       label_text_color: $jDOPTS('#label_text_color').val(),  
                                       slideshow_enabled: $jDOPTS('#slideshow_enabled').is(':checked') ? 'true':'false',
                                       slideshow_time: $jDOPTS('#slideshow_time').val(),  
                                       slideshow_loop: $jDOPTS('#slideshow_loop').is(':checked') ? 'true':'false'}, function(data){
                    doptsToggleMessage('hide', DOPTS_EDIT_SCROLLER_SUCCESS);
                });
            });
        }
    }
}

function doptsDeleteScroller(id){// Delete scroller
    if (clearClick){
        if (confirm(DOPTS_DELETE_SCROLLER_CONFIRMATION)){
            doptsToggleMessage('show', DOPTS_DELETE_SCROLLER_SUBMITED);
            
            $jDOPTS.post(ajaxurl, {action:'dopts_delete_scroller', id:id}, function(data){
                doptsRemoveColumns(2);
                $jDOPTS('#DOPTS-ID-'+id).stop(true, true).animate({'opacity':0}, 600, function(){
                    $jDOPTS(this).remove();
                    
                    if (data == '0'){
                        $jDOPTS('.column-content', '.column1', '.DOPTS-admin').html('<ul><li class="no-data">'+DOPTS_NO_SCROLLERS+'</li></ul>');
                    }
                    doptsToggleMessage('hide', DOPTS_DELETE_GALERRY_SUCCESS);
                });
            });
        }
    }
}

function doptsScrollersEvents(){// Init Scroller Events.
    $jDOPTS('li', '.column1', '.DOPTS-admin').click(function(){
        if (clearClick){
            var id = $jDOPTS(this).attr('id').split('-')[2];
            
            if (currScroller != id){
                currScroller = id;
                $jDOPTS('li', '.column1', '.DOPTS-admin').removeClass('item-selected');
                $jDOPTS(this).addClass('item-selected');
                doptsShowImages(id);
            }
        }
    });
}

// Images

function doptsShowImages(scroller_id){// Show Images List.
    if (clearClick){
        $jDOPTS('#scroller_id').val(scroller_id);
        doptsRemoveColumns(2);
        doptsToggleMessage('show', DOPTS_LOAD);
        
        $jDOPTS.post(ajaxurl, {action:'dopts_show_images', scroller_id:scroller_id}, function(data){
            var HeaderHTML = new Array();
            HeaderHTML.push('<div class="add-button">');
            HeaderHTML.push('    <a href="javascript:doptsAddImages()" title="'+DOPTS_ADD_IMAGE_SUBMIT+'"></a>');
            HeaderHTML.push('</div>');
            HeaderHTML.push('<div class="edit-button">');
            HeaderHTML.push('    <a href="javascript:doptsShowScrollerSettings()" title="'+DOPTS_EDIT_SCROLLER_SUBMIT+'"></a>');
            HeaderHTML.push('</div>');
            HeaderHTML.push('<div class="actions-container">');
            HeaderHTML.push('   <select name="DOPTS-scroller-actions" id="DOPTS-scroller-actions">');
            HeaderHTML.push('       <option value="">- '+DOPTS_SELECT_ACTION+' -</option>');
            HeaderHTML.push('       <option value="delete">'+DOPTS_DELETE+'</option>');
            HeaderHTML.push('       <option value="enable">'+DOPTS_ENABLE+'</option>');
            HeaderHTML.push('       <option value="disable">'+DOPTS_DISABLE+'</option>');
            HeaderHTML.push('   </select>');
            HeaderHTML.push('   <input type="button" name="DOPTS_image_delete" class="submit-style" onclick="doptsEditImages()" value="'+DOPTS_APPLY+'">');
            HeaderHTML.push('</div>');
            HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPTS_SCROLLER_EDIT_HELP+'</span></a>');
            
            $jDOPTS('.column-header', '.column2', '.DOPTS-admin').html(HeaderHTML.join(''));
            $jDOPTS('.column-content', '.column2', '.DOPTS-admin').html(data);
            $jDOPTS('.column-content', '.column2', '.DOPTS-admin').DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png'});
            doptsImagesEvents();
            doptsToggleMessage('hide', DOPTS_IMAGES_LOADED);
        });
    }
}

function doptsImagesEvents(){// Init Images Events.
    $jDOPTS('.item-image', '.column2', '.DOPTS-admin').each(function(){
        var id = $jDOPTS(this).attr('id').split('-')[3];
        
        $jDOPTS(this).prepend('<div class="checkbox-container"><input type="checkbox" name="DOPTS-image-ID-check-'+id+'" id="DOPTS-image-ID-check-'+id+'" /></div>');
    });
    
    $jDOPTS('.DOPTS-admin .column2 .item-image input').unbind('click');
    $jDOPTS('.DOPTS-admin .column2 .item-image input').bind('click', function(){
        clearClick = false;
        
        setTimeout(function(){
            clearClick = true;
        }, 10);
    });
    
    $jDOPTS('.item-image', '.column2', '.DOPTS-admin').unbind('click');
    $jDOPTS('.item-image', '.column2', '.DOPTS-admin').bind('click', function(){
        var id = $jDOPTS(this).attr('id').split('-')[3];
        
        if (currImage != id && clearClick){
            $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
            $jDOPTS(this).addClass('item-image-selected');
            doptsShowImage(id);
        }
    });

    $jDOPTS('ul', '.column2').sortable({opacity:0.6, cursor:'move', update:function(){
        if (clearClick){
            var data = '';
            
            doptsToggleMessage('show', DOPTS_SORT_IMAGES_SUBMITED);
            $jDOPTS('li', '.column2', '.DOPTS-admin').each(function(){
                data += $jDOPTS(this).attr('id').split('-')[3]+',';
            });
            $jDOPTS.post(ajaxurl, {action:'dopts_sort_images', scroller_id:$jDOPTS('#scroller_id').val(), data:data}, function(data){
                doptsToggleMessage('hide', DOPTS_SORT_IMAGES_SUCCESS);
            });
        }
    },
    stop:function(){
        $jDOPTS('li', '.column2').removeAttr('style');
    }});
}

function doptsAddImages(){// Add Image/Images.
    if (clearClick){
        $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
        doptsRemoveColumns(3);
        
        var uploadifyHTML = new Array(), HeaderHTML = new Array();
        HeaderHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_ADD_IMAGES_HELP+'</span></a>');

        uploadifyHTML.push('<h3 class="settings">'+DOPTS_ADD_IMAGE_WP_UPLOAD+'</h3>');
        uploadifyHTML.push('<input name="dopts_wp_image" id="dopts_wp_image" type="button" value="'+DOPTS_SELECT_IMAGES+'" class="select-images" />');
        uploadifyHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_ADD_IMAGES_HELP_WP+'</span></a><br class="DOPTS-clear" />');

        uploadifyHTML.push('<h3 class="settings">'+DOPTS_ADD_IMAGE_SIMPLE_UPLOAD+'</h3>');
        uploadifyHTML.push('<form action="'+DOPTS_plugin_url+'libraries/php/upload.php?path='+DOPTS_plugin_abs+'" method="post" enctype="multipart/form-data" id="dopts_ajax_upload_form" name="dopts_ajax_upload_form" target="dopts_upload_target" onsubmit="doptsUploadImage()" >');
        uploadifyHTML.push('    <input name="dopts_image" type="file" onchange="$jDOPTS(\'#dopts_ajax_upload_form\').submit(); return false;" style="margin:5px 0 0 10px"; />');
        uploadifyHTML.push('    <a href="javascript:void()" class="header-help last"><span>'+DOPTS_ADD_IMAGES_HELP_AJAX+'</span></a><br class="DOPTS-clear" />');
        uploadifyHTML.push('</form>');
        uploadifyHTML.push('<iframe id="dopts_upload_target" name="dopts_upload_target" src="javascript:void(0)" style="display: none;"></iframe>');
        
        uploadifyHTML.push('<h3 class="settings">'+DOPTS_ADD_IMAGE_MULTIPLE_UPLOAD+'</h3>');
        uploadifyHTML.push('<div class="uploadifyContainer" style="float:left; margin-top:5px;">');
        uploadifyHTML.push('    <div><input type="file" name="uploadify" id="uploadify" style="width:100px;" /></div>');
        uploadifyHTML.push('    <div id="fileQueue"></div>');
        uploadifyHTML.push('</div>');
        uploadifyHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_ADD_IMAGES_HELP_UPLOADIFY+'</span></a><br class="DOPTS-clear" />');  
        
        uploadifyHTML.push('<h3 class="settings">'+DOPTS_ADD_IMAGE_FTP_UPLOAD+'</h3>');
        uploadifyHTML.push('<input name="dopts_ftp_image" id="dopts_ftp_image" type="button" value="'+DOPTS_SELECT_FTP_IMAGES+'" class="select-images" />');
        uploadifyHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_ADD_IMAGES_HELP_FTP+'</span></a><br class="DOPTS-clear" />');

        $jDOPTS('.column-header', '.column3', '.DOPTS-admin').html(HeaderHTML.join(''));
        $jDOPTS('.column-content', '.column3', '.DOPTS-admin').html(uploadifyHTML.join(''));
        
        // Add Images from WP Media.
        
        $jDOPTS('#dopts_wp_image').click(function(){
            if (clearClick){
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            }
            return false;                
        });

        window.send_to_editor = function(html){
            doptsToggleMessage('show', DOPTS_ADD_IMAGE_SUBMITED);

            setTimeout(function(){
                doptsResize();
            }, 100);
            
            $jDOPTS.post(ajaxurl, {action:'dopts_add_image_wp', scroller_id:$jDOPTS('#scroller_id').val(), image_url:$jDOPTS('img', html).attr('src')}, function(data){
                var imageID = data.split(';;;')[0],
                imageName = data.split(';;;')[1];
                
                if ($jDOPTS('ul', '.column2', '.DOPTS-admin').html() == '<li class="no-data">'+DOPTS_NO_IMAGES+'</li>'){
                    $jDOPTS('ul', '.column2', '.DOPTS-admin').html('<li class="item-image" id="DOPTS-image-ID-'+imageID+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+imageName+'" alt="" /></li>');
                    doptsImagesEvents();
                }
                else{
                    $jDOPTS('ul', '.column2', '.DOPTS-admin').append('<li class="item-image" id="DOPTS-image-ID-'+imageID+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+imageName+'" alt="" /></li>');
                }

                doptsResize();
                $jDOPTS('#DOPTS-image-ID-'+imageID).DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png'});
                $jDOPTS('#DOPTS-image-ID-'+imageID).prepend('<div class="checkbox-container"><input type="checkbox" name="DOPTS-image-ID-check-'+imageID+'" id="DOPTS-image-ID-check-'+imageID+'" /></div>');

                $jDOPTS('#DOPTS-image-ID-'+imageID+' input').unbind('click');
                $jDOPTS('#DOPTS-image-ID-'+imageID+' input').bind('click', function(){
                    clearClick = false;

                    setTimeout(function(){
                        clearClick = true;
                    }, 10);
                });

                $jDOPTS('#DOPTS-image-ID-'+imageID).unbind('click');
                $jDOPTS('#DOPTS-image-ID-'+imageID).bind('click', function(){
                    var id = $jDOPTS(this).attr('id').split('-')[3];

                    if (currImage != id && clearClick){
                        $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
                        $jDOPTS(this).addClass('item-image-selected');
                        doptsShowImage(id);
                    }
                });
                
                doptsToggleMessage('hide', DOPTS_ADD_IMAGE_SUCCESS);
            });
            
            tb_remove();
        }

        // Add Images width Uploadify.
        
        $jDOPTS('#uploadify').uploadify({
            'uploader'       : DOPTS_plugin_url+'libraries/swf/uploadify.swf',
            'script'         : DOPTS_plugin_url+'libraries/php/uploadify.php?path='+DOPTS_plugin_abs,
            'cancelImg'      : DOPTS_plugin_url+'libraries/gui/images/uploadify/cancel.png',
            'folder'         : '',
            'queueID'        : 'fileQueue',
            'buttonText'     : DOPTS_SELECT_IMAGES,
            'auto'           : true,
            'multi'          : true,
            'onError'        : function (event,ID,fileObj,errorObj){
                                    alert(errorObj.type + ' Error: ' + errorObj.info);
                               },
            'onInit'         : function(){
                                   doptsResize();
                               },
            'onCancel'         : function(event,ID,fileObj,data){
                                   doptsResize();
                               },
            'onSelect'       : function(event, ID, fileObj){
                                   clearClick = false;
                                   doptsToggleMessage('show', DOPTS_ADD_IMAGE_SUBMITED);
                                   setTimeout(function(){
                                       doptsResize();
                                   }, 100);
                               },
            'onComplete'     : function(event, ID, fileObj, response, data){                           
                                   if (response != '-1'){
                                       setTimeout(function(){
                                           doptsResize();
                                       }, 1000);
                                       
                                       $jDOPTS.post(ajaxurl, {action:'dopts_add_image', scroller_id:$jDOPTS('#scroller_id').val(), name:response}, function(data){
                                           if ($jDOPTS('ul', '.column2', '.DOPTS-admin').html() == '<li class="no-data">'+DOPTS_NO_IMAGES+'</li>'){
                                               $jDOPTS('ul', '.column2', '.DOPTS-admin').html('<li class="item-image" id="DOPTS-image-ID-'+data+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+response+'" alt="" /></li>');
                                               doptsImagesEvents();
                                           }
                                           else{
                                               $jDOPTS('ul', '.column2', '.DOPTS-admin').append('<li class="item-image" id="DOPTS-image-ID-'+data+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+response+'" alt="" /></li>');
                                           }
                                           
                                           doptsResize();
                                           $jDOPTS('#DOPTS-image-ID-'+data).DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png'});
                                           $jDOPTS('#DOPTS-image-ID-'+data).prepend('<div class="checkbox-container"><input type="checkbox" name="DOPTS-image-ID-check-'+data+'" id="DOPTS-image-ID-check-'+data+'" /></div>');

                                           $jDOPTS('#DOPTS-image-ID-'+data+' input').unbind('click');
                                           $jDOPTS('#DOPTS-image-ID-'+data+' input').bind('click', function(){
                                               clearClick = false;

                                               setTimeout(function(){
                                                   clearClick = true;
                                               }, 10);
                                           });

                                           $jDOPTS('#DOPTS-image-ID-'+data).unbind('click');
                                           $jDOPTS('#DOPTS-image-ID-'+data).bind('click', function(){
                                               var id = $jDOPTS(this).attr('id').split('-')[3];
                                              
                                               if (currImage != id && clearClick){
                                                   $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
                                                   $jDOPTS(this).addClass('item-image-selected');
                                                   doptsShowImage(id);
                                               }
                                           });
                                       });
                                   }
                               },
            'onAllComplete'  : function(event, data){
                                   doptsToggleMessage('hide', DOPTS_ADD_IMAGE_SUCCESS);
                               }
        });
        
        // Add Images from FTP.
                
        $jDOPTS('#dopts_ftp_image').click(function(){
            if (clearClick){
                doptsToggleMessage('show', DOPTS_ADD_IMAGE_SUBMITED);

                $jDOPTS.post(ajaxurl, {action:'dopts_add_image_ftp', scroller_id:$jDOPTS('#scroller_id').val()}, function(data){
                    var images = data.split(';;;;;'), 
                    i, imageName, imageID;

                    for (i=0; i<images.length; i++){
                        imageID = images[i].split(';;;')[0];
                        imageName = images[i].split(';;;')[1];

                        if ($jDOPTS('ul', '.column2', '.DOPTS-admin').html() == '<li class="no-data">'+DOPTS_NO_IMAGES+'</li>'){
                            $jDOPTS('ul', '.column2', '.DOPTS-admin').html('<li class="item-image" id="DOPTS-image-ID-'+imageID+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+imageName+'" alt="" /></li>');
                            doptsImagesEvents();
                        }
                        else{
                            $jDOPTS('ul', '.column2', '.DOPTS-admin').append('<li class="item-image" id="DOPTS-image-ID-'+imageID+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+imageName+'" alt="" /></li>');
                        }

                        doptsResize();
                        $jDOPTS('#DOPTS-image-ID-'+imageID).DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png'});
                        $jDOPTS('#DOPTS-image-ID-'+imageID).prepend('<div class="checkbox-container"><input type="checkbox" name="DOPTS-image-ID-check-'+imageID+'" id="DOPTS-image-ID-check-'+imageID+'" /></div>');

                        $jDOPTS('#DOPTS-image-ID-'+imageID+' input').unbind('click');
                        $jDOPTS('#DOPTS-image-ID-'+imageID+' input').bind('click', function(){
                            clearClick = false;

                            setTimeout(function(){
                                clearClick = true;
                            }, 10);
                        });

                        $jDOPTS('#DOPTS-image-ID-'+imageID).unbind('click');
                        $jDOPTS('#DOPTS-image-ID-'+imageID).bind('click', function(){
                            var id = $jDOPTS(this).attr('id').split('-')[3];

                            if (currImage != id && clearClick){
                                $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
                                $jDOPTS(this).addClass('item-image-selected');
                                doptsShowImage(id);
                            }
                        });
                    }

                    doptsToggleMessage('hide', DOPTS_ADD_IMAGE_SUCCESS);
                });            
            }
        });

        doptsResize();
    }
}

function doptsUploadImage(){
    doptsToggleMessage('show', DOPTS_ADD_IMAGE_SUBMITED);
}

function doptsUploadImageSuccess(response){
    if (response != '-1'){
        setTimeout(function(){
            doptsResize();
        }, 1000);
        $jDOPTS.post(ajaxurl, {action:'dopts_add_image', scroller_id:$jDOPTS('#scroller_id').val(), name:response}, function(data){
            if ($jDOPTS('ul', '.column2', '.DOPTS-admin').html() == '<li class="no-data">'+DOPTS_NO_IMAGES+'</li>'){
                $jDOPTS('ul', '.column2', '.DOPTS-admin').html('<li class="item-image" id="DOPTS-image-ID-'+data+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+response+'" alt="" /></li>');
                doptsImagesEvents();
            }
            else{
                $jDOPTS('ul', '.column2', '.DOPTS-admin').append('<li class="item-image" id="DOPTS-image-ID-'+data+'"><img src="'+DOPTS_plugin_url+'uploads/thumbs/'+response+'" alt="" /></li>');
            }
            
            doptsResize();
            $jDOPTS('#DOPTS-image-ID-'+data).DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png'});
            $jDOPTS('#DOPTS-image-ID-'+data).prepend('<div class="checkbox-container"><input type="checkbox" name="DOPTS-image-ID-check-'+data+'" id="DOPTS-image-ID-check-'+data+'" /></div>');
    
            $jDOPTS('#DOPTS-image-ID-'+data+' input').unbind('click');
            $jDOPTS('#DOPTS-image-ID-'+data+' input').bind('click', function(){
                clearClick = false;

                setTimeout(function(){
                    clearClick = true;
                }, 10);
            });
    
            $jDOPTS('#DOPTS-image-ID-'+data).unbind('click');
            $jDOPTS('#DOPTS-image-ID-'+data).bind('click', function(){
                var id = $jDOPTS(this).attr('id').split('-')[3];
                
                if (currImage != id && clearClick){
                    $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
                    $jDOPTS(this).addClass('item-image-selected');
                    doptsShowImage(id);
                }
            });
            
            doptsToggleMessage('hide', DOPTS_ADD_IMAGE_SUCCESS);
        });
    }
    else{
        doptsToggleMessage('hide', DOPTS_ADD_IMAGE_SUCCESS);        
    }
}

function doptsEditImages(){
    if (clearClick && $jDOPTS('#DOPTS-scroller-actions').val() != ''){
        var images = new Array(), i, noImages = 0,
        confirmationMessage, actionMessage;
        
        switch ($jDOPTS('#DOPTS-scroller-actions').val()){
            case 'delete':
                confirmationMessage = DOPTS_DELETE_IMAGES_CONFIRMATION;
                actionMessage = DOPTS_DELETE_IMAGES_SUBMITED;
                break;    
            case 'enable':
                confirmationMessage = DOPTS_ENABLE_IMAGES_CONFIRMATION;
                actionMessage = DOPTS_ENABLE_IMAGES_SUBMITED;
                break;
            case 'disable':
                confirmationMessage = DOPTS_DISABLE_IMAGES_CONFIRMATION;
                actionMessage = DOPTS_DISABLE_IMAGES_SUBMITED;
                break;
        }
        
        $jDOPTS('.DOPTS-admin .column2 li input').each(function(){
            var id = $jDOPTS(this).attr('id').split('-')[4];

            if ($jDOPTS('#DOPTS-image-ID-check-'+id).is(':checked')){
                images.push(id);
            }
            noImages++;
        });
        
        if (images.length > 0 && confirm(confirmationMessage)){
            doptsRemoveColumns(3);
            $jDOPTS('li', '.column2', '.DOPTS-admin').removeClass('item-image-selected');
            doptsToggleMessage('show', actionMessage);

            $jDOPTS.post(ajaxurl, {action: 'dopts_edit_images',
                                   images_action: $jDOPTS('#DOPTS-scroller-actions').val(),
                                   images: images}, function(data){
                switch ($jDOPTS('#DOPTS-scroller-actions').val()){
                    case 'delete':
                        for (i=0; i<images.length; i++){
                            $jDOPTS('#DOPTS-image-ID-check-'+images[i]).removeAttr('checked');
                            $jDOPTS('#DOPTS-image-ID-'+images[i]).animate({'opacity':0}, 600, function(){
                                $jDOPTS(this).remove();
                                doptsResize();
                            });
                        }

                        if (noImages <= images.length){
                            setTimeout(function(){
                                $jDOPTS('.column-content', '.column2', '.DOPTS-admin').html('<ul><li class="no-data">'+DOPTS_NO_IMAGES+'</li></ul>');
                                doptsResize();
                            }, 700);
                        }
                        doptsToggleMessage('hide', DOPTS_DELETE_IMAGES_SUCCESS);
                        break;    
                    case 'enable':
                        for (i=0; i<images.length; i++){
                            $jDOPTS('#DOPTS-image-ID-check-'+images[i]).removeAttr('checked');
                            $jDOPTS('#DOPTS-image-ID-'+images[i]).removeClass('item-image-disabled');
                        }
                        doptsToggleMessage('hide', DOPTS_ENABLE_IMAGES_SUCCESS);
                        break;
                    case 'disable':
                        for (i=0; i<images.length; i++){
                            $jDOPTS('#DOPTS-image-ID-check-'+images[i]).removeAttr('checked');
                            $jDOPTS('#DOPTS-image-ID-'+images[i]).addClass('item-image-disabled');
                        }
                        doptsToggleMessage('hide', DOPTS_DISABLE_IMAGES_SUCCESS);
                        break;
                }
        
                $jDOPTS('#DOPTS-scroller-actions option[value=""]').attr('selected', 'selected');
            });
        }
    }
}

function doptsShowImage(id){// Show Image Details.
    if (clearClick){
        doptsRemoveColumns(3);
        currImage = id;
        doptsToggleMessage('show', DOPTS_LOAD);
        
        $jDOPTS.post(ajaxurl, {action:'dopts_show_image', image_id:id}, function(data){            
            var json = $jDOPTS.parseJSON(data),
            HeaderHTML = new Array(), HTML = new Array();
            
            HeaderHTML.push('<input type="button" name="DOPTS_image_submit" class="submit-style" onclick="doptsEditImage('+json['id']+')" title="'+DOPTS_EDIT_IMAGE_SUBMIT+'" value="'+DOPTS_SUBMIT+'" />');
            HeaderHTML.push('<input type="button" name="DOPTS_image_delete" class="submit-style" onclick="doptsDeleteImage('+json['id']+')" title="'+DOPTS_DELETE_IMAGE_SUBMIT+'" value="'+DOPTS_DELETE+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPTS_IMAGE_EDIT_HELP+'</span></a>');

            HTML.push('<input type="hidden" name="crop_x" id="crop_x" value="0" />');
            HTML.push('<input type="hidden" name="crop_y" id="crop_y" value="0" />');
            HTML.push('<input type="hidden" name="crop_width" id="crop_width" value="0" />');
            HTML.push('<input type="hidden" name="crop_height" id="crop_height" value="0" />');
            HTML.push('<input type="hidden" name="image_width" id="image_width" value="0" />');
            HTML.push('<input type="hidden" name="image_height" id="image_height" value="0" />');
            HTML.push('<input type="hidden" name="image_name" id="image_name" value="'+json['name']+'" />');
            HTML.push('<input type="hidden" name="thumb_width" id="thumb_width" value="'+json['thumbnail_width']+'" />');
            HTML.push('<input type="hidden" name="thumb_height" id="thumb_height" value="'+json['thumbnail_height']+'" />');
            HTML.push('<div class="column-image">');
            HTML.push('    <img src="'+DOPTS_plugin_url+'uploads/'+json['name']+'" alt="" />');
            HTML.push('</div>');
            HTML.push('<div class="column-thumbnail-left">');
            HTML.push('    <label class="label">'+DOPTS_EDIT_IMAGE_CROP_THUMBNAIL+'</label>');
            HTML.push('    <div class="column-thumbnail" style="width:'+json['thumbnail_width']+'px; height:'+json['thumbnail_height']+'px;">');
            HTML.push('        <img src="'+DOPTS_plugin_url+'uploads/'+json['name']+'" style="width:'+json['thumbnail_width']+'px; height:'+json['thumbnail_height']+'px;" alt="" />');
            HTML.push('    </div>');
            HTML.push('</div>');
            HTML.push('<div class="column-thumbnail-right">');
            HTML.push('    <label class="label">'+DOPTS_EDIT_IMAGE_CURRENT_THUMBNAIL+'</label>');
            HTML.push('    <div class="column-thumbnail" id="DOPTS-curr-thumb" style="float: right; width:'+json['thumbnail_width']+'px; height:'+json['thumbnail_height']+'px;">');
            HTML.push('        <img src="'+DOPTS_plugin_url+'uploads/thumbs/'+json['name']+'?cacheBuster='+doptsRandomString(64)+'" style="width:'+json['thumbnail_width']+'px; height:'+json['thumbnail_height']+'px;" alt="" />');
            HTML.push('    </div>');
            HTML.push('</div>');
            HTML.push('<br class="DOPTS-clear" />');
            HTML.push('<label class="label" for="image_title">'+DOPTS_EDIT_IMAGE_TITLE+'</label>');
            HTML.push('<input type="text" class="column-input" name="image_title" id="image_title" value="'+json['title']+'" />');
            HTML.push('<label class="label" for="image_video">'+DOPTS_EDIT_IMAGE_CAPTION+'</label>');
            HTML.push('<textarea class="column-input" name="image_caption" id="image_caption" cols="" rows="6">'+json['caption']+'</textarea>');
            HTML.push('<label class="label" for="image_video">'+DOPTS_EDIT_IMAGE_MEDIA+'</label>');
            HTML.push('<textarea class="column-input" name="image_media" id="image_media" cols="" rows="6">'+json['media']+'</textarea>');
            HTML.push('<label class="label" for="image_video">'+DOPTS_EDIT_IMAGE_LIGHTBOX_MEDIA+'</label>');
            HTML.push('<textarea class="column-input" name="image_lightbox_media" id="image_lightbox_media" cols="" rows="6">'+json['lightbox_media']+'</textarea>');
            HTML.push('<label class="label" for="image_link">'+DOPTS_EDIT_IMAGE_LINK+'</label>');
            HTML.push('<input type="text" class="column-input" name="image_link" id="image_link" value="'+json['link']+'" />');
            HTML.push('<label class="label" for="image_link_target">'+DOPTS_EDIT_IMAGE_LINK_TARGET+'</label>');
            HTML.push('<select class="column-select" name="image_link_target" id="image_link_target">');
            if (json['target'] == '_self'){
                HTML.push('<option value="_blank">_blank</option>');
                HTML.push('<option value="_self" selected="selected">_self</option>');
                HTML.push('<option value="_parent">_parent</option>');
                HTML.push('<option value="_top">_top</option>');
            }
            else if (json['target'] == '_parent'){
                HTML.push('<option value="_blank">_blank</option>');
                HTML.push('<option value="_self">_self</option>');
                HTML.push('<option value="_parent" selected="selected">_parent</option>');
                HTML.push('<option value="_top">_top</option>');
            }
            else if (json['target'] == '_top'){
                HTML.push('<option value="_blank">_blank</option>');
                HTML.push('<option value="_self">_self</option>');
                HTML.push('<option value="_parent">_parent</option>');
                HTML.push('<option value="_top" selected="selected">_top</option>');
            }
            else{
                HTML.push('<option value="_blank" selected="selected">_blank</option>');
                HTML.push('<option value="_self">_self</option>');
                HTML.push('<option value="_parent">_parent</option>');
                HTML.push('<option value="_top">_top</option>');
            }
            HTML.push('</select>');
            HTML.push('<label class="label" for="image_enabled">'+DOPTS_EDIT_IMAGE_ENABLED+'</label>');
            HTML.push('<select class="column-select" name="image_enabled" id="image_enabled">');
            if (json['enabled'] == 'true'){
                HTML.push('<option value="true" selected="selected">true</option>');
                HTML.push('<option value="false">false</option>');
            }
            else{
                HTML.push('<option value="true">true</option>');
                HTML.push('<option value="false" selected="selected">false</option>');
            }
            HTML.push('</select>');


            $jDOPTS('.column-header', '.column3', '.DOPTS-admin').html(HeaderHTML.join(''));
            $jDOPTS('.column-content', '.column3', '.DOPTS-admin').html(HTML.join(''));
            doptsResize();
            $jDOPTS('.column-image', '.DOPTS-admin').DOPImageLoader({'LoaderURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/loader.gif', 'NoImageURL': DOPTS_plugin_url+'libraries/gui/images/image-loader/no-image.png', 'SuccessCallback': 'doptsInitJcrop()'});
            
            doptsToggleMessage('hide', DOPTS_IMAGE_LOADED);
        });
    }
}

function doptsInitJcrop(){// Init Jcrop. (For croping thumbnails)
    imageDisplay = true;
    imageWidth = $jDOPTS('img', '.column-image', '.DOPTS-admin').width();
    imageHeight = $jDOPTS('img', '.column-image', '.DOPTS-admin').height();
    doptsResize();
    $jDOPTS('img', '.column-image', '.DOPTS-admin').Jcrop({onChange: doptsShowCropPreview, onSelect: doptsShowCropPreview, aspectRatio: $jDOPTS('.column-thumbnail', '.DOPTS-admin').width()/$jDOPTS('.column-thumbnail', '.DOPTS-admin').height(), minSize: [$jDOPTS('.column-thumbnail', '.DOPTS-admin').width(), $jDOPTS('.column-thumbnail', '.DOPTS-admin').height()]});
    setTimeout(function(){
        doptsResize();        
    }, 1000);
}

function doptsShowCropPreview(coords){// Select thumbnail with Jcrop.
    if (parseInt(coords.w) > 0){
        $jDOPTS('#crop_x').val(coords.x);
        $jDOPTS('#crop_y').val(coords.y);
        $jDOPTS('#crop_width').val(coords.w);
        $jDOPTS('#crop_height').val(coords.h);
        $jDOPTS('#image_width').val($jDOPTS('img', '.column-image', '.DOPTS-admin').width());
        $jDOPTS('#image_height').val($jDOPTS('img', '.column-image', '.DOPTS-admin').height());

        var rx = $jDOPTS('.column-thumbnail', '.DOPTS-admin').width()/coords.w;
        var ry = $jDOPTS('.column-thumbnail', '.DOPTS-admin').height()/coords.h;

        $jDOPTS('img', '.column-thumbnail-left', '.DOPTS-admin').css({
            width: Math.round(rx*$jDOPTS('img', '.column-image', '.DOPTS-admin').width()) + 'px',
            height: Math.round(ry*$jDOPTS('img', '.column-image', '.DOPTS-admin').height()) + 'px',
            marginLeft: '-'+Math.round(rx * coords.x)+'px',
            marginTop: '-'+Math.round(ry * coords.y)+'px'
        });
    }
}

function doptsEditImage(id){// Edit Image Details.
    if (clearClick){
        doptsToggleMessage('show', DOPTS_SAVE);
        
        $jDOPTS.post(ajaxurl, {action:'dopts_edit_image',
                               image_id:id,
                               crop_x: $jDOPTS('#crop_x').val(),
                               crop_y: $jDOPTS('#crop_y').val(),
                               crop_width: $jDOPTS('#crop_width').val(),
                               crop_height: $jDOPTS('#crop_height').val(),
                               image_width: $jDOPTS('#image_width').val(),
                               image_height: $jDOPTS('#image_height').val(),
                               image_name: $jDOPTS('#image_name').val(),
                               thumb_width: $jDOPTS('#thumb_width').val(),
                               thumb_height: $jDOPTS('#thumb_height').val(),
                               image_title: $jDOPTS('#image_title').val(),
                               image_caption: $jDOPTS('#image_caption').val(),
                               image_media: $jDOPTS('#image_media').val(),
                               image_lightbox_media: $jDOPTS('#image_lightbox_media').val(),
                               image_link: $jDOPTS('#image_link').val(),
                               image_link_target: $jDOPTS('#image_link_target').val(),
                               image_enabled: $jDOPTS('#image_enabled').val()}, function(data){
            doptsToggleMessage('hide', DOPTS_EDIT_IMAGE_SUCCESS);
            if ($jDOPTS('#image_enabled').val() == 'true'){
                $jDOPTS('#DOPTS-image-ID-'+id).removeClass('item-image-disabled');
            }
            else{
                $jDOPTS('#DOPTS-image-ID-'+id).addClass('item-image-disabled');
            }
            if (data != ''){
                $jDOPTS('#DOPTS-curr-thumb').html('<img src="'+data+'?cacheBuster='+doptsRandomString(64)+'" style="width:'+$jDOPTS('#thumb_width').val()+'px; height:'+$jDOPTS('#thumb_height').val()+'px;" alt="" />');
            }
        });
    }
}

function doptsDeleteImage(id){// Delete Image.
    if (clearClick){
        if (confirm(DOPTS_DELETE_IMAGE_CONFIRMATION)){
            doptsToggleMessage('show', DOPTS_DELETE_IMAGE_SUBMITED);
            
            $jDOPTS.post(ajaxurl, {action:'dopts_delete_image',
                             image_id: id}, function(data){
                doptsRemoveColumns(3);
                
                $jDOPTS('#DOPTS-image-ID-'+id).stop(true, true).animate({'opacity':0}, 600, function(){
                    $jDOPTS(this).remove();
                    doptsToggleMessage('hide', DOPTS_DELETE_GALERRY_SUCCESS);
                    
                    if (data == '0'){
                        $jDOPTS('.column-content', '.column2', '.DOPTS-admin').html('<ul><li class="no-data">'+DOPTS_NO_IMAGES+'</li></ul>');
                    }
                    doptsResize();
                });
            });
        }
    }
}

// Settings

function doptsSettingsForm(data, column){// Settings Form.
    var HTML = new Array();
    
    HTML.push('<form method="post" class="settings" action="" onsubmit="return false;">');

// General Styles & Settings
    HTML.push('    <h3 class="settings">'+DOPTS_GENERAL_STYLES_SETTINGS+'</h3>');    
    
    if ($jDOPTS('#scroller_id').val() != '0'){
        HTML.push(doptsSettingsFormInput('name', data['name'], DOPTS_SCROLLER_NAME, '', '', '', 'help', DOPTS_SCROLLER_NAME_INFO));
    }    
    else{
        HTML.push('<input type="hidden" name="name" id="name" value="'+data['name']+'" />');
        HTML.push(doptsSettingsFormSelect('data_parse_method', data['data_parse_method'], DOPTS_DATA_PARSE_METHOD, '', '', '', 'help', DOPTS_DATA_PARSE_METHOD_INFO, 'ajax;;html', 'AJAX;;HTML'));
    }
    
    HTML.push(doptsSettingsFormInput('width', data['width'], DOPTS_WIDTH, '', 'px', 'small', 'help-small', DOPTS_WIDTH_INFO));
    HTML.push(doptsSettingsFormInput('height', data['height'], DOPTS_HEIGHT, '', 'px', 'small', 'help-small', DOPTS_HEIGHT_INFO));
    HTML.push(doptsSettingsFormInput('bg_color', data['bg_color'], DOPTS_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_BG_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('bg_alpha', data['bg_alpha'], DOPTS_BG_ALPHA, '', '', 'small', 'help-small', DOPTS_BG_ALPHA_INFO));
    HTML.push(doptsSettingsFormInput('bg_border_size', data['bg_border_size'], DOPTS_BG_BORDER_SIZE, '', 'px', 'small', 'help-small', DOPTS_BG_BORDER_SIZE_INFO));
    HTML.push(doptsSettingsFormInput('bg_border_color', data['bg_border_color'], DOPTS_BG_BORDER_COLOR, '#', '', 'small', 'help-small', DOPTS_BG_BORDER_COLOR_INFO));
    HTML.push(doptsSettingsFormSelect('images_order', data['images_order'], DOPTS_IMAGES_ORDER, '', '', '', 'help', DOPTS_IMAGES_ORDER_INFO, 'normal;;random', DOPTS_FORM_NORMAL_TEXT+';;'+DOPTS_FORM_RANDOM_TEXT));
    HTML.push(doptsSettingFormSwitch('responsive_enabled', data['responsive_enabled'], DOPTS_RESPONSIVE_ENABLED, '', '', 'help', DOPTS_RESPONSIVE_ENABLED_INFO));
    HTML.push(doptsSettingFormSwitch('ultra_responsive_enabled', data['ultra_responsive_enabled'], DOPTS_ULTRA_RESPONSIVE_ENABLED, '', '', 'help', DOPTS_ULTRA_RESPONSIVE_ENABLED_INFO));
   
// Thumbnails Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_THUMBNAILS_STYLES_SETTINGS+'</h3>');        
    
    HTML.push(doptsSettingsFormSelect('thumbnails_position', data['thumbnails_position'], DOPTS_THUMBNAILS_POSITION, '', '', '', 'help', DOPTS_THUMBNAILS_POSITION_INFO, 'horizontal;;vertical', DOPTS_FORM_HORIZONTAL_TEXT+';;'+DOPTS_FORM_VERTICAL_TEXT));
    HTML.push(doptsSettingsFormInput('thumbnails_bg_color', data['thumbnails_bg_color'], DOPTS_THUMBNAILS_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAILS_BG_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_bg_alpha', data['thumbnails_bg_alpha'], DOPTS_THUMBNAILS_BG_ALPHA, '', '', 'small', 'help-small', DOPTS_THUMBNAILS_BG_ALPHA_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_border_size', data['thumbnails_border_size'], DOPTS_THUMBNAILS_BORDER_SIZE, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_BORDER_SIZE_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_border_color', data['thumbnails_border_color'], DOPTS_THUMBNAILS_BORDER_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAILS_BORDER_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_spacing', data['thumbnails_spacing'], DOPTS_THUMBNAILS_SPACING, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_SPACING_INFO));    
    HTML.push(doptsSettingsFormInput('thumbnails_margin_top', data['thumbnails_margin_top'], DOPTS_THUMBNAILS_MARGIN_TOP, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_MARGIN_TOP_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_margin_right', data['thumbnails_margin_right'], DOPTS_THUMBNAILS_MARGIN_RIGHT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_MARGIN_RIGHT_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_margin_bottom', data['thumbnails_margin_bottom'], DOPTS_THUMBNAILS_MARGIN_BOTTOM, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_MARGIN_BOTTOM_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_margin_left', data['thumbnails_margin_left'], DOPTS_THUMBNAILS_MARGIN_LEFT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_MARGIN_LEFT_INFO));    
    HTML.push(doptsSettingsFormInput('thumbnails_padding_top', data['thumbnails_padding_top'], DOPTS_THUMBNAILS_PADDING_TOP, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_PADDING_TOP_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_padding_right', data['thumbnails_padding_right'], DOPTS_THUMBNAILS_PADDING_RIGHT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_PADDING_RIGHT_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_padding_bottom', data['thumbnails_padding_bottom'], DOPTS_THUMBNAILS_PADDING_BOTTOM, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_PADDING_BOTTOM_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_padding_left', data['thumbnails_padding_left'], DOPTS_THUMBNAILS_PADDING_LEFT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_PADDING_LEFT_INFO));
    HTML.push(doptsSettingsFormSelect('thumbnails_info', data['thumbnails_info'], DOPTS_THUMBNAILS_INFO, '', '', '', 'help', DOPTS_THUMBNAILS_INFO_INFO, 'none;;tooltip;;label', DOPTS_FORM_NONE_TEXT+';;'+DOPTS_FORM_TOOLTIP_TEXT+';;'+DOPTS_FORM_LABEL_TEXT));
    
// Thumbnails Navigation Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_THUMBNAILS_NAVIGATION_STYLES_SETTINGS+'</h3>');                                                                        
    
    HTML.push(doptsSettingsFormSelect('thumbnails_navigation_easing', data['thumbnails_navigation_easing'], DOPTS_THUMBNAILS_NAVIGATION_EASING, '', '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_EASING_INFO, 'linear;;swing;;easeInQuad;;easeOutQuad;;easeInOutQuad;;easeInCubic;;easeOutCubic;;easeInOutCubic;;easeInQuart;;easeOutQuart;;easeInOutQuart;;easeInQuint;;easeOutQuint;;easeInOutQuint;;easeInSine;;easeOutSine;;easeInOutSine;;easeInExpo;;easeOutExpo;;easeInOutExpo;;easeInCirc;;easeOutCirc;;easeInOutCirc;;easeInElastic;;easeOutElastic;;easeInOutElastic;;easeInBack;;easeOutBack;;easeInOutBack;;easeInBounce;;easeOutBounce;;easeInOutBounce', 'linear;;swing;;easeInQuad;;easeOutQuad;;easeInOutQuad;;easeInCubic;;easeOutCubic;;easeInOutCubic;;easeInQuart;;easeOutQuart;;easeInOutQuart;;easeInQuint;;easeOutQuint;;easeInOutQuint;;easeInSine;;easeOutSine;;easeInOutSine;;easeInExpo;;easeOutExpo;;easeInOutExpo;;easeInCirc;;easeOutCirc;;easeInOutCirc;;easeInElastic;;easeOutElastic;;easeInOutElastic;;easeInBack;;easeOutBack;;easeInOutBack;;easeInBounce;;easeOutBounce;;easeInOutBounce'));
    HTML.push(doptsSettingFormSwitch('thumbnails_navigation_loop', data['thumbnails_navigation_loop'], DOPTS_THUMBNAILS_NAVIGATION_LOOP, '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_LOOP_INFO));
    HTML.push(doptsSettingFormSwitch('thumbnails_navigation_mouse_enabled', data['thumbnails_navigation_mouse_enabled'], DOPTS_THUMBNAILS_NAVIGATION_MOUSE_ENABLED, '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_MOUSE_ENABLED_INFO));
    HTML.push(doptsSettingFormSwitch('thumbnails_navigation_scroll_enabled', data['thumbnails_navigation_scroll_enabled'], DOPTS_THUMBNAILS_NAVIGATION_SCROLL_ENABLED, '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_SCROLL_ENABLED_INFO));
    HTML.push(doptsSettingsFormSelect('thumbnails_scroll_position', data['thumbnails_scroll_position'], DOPTS_THUMBNAILS_NAVIGATION_SCROLL_POSITION, '', '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_SCROLL_POSITION_INFO, 'bottom/right;;top/left', DOPTS_FORM_BOTTOM_SLASH_RIGHT_TEXT+';;'+DOPTS_FORM_TOP_SLASH_LEFT_TEXT));
    HTML.push(doptsSettingsFormInput('thumbnails_scroll_size', data['thumbnails_scroll_size'], DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SIZE, '', 'px', 'small', 'help-small', DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SIZE_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_scroll_scrub_color', data['thumbnails_scroll_scrub_color'], DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SCRUB_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SCRUB_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_scroll_bar_color', data['thumbnails_scroll_bar_color'], DOPTS_THUMBNAILS_NAVIGATION_SCROLL_BAR_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAILS_NAVIGATION_SCROLL_BAR_COLOR_INFO));
    HTML.push(doptsSettingFormSwitch('thumbnails_navigation_arrows_enabled', data['thumbnails_navigation_arrows_enabled'], DOPTS_THUMBNAILS_NAVIGATION_ARROWS_ENABLED, '', '', 'help', DOPTS_THUMBNAILS_NAVIGATION_ARROWS_ENABLED_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_navigation_arrows_no_items_slide', data['thumbnails_navigation_arrows_no_items_slide'], DOPTS_THUMBNAILS_NAVIGATION_ARROWS_NO_ITEMS_SLIDE, '', '', 'small', 'help-small', DOPTS_THUMBNAILS_NAVIGATION_ARROWS_NO_ITEMS_SLIDE_INFO));
    HTML.push(doptsSettingsFormInput('thumbnails_navigation_arrows_speed', data['thumbnails_navigation_arrows_speed'], DOPTS_THUMBNAILS_NAVIGATION_ARROWS_SPEED, '', '', 'small', 'help-small', DOPTS_THUMBNAILS_NAVIGATION_ARROWS_SPEED_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_prev', data['thumbnails_navigation_prev'], DOPTS_THUMBNAILS_NAVIGATION_PREV, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_PREV_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_prev_hover', data['thumbnails_navigation_prev_hover'], DOPTS_THUMBNAILS_NAVIGATION_PREV_HOVER, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_PREV_HOVER_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_prev_disabled', data['thumbnails_navigation_prev_disabled'], DOPTS_THUMBNAILS_NAVIGATION_PREV_DISABLED, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_PREV_DISABLED_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_next', data['thumbnails_navigation_next'], DOPTS_THUMBNAILS_NAVIGATION_NEXT, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_NEXT_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_next_hover', data['thumbnails_navigation_next_hover'], DOPTS_THUMBNAILS_NAVIGATION_NEXT_HOVER, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_NEXT_HOVER_INFO));
    HTML.push(doptsSettingsFormImage('thumbnails_navigation_next_disabled', data['thumbnails_navigation_next_disabled'], DOPTS_THUMBNAILS_NAVIGATION_NEXT_DISABLED, 'help-image', DOPTS_THUMBNAILS_NAVIGATION_NEXT_DISABLED_INFO));
    
// Styles & Settings for a Thumbnail
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_THUMBNAIL_STYLES_SETTINGS+'</h3>');
    
    HTML.push(doptsSettingsFormImage('thumbnail_loader', data['thumbnail_loader'], DOPTS_THUMBNAIL_LOADER, 'help-image', DOPTS_THUMBNAIL_LOADER_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_width', data['thumbnail_width'], DOPTS_THUMBNAIL_WIDTH, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_WIDTH_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_height', data['thumbnail_height'], DOPTS_THUMBNAIL_HEIGHT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_HEIGHT_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_alpha', data['thumbnail_alpha'], DOPTS_THUMBNAIL_ALPHA, '', '', 'small', 'help-small', DOPTS_THUMBNAIL_ALPHA_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_alpha_hover', data['thumbnail_alpha_hover'], DOPTS_THUMBNAIL_ALPHA_HOVER, '', '', 'small', 'help-small', DOPTS_THUMBNAIL_ALPHA_HOVER_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_bg_color', data['thumbnail_bg_color'], DOPTS_THUMBNAIL_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAIL_BG_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_bg_color_hover', data['thumbnail_bg_color_hover'], DOPTS_THUMBNAIL_BG_COLOR_HOVER, '#', '', 'small', 'help-small', DOPTS_THUMBNAIL_BG_COLOR_HOVER_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_border_size', data['thumbnail_border_size'], DOPTS_THUMBNAIL_BORDER_SIZE, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_BORDER_SIZE_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_border_color', data['thumbnail_border_color'], DOPTS_THUMBNAIL_BORDER_COLOR, '#', '', 'small', 'help-small', DOPTS_THUMBNAIL_BORDER_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_border_color_hover', data['thumbnail_border_color_hover'], DOPTS_THUMBNAIL_BORDER_COLOR_HOVER, '#', '', 'small', 'help-small', DOPTS_THUMBNAIL_BORDER_COLOR_HOVER_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_padding_top', data['thumbnail_padding_top'], DOPTS_THUMBNAIL_PADDING_TOP, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_PADDING_TOP_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_padding_right', data['thumbnail_padding_right'], DOPTS_THUMBNAIL_PADDING_RIGHT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_PADDING_RIGHT_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_padding_bottom', data['thumbnail_padding_bottom'], DOPTS_THUMBNAIL_PADDING_BOTTOM, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_PADDING_BOTTOM_INFO));
    HTML.push(doptsSettingsFormInput('thumbnail_padding_left', data['thumbnail_padding_left'], DOPTS_THUMBNAIL_PADDING_LEFT, '', 'px', 'small', 'help-small', DOPTS_THUMBNAIL_PADDING_LEFT_INFO));
   
// Lightbox Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_LIGHTBOX_STYLES_SETTINGS+'</h3>');
    
    HTML.push(doptsSettingFormSwitch('lightbox_enabled', data['lightbox_enabled'], DOPTS_LIGHTBOX_ENABLED, '', '', 'help', DOPTS_LIGHTBOX_ENABLED_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_display_time', data['lightbox_display_time'], DOPTS_LIGHTBOX_DISPLAY_TIME, '', '', 'small', 'help-small', DOPTS_LIGHTBOX_DISPLAY_TIME_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_window_color', data['lightbox_window_color'], DOPTS_LIGHTBOX_WINDOW_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_WINDOW_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_window_alpha', data['lightbox_window_alpha'], DOPTS_LIGHTBOX_WINDOW_ALPHA, '', '', 'small', 'help-small', DOPTS_LIGHTBOX_WINDOW_ALPHA_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_loader', data['lightbox_loader'], DOPTS_LIGHTBOX_LOADER, 'help-image', DOPTS_LIGHTBOX_LOADER_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_bg_color', data['lightbox_bg_color'], DOPTS_LIGHTBOX_BACKGROUND_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_BACKGROUND_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_bg_alpha', data['lightbox_bg_alpha'], DOPTS_LIGHTBOX_BACKGROUND_ALPHA, '', '', 'small', 'help-small', DOPTS_LIGHTBOX_BACKGROUND_ALPHA_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_border_size', data['lightbox_border_size'], DOPTS_LIGHTBOX_BORDER_SIZE, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_BORDER_SIZE_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_border_color', data['lightbox_border_color'], DOPTS_LIGHTBOX_BORDER_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_BORDER_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_caption_text_color', data['lightbox_caption_text_color'], DOPTS_LIGHTBOX_CAPTION_TEXT_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_CAPTION_TEXT_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_margin_top', data['lightbox_margin_top'], DOPTS_LIGHTBOX_MARGIN_TOP, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_MARGIN_TOP_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_margin_right', data['lightbox_margin_right'], DOPTS_LIGHTBOX_MARGIN_RIGHT, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_MARGIN_RIGHT_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_margin_bottom', data['lightbox_margin_bottom'], DOPTS_LIGHTBOX_MARGIN_BOTTOM, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_MARGIN_BOTTOM_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_margin_left', data['lightbox_margin_left'], DOPTS_LIGHTBOX_MARGIN_LEFT, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_MARGIN_LEFT_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_padding_top', data['lightbox_padding_top'], DOPTS_LIGHTBOX_PADDING_TOP, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_PADDING_TOP_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_padding_right', data['lightbox_padding_right'], DOPTS_LIGHTBOX_PADDING_RIGHT, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_PADDING_RIGHT_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_padding_bottom', data['lightbox_padding_bottom'], DOPTS_LIGHTBOX_PADDING_BOTTOM, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_PADDING_BOTTOM_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_padding_left', data['lightbox_padding_left'], DOPTS_LIGHTBOX_PADDING_LEFT, '', 'px', 'small', 'help-small', DOPTS_LIGHTBOX_PADDING_LEFT_INFO));
        
// Lightbox Navigation Icons Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_LIGHTBOX_NAVIGATION_STYLES_SETTINGS+'</h3>');
         
    HTML.push(doptsSettingsFormImage('lightbox_navigation_prev', data['lightbox_navigation_prev'], DOPTS_LIGHTBOX_NAVIGATION_PREV, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_PREV_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_navigation_prev_hover', data['lightbox_navigation_prev_hover'], DOPTS_LIGHTBOX_NAVIGATION_PREV_HOVER, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_PREV_HOVER_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_navigation_next', data['lightbox_navigation_next'], DOPTS_LIGHTBOX_NAVIGATION_NEXT, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_NEXT_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_navigation_next_hover', data['lightbox_navigation_next_hover'], DOPTS_LIGHTBOX_NAVIGATION_NEXT_HOVER, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_NEXT_HOVER_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_navigation_close', data['lightbox_navigation_close'], DOPTS_LIGHTBOX_NAVIGATION_CLOSE, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_CLOSE_INFO));
    HTML.push(doptsSettingsFormImage('lightbox_navigation_close_hover', data['lightbox_navigation_close_hover'], DOPTS_LIGHTBOX_NAVIGATION_CLOSE_HOVER, 'help-image', DOPTS_LIGHTBOX_NAVIGATION_CLOSE_HOVER_INFO));    
    HTML.push(doptsSettingsFormInput('lightbox_navigation_info_bg_color', data['lightbox_navigation_info_bg_color'], DOPTS_LIGHTBOX_NAVIGATION_INFO_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_NAVIGATION_INFO_BG_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_navigation_info_text_color', data['lightbox_navigation_info_text_color'], DOPTS_LIGHTBOX_NAVIGATION_INFO_TEXT_COLOR, '#', '', 'small', 'help-small', DOPTS_LIGHTBOX_NAVIGATION_INFO_TEXT_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('lightbox_navigation_display_time', data['lightbox_navigation_display_time'], DOPTS_LIGHTBOX_NAVIGATION_DISPLAY_TIME, '', '', 'small', 'help-small', DOPTS_LIGHTBOX_NAVIGATION_DISPLAY_TIME_INFO));
    HTML.push(doptsSettingFormSwitch('lightbox_navigation_touch_device_swipe_enabled', data['lightbox_navigation_touch_device_swipe_enabled'], DOPTS_LIGHTBOX_NAVIGATION_TOUCH_DEVICE_SWIPE_ENABLED, '', '', 'help', DOPTS_LIGHTBOX_NAVIGATION_TOUCH_DEVICE_SWIPE_ENABLED_INFO));

// Social Share Styles & Settings 
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_SOCIAL_SHARE_STYLES_SETTINGS+'</h3>');
    HTML.push(doptsSettingFormSwitch('social_share_enabled', data['social_share_enabled'], DOPTS_SOCIAL_SHARE_ENABLED, '', '', 'help', DOPTS_SOCIAL_SHARE_ENABLED_INFO));
    HTML.push(doptsSettingsFormImage('social_share_lightbox', data['social_share_lightbox'], DOPTS_SOCIAL_SHARE_LIGHTBOX, 'help-image', DOPTS_SOCIAL_SHARE_LIGHTBOX_INFO)); 
    
// Tooltip Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_TOOLTIP_STYLES_SETTINGS+'</h3>');
    
    HTML.push(doptsSettingsFormInput('tooltip_bg_color', data['tooltip_bg_color'], DOPTS_TOOLTIP_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_TOOLTIP_BG_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('tooltip_stroke_color', data['tooltip_stroke_color'], DOPTS_TOOLTIP_STROKE_COLOR, '#', '', 'small', 'help-small', DOPTS_TOOLTIP_STROKE_COLOR_INFO));
    HTML.push(doptsSettingsFormInput('tooltip_text_color', data['tooltip_text_color'], DOPTS_TOOLTIP_TEXT_COLOR, '#', '', 'small', 'help-small', DOPTS_TOOLTIP_TEXT_COLOR_INFO));

// Label Styles & Settings
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_LABEL_STYLES_SETTINGS+'</h3>');
    
    HTML.push(doptsSettingsFormSelect('label_position', data['label_position'], DOPTS_LABEL_POSITION, '', '', '', 'help', DOPTS_LABEL_POSITION_INFO, 'bottom;;top;;under', DOPTS_FORM_BOTTOM_TEXT+';;'+DOPTS_FORM_TOP_TEXT+';;'+DOPTS_FORM_UNDER_TEXT));
    HTML.push(doptsSettingFormSwitch('label_always_visible', data['label_always_visible'], DOPTS_LABEL_ALWAYS_VISIBLE, '', '', 'help', DOPTS_LABEL_ALWAYS_VISIBLE_INFO));
    HTML.push(doptsSettingsFormInput('label_under_height', data['label_under_height'], DOPTS_LABEL_UNDER_HEIGHT, '', 'px', 'small', 'help-small', DOPTS_LABEL_UNDER_HEIGHT_INFO));
    HTML.push(doptsSettingsFormInput('label_bg_color', data['label_bg_color'], DOPTS_LABEL_BG_COLOR, '#', '', 'small', 'help-small', DOPTS_LABEL_BG_COLOR_INFO));    
    HTML.push(doptsSettingsFormInput('label_bg_alpha', data['label_bg_alpha'], DOPTS_LABEL_BG_ALPHA, '', '', 'small', 'help-small', DOPTS_LABEL_BG_ALPHA_INFO));
    HTML.push(doptsSettingsFormInput('label_text_color', data['label_text_color'], DOPTS_LABEL_TEXT_COLOR, '#', '', 'small', 'help-small', DOPTS_LABEL_TEXT_COLOR_INFO));
    
// Slideshow Settings    
    HTML.push('    <a href="javascript:doptsMoveTop()" class="go-top">'+DOPTS_GO_TOP+'</a><h3 class="settings">'+DOPTS_SLIDESHOW_SETTINGS+'</h3>');
    
    HTML.push(doptsSettingFormSwitch('slideshow_enabled', data['slideshow_enabled'], DOPTS_SLIDESHOW_ENABLED, '', '', 'help', DOPTS_SLIDESHOW_ENABLED_INFO));
    HTML.push(doptsSettingsFormInput('slideshow_time', data['slideshow_time'], DOPTS_SLIDESHOW_TIME, '', '', 'small', 'help-small', DOPTS_SLIDESHOW_TIME_INFO));
    HTML.push(doptsSettingFormSwitch('slideshow_loop', data['slideshow_loop'], DOPTS_SLIDESHOW_LOOP, '', '', 'help', DOPTS_SLIDESHOW_LOOP_INFO));
    
    HTML.push('</form>');
    HTML.push('<style type="text/css">');
    HTML.push('    .DOPTS-admin .setting-box .switch-inner:before{content: "'+DOPTS_FORM_ENABLED_TEXT+'";}');
    HTML.push('    .DOPTS-admin .setting-box .switch-inner:after{content: "'+DOPTS_FORM_DISABLED_TEXT+'";}');
    HTML.push('</style>');

    $jDOPTS('.column-content', '.column'+column, '.DOPTS-admin').html(HTML.join(''));
    setTimeout(function(){
        doptsResize();
        setTimeout(function(){
           doptsResize();
        }, 10000);
    }, 5000);
    
    $jDOPTS('#bg_color,\n\
             #bg_border_color,\n\
             #thumbnails_bg_color,\n\
             #thumbnails_border_color,\n\
             #thumbnails_scroll_scrub_color,\n\
             #thumbnails_scroll_bar_color,\n\
             #thumbnail_bg_color,\n\
             #thumbnail_bg_color_hover,\n\
             #thumbnail_border_color,\n\
             #thumbnail_border_color_hover,\n\
             #lightbox_window_color,\n\
             #lightbox_bg_color,\n\
             #lightbox_border_color,\n\
             #lightbox_navigation_info_bg_color,\n\
             #lightbox_navigation_info_text_color,\n\
             #lightbox_caption_text_color,\n\
             #tooltip_bg_color,\n\
             #tooltip_stroke_color,\n\
             #tooltip_text_color,\n\
             #label_bg_color,\n\
             #label_text_color').ColorPicker({
        onSubmit:function(hsb, hex, rgb, el){
            $jDOPTS(el).val(hex);
            $jDOPTS(el).ColorPickerHide();
            $jDOPTS(el).removeAttr('style');
            $jDOPTS(el).css({'background-color': '#'+hex,
                             'color': doptsIdealTextColor(hex) == 'white' ? '#ffffff':'#0000000'});
        },
        onBeforeShow:function(){
            $jDOPTS(this).ColorPickerSetColor(this.value);
        },
        onShow:function(colpkr){
            $jDOPTS(colpkr).fadeIn(500);
            return false;
        },
        onHide:function(colpkr){
            $jDOPTS(colpkr).fadeOut(500);
            return false;
        }
    })
    .bind('keyup', function(){
        $jDOPTS(this).ColorPickerSetColor(this.value);
        $jDOPTS(this).removeAttr('style');
        
        if (this.value.length != 6){
            $jDOPTS(this).css({'background-color': '#ffffff',
                               'color': '#0000000'});
        }
        else{
            $jDOPTS(this).css({'background-color': '#'+this.value,
                               'color': doptsIdealTextColor(this.value) == 'white' ? '#ffffff':'#0000000'});
        }
    });
    
    $jDOPTS('#bg_color').css({'background-color': '#'+data['bg_color'],
                              'color': doptsIdealTextColor(data['bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#bg_border_color').css({'background-color': '#'+data['bg_border_color'],
                                     'color': doptsIdealTextColor(data['bg_border_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnails_bg_color').css({'background-color': '#'+data['thumbnails_bg_color'],
                                         'color': doptsIdealTextColor(data['thumbnails_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnails_border_color').css({'background-color': '#'+data['thumbnails_border_color'],
                                             'color': doptsIdealTextColor(data['thumbnails_border_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnails_scroll_scrub_color').css({'background-color': '#'+data['thumbnails_scroll_scrub_color'],
                                                   'color': doptsIdealTextColor(data['thumbnails_scroll_scrub_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnails_scroll_bar_color').css({'background-color': '#'+data['thumbnails_scroll_bar_color'],
                                                 'color': doptsIdealTextColor(data['thumbnails_scroll_bar_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnail_bg_color').css({'background-color': '#'+data['thumbnail_bg_color'],
                                        'color': doptsIdealTextColor(data['thumbnail_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnail_bg_color_hover').css({'background-color': '#'+data['thumbnail_bg_color_hover'],
                                              'color': doptsIdealTextColor(data['thumbnail_bg_color_hover']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnail_border_color').css({'background-color': '#'+data['thumbnail_border_color'],
                                            'color': doptsIdealTextColor(data['thumbnail_border_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#thumbnail_border_color_hover').css({'background-color': '#'+data['thumbnail_border_color_hover'],
                                                  'color': doptsIdealTextColor(data['thumbnail_border_color_hover']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_window_color').css({'background-color': '#'+data['lightbox_window_color'],
                                           'color': doptsIdealTextColor(data['lightbox_window_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_bg_color').css({'background-color': '#'+data['lightbox_bg_color'],
                                       'color': doptsIdealTextColor(data['lightbox_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_border_color').css({'background-color': '#'+data['lightbox_border_color'],
                                           'color': doptsIdealTextColor(data['lightbox_border_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_navigation_info_bg_color').css({'background-color': '#'+data['lightbox_navigation_info_bg_color'],
                                                       'color': doptsIdealTextColor(data['lightbox_navigation_info_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_navigation_info_text_color').css({'background-color': '#'+data['lightbox_navigation_info_text_color'],
                                                         'color': doptsIdealTextColor(data['lightbox_navigation_info_text_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#lightbox_caption_text_color').css({'background-color': '#'+data['lightbox_caption_text_color'],
                                                 'color': doptsIdealTextColor(data['lightbox_caption_text_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#tooltip_bg_color').css({'background-color': '#'+data['tooltip_bg_color'],
                                      'color': doptsIdealTextColor(data['tooltip_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#tooltip_stroke_color').css({'background-color': '#'+data['tooltip_stroke_color'],
                                          'color': doptsIdealTextColor(data['tooltip_stroke_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#tooltip_text_color').css({'background-color': '#'+data['tooltip_text_color'],
                                        'color': doptsIdealTextColor(data['tooltip_text_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#label_bg_color').css({'background-color': '#'+data['label_bg_color'],
                                    'color': doptsIdealTextColor(data['label_bg_color']) == 'white' ? '#ffffff':'#0000000'});
    $jDOPTS('#label_text_color').css({'background-color': '#'+data['label_text_color'],
                                      'color': doptsIdealTextColor(data['label_text_color']) == 'white' ? '#ffffff':'#0000000'});
    
    doptsSettingsImageUpload('thumbnails_navigation_prev', 'uploads/settings/thumbnails-navigation-prev/', DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_SUCCESS);
    doptsSettingsImageUpload('thumbnails_navigation_prev_hover', 'uploads/settings/thumbnails-navigation-prev-hover/', DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_HOVER_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_HOVER_SUCCESS);
    doptsSettingsImageUpload('thumbnails_navigation_prev_disabled', 'uploads/settings/thumbnails-navigation-prev-disabled/', DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_DISABLED_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_DISABLED_SUCCESS);
    doptsSettingsImageUpload('thumbnails_navigation_next', 'uploads/settings/thumbnails-navigation-next/', DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_SUCCESS);
    doptsSettingsImageUpload('thumbnails_navigation_next_hover', 'uploads/settings/thumbnails-navigation-next-hover/', DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_HOVER_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_HOVER_SUCCESS);
    doptsSettingsImageUpload('thumbnails_navigation_next_disabled', 'uploads/settings/thumbnails-navigation-next-disabled/', DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_DISABLED_SUBMITED, DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_DISABLED_SUCCESS);    
    doptsSettingsImageUpload('thumbnail_loader', 'uploads/settings/thumb-loader/', DOPTS_ADD_THUMBNAIL_LOADER_SUBMITED, DOPTS_ADD_THUMBNAIL_LOADER_SUCCESS);
    doptsSettingsImageUpload('lightbox_loader', 'uploads/settings/lightbox-loader/', DOPTS_ADD_LIGHTBOX_LOADER_SUBMITED, DOPTS_ADD_LIGHTBOX_LOADER_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_prev', 'uploads/settings/lightbox-navigation-prev/', DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_prev_hover', 'uploads/settings/lightbox-navigation-prev-hover/', DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_HOVER_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_HOVER_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_next', 'uploads/settings/lightbox-navigation-next/', DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_next_hover', 'uploads/settings/lightbox-navigation-next-hover/', DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_HOVER_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_HOVER_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_close', 'uploads/settings/lightbox-navigation-close/', DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_SUCCESS);
    doptsSettingsImageUpload('lightbox_navigation_close_hover', 'uploads/settings/lightbox-navigation-close-hover/', DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_HOVER_SUBMITED, DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_HOVER_SUCCESS);  
    doptsSettingsImageUpload('social_share_lightbox', 'uploads/settings/social-share-lightbox/', DOPTS_SOCIAL_SHARE_LIGHTBOX_SUBMITED, DOPTS_SOCIAL_SHARE_LIGHTBOX_SUCCESS);    
}

function doptsSettingsFormInput(id, value, label, pre, suf, input_class, help_class, help){// Create an Input Field.
    var inputHTML = new Array();

    inputHTML.push('    <div class="setting-box">');
    inputHTML.push('        <label for="'+id+'">'+label+'</label>');
    inputHTML.push('        <span class="pre">'+pre+'</span><input type="text" class="'+input_class+'" name="'+id+'" id="'+id+'" value="'+value+'" /><span class="suf">'+suf+'</span>');
    inputHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    inputHTML.push('        <br class="DOPTS-clear" />');
    inputHTML.push('    </div>');

    return inputHTML.join('');
}

function doptsSettingsFormSelect(id, value, label, pre, suf, input_class, help_class, help, values, valuesLabels){// Create a Combo Box.
    var selectHTML = new Array(), i,
    valuesList = values.split(';;'),
    valuesLabelsList = valuesLabels.split(';;');

    selectHTML.push('    <div class="setting-box">');
    selectHTML.push('        <label for="'+id+'">'+label+'</label>');
    selectHTML.push('        <span class="pre">'+pre+'</span>');
    selectHTML.push('            <select name="'+id+'" id="'+id+'">');
    
    for (i=0; i<valuesList.length; i++){
        if (valuesList[i] == value){
            selectHTML.push('        <option value="'+valuesList[i]+'" selected="selected">'+valuesLabelsList[i]+'</option>');
        }
        else{
            selectHTML.push('        <option value="'+valuesList[i]+'">'+valuesLabelsList[i]+'</option>');
        }
    }
    selectHTML.push('            </select>');
    selectHTML.push('        <span class="suf">'+suf+'</span>');
    selectHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    selectHTML.push('        <br class="DOPTS-clear" />');
    selectHTML.push('    </div>');

    return selectHTML.join('');
}

function doptsSettingsFormImage(id, value, label, help_class, help){// Create an Image Field.
    var imageHTML = new Array();

    imageHTML.push('    <div class="setting-box">');
    imageHTML.push('        <label for="'+id+'">'+label+'</label>');
    imageHTML.push('        <span class="pre"></span>');
    imageHTML.push('        <div class="uploadifyContainer" style="float:left; margin:0; width:120px;">');
    imageHTML.push('            <div><input type="file" name="'+id+'" id="'+id+'" style="width:120px;" /></div>');
    imageHTML.push('            <div id="fileQueue_'+id+'"></div>');
    imageHTML.push('        </div>');
    imageHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    imageHTML.push('        <br class="DOPTS-clear" />');
    imageHTML.push('        <label for=""></label>');
    imageHTML.push('        <span class="pre"></span>');
    imageHTML.push('        <div class="uploadifyContainer" id="'+id+'_image" style="float:left; margin:5px 0 0 0; padding:0 0 10px 0;">');
    imageHTML.push('            <img src="'+DOPTS_plugin_url+value+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
    imageHTML.push('        </div>');
    imageHTML.push('        <br class="DOPTS-clear" />');
    imageHTML.push('    </div>');

    return imageHTML.join('');
}

function doptsSettingsImageUpload(id, path, submitMessage, successMessage){
    $jDOPTS('#'+id).uploadify({
        'uploader'       : DOPTS_plugin_url+'libraries/swf/uploadify.swf',
        'script'         : DOPTS_plugin_url+'libraries/php/uploadify-settings.php?data='+DOPTS_plugin_abs+';;'+path+';;'+$jDOPTS('#blog_id').val()+'-'+$jDOPTS('#scroller_id').val(),
        'cancelImg'      : DOPTS_plugin_url+'libraries/gui/images/uploadify/cancel.png',
        'folder'         : '',
        'queueID'        : 'fileQueue_'+id,
        'buttonText'     : DOPTS_SELECT_FILE,
        'auto'           : true,
        'multi'          : false,
        'onInit'         : function(){
                               doptsResize();
                           },
        'onCancel'         : function(event,ID,fileObj,data){
                               doptsResize();
                           },
        'onSelect'       : function(event, ID, fileObj){
                               clearClick = false;
                               doptsToggleMessage('show', submitMessage);
                               setTimeout(function(){
                                   doptsResize();
                               }, 100);
                           },
        'onComplete'     : function(event, ID, fileObj, response, data){
                               if (response != -1){
                                   setTimeout(function(){
                                       doptsResize();
                                   }, 1000);
                                   $jDOPTS.post(ajaxurl, {action:'dopts_update_settings_image', item:id, scroller_id:$jDOPTS('#scroller_id').val(), path:response}, function(data){
                                       $jDOPTS('#'+id+'_image').html('<img src="'+DOPTS_plugin_url+response+'?cacheBuster='+doptsRandomString(64)+'" alt="" />');
                                       doptsToggleMessage('hide', successMessage);
                                   });
                               }
                           }
    });
}

function doptsSettingFormSwitch(id, value, label, pre, suf, help_class, help){ // Create a Switch Button
    var switchtHTML = new Array();

    switchtHTML.push('    <div class="setting-box">');
    switchtHTML.push('        <label for="">'+label+'</label>');
    switchtHTML.push('        <span class="pre">'+pre+'</span>');
    switchtHTML.push('        <div class="switch">');
    switchtHTML.push('             <input type="checkbox" name="'+id+'" id="'+id+'" class="switch-checkbox"'+(value == 'true' ? ' checked="checked"':'')+' />');
    switchtHTML.push('             <label class="switch-label" for="'+id+'">');
    switchtHTML.push('                  <div class="switch-inner"></div>');
    switchtHTML.push('                  <div class="switch-switch"></div>');
    switchtHTML.push('             </label>');
    switchtHTML.push('        </div>');
    switchtHTML.push('        <span class="suf">'+suf+'</span>');
    switchtHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    switchtHTML.push('        <br class="DOPTS-clear" />');
    switchtHTML.push('    </div>');

    return switchtHTML.join('');
}

// Functions

function doptsRemoveColumns(no){// Clear columns content.
    if (no <= 2){
        $jDOPTS('.column-header', '.column2', '.DOPTS-admin').html('');
        $jDOPTS('.column-content', '.column2', '.DOPTS-admin').html('');
    }
    if (no <= 3){
        $jDOPTS('.column-header', '.column3', '.DOPTS-admin').html('');
        $jDOPTS('.column-content', '.column3', '.DOPTS-admin').html('');
        imageDisplay = false;
        currImage = 0;
        doptsResize();
    }
}

function doptsToggleMessage(action, message){// Display Info Messages.
    doptsResize();
    
    if (action == 'show'){
        clearClick = false;
        $jDOPTS('#DOPTS-admin-message').addClass('loader');
        $jDOPTS('#DOPTS-admin-message').html(message);
        $jDOPTS('#DOPTS-admin-message').stop(true, true).animate({'opacity':1}, 600);
    }
    else{
        clearClick = true;
        $jDOPTS('#DOPTS-admin-message').removeClass('loader');
        $jDOPTS('#DOPTS-admin-message').html(message);
        setTimeout(function(){
            $jDOPTS('#DOPTS-admin-message').stop(true, true).animate({'opacity':0}, 600, function(){
                $jDOPTS('#DOPTS-admin-message').html('');
            });
        }, 2000);
    }
}

function doptsMoveTop(){
    jQuery('html').stop(true, true).animate({'scrollTop':'0'}, 300);
    jQuery('body').stop(true, true).animate({'scrollTop':'0'}, 300);
}

function doptsRandomString(string_length){// Create a string with random elements
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz",
    random_string = '';

    for (var i=0; i<string_length; i++){
        var rnum = Math.floor(Math.random()*chars.length);
        random_string += chars.substring(rnum,rnum+1);
    }
    return random_string;
}

function doptsIdealTextColor(bgColor){
    var rgb = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(bgColor);
    
    if (rgb != null){
        return parseInt(rgb[1], 10)+parseInt(rgb[2], 10)+parseInt(rgb[3], 10) < 3*256/2 ? 'white' : 'black';
    }
    else{
        return parseInt(bgColor.substring(0, 2), 16)+parseInt(bgColor.substring(2, 4), 16)+parseInt(bgColor.substring(4, 6), 16) < 3*256/2 ? 'white' : 'black';
    }
}

function doptsShortName(name, size){// Return a short string.
    var newName = new Array(),
    pieces = name.split(''),
    i;

    if (pieces.length <= size){
        newName.push(name);
    }
    else{
        for (i=0; i<size-3; i++){
            newName.push(pieces[i]);
        }
        newName.push('...');
    }

    return newName.join('');
}