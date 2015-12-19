<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : dopts-frontend.php
* File Version            : 1.5
* Created / Last Modified : 01 October 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Front End Class.
*/

    if (!class_exists("DOPThumbnailScrollerFrontEnd")){
        class DOPThumbnailScrollerFrontEnd{
            function DOPThumbnailScrollerFrontEnd(){// Constructor.
                add_action('wp_enqueue_scripts', array(&$this, 'addStyles'));
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
                $this->init();
            }
            
            function addStyles(){
                // Register Styles.
                wp_register_style('DOPTS_JScrollPaneStyle', plugins_url('libraries/gui/css/jquery.jscrollpane.css', __FILE__));
                wp_register_style('DOPTS_ThumbnailScrollerStyle', plugins_url('assets/gui/css/jquery.dop.ThumbnailScroller.css', __FILE__));
                
                // Enqueue Styles.
                wp_enqueue_style('DOPTS_JScrollPaneStyle');
                wp_enqueue_style('DOPTS_ThumbnailScrollerStyle');
            }
            
            function addScripts(){
                // Register JavaScript.
                if (preg_match('/MSIE 7/i', $_SERVER['HTTP_USER_AGENT'])){
                    wp_register_script('DOPTS_json2', plugins_url('libraries/js/json2.js', __FILE__), array('jquery'), false, true);
                }
                wp_register_script('DOPTS_ThumbnailScrollerJS', plugins_url('assets/js/jquery.dop.ThumbnailScroller.js', __FILE__), array('jquery'), false, true);

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
    
                if (!wp_script_is('jquery-ui-draggable', 'queue')){
                    wp_enqueue_script('jquery-ui-draggable');
                }
                
                if (!wp_script_is('jquery-effects-core', 'queue')){
                    wp_enqueue_script('jquery-effects-core');
                }
                
                if (preg_match('/MSIE 7/i', $_SERVER['HTTP_USER_AGENT'])){
                    wp_enqueue_script('DOPTS_json2');
                }
                wp_enqueue_script('DOPTS_ThumbnailScrollerJS');
            }

            function init(){// Init Scroller.
                $this->initConstants();
                add_shortcode('dopts', array(&$this, 'captionShortcode'));
            }

            function initConstants(){// Constants init.
                global $wpdb;

                // Tables
                define('DOPTS_Settings_table', $wpdb->prefix.'dopts_settings');
                define('DOPTS_Scrollers_table', $wpdb->prefix.'dopts_scrollers');
                define('DOPTS_Images_table', $wpdb->prefix.'dopts_images');
            }

            function captionShortcode($atts, $content = null){// Read Shortcodes.
                global $wpdb;
                $data = array();
                $imagesList = array();
                
                extract(shortcode_atts(array(
                    'class' => 'dopts',
                ), $atts));
                
                $default_settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="0"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$atts['id'].'"');
                
                if ($default_settings->data_parse_method == 'ajax'){
                    $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$atts['id'].'" AND enabled="true" ORDER BY position');

                    foreach ($images as $image){
                        array_push($imagesList, '<li>
                                                    <img class="Image" src="'.DOPTS_Plugin_URL.'uploads/'.$image->name.'" alt="'.stripslashes($image->title).'" title="'.stripslashes($image->title).'" /> 
                                                    <img class="Thumb" src="'.DOPTS_Plugin_URL.'uploads/thumbs/'.$image->name.'" alt="'.stripslashes($image->title).'" title="'.stripslashes($image->title).'" />
                                                    <span class="Title">'.stripslashes($image->title).'</span>
                                                    <span class="Caption">'.stripslashes($image->caption).'</span>
                                                    <span class="Media">'.stripslashes($image->media).'</span>
                                                    <span class="LightboxMedia">'.stripslashes($image->lightbox_media).'</span>
                                                    <span class="Link">'.stripslashes($image->link).'</span>
                                                    <span class="Target">'.stripslashes($image->target).'</span>
                                                 </li>');
                    }
                
                    $data = '<div class="DOPThumbnailScrollerContainer" id="DOPThumbnailScroller'.$atts['id'].'">
                                 <a href="'.DOPTS_Plugin_URL.'frontend-ajax.php" class="Settings"></a>
                                 <ul class="Content" style="display:none;">'.implode('', $imagesList).'</ul>
                             </div>
                             <script type="text/JavaScript">
                                 jQuery(document).ready(function(){
                                     jQuery(\'#DOPThumbnailScroller'.$atts['id'].'\').DOPThumbnailScroller();
                                 });
                             </script>';
                }
                else{
                    $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$atts['id'].'" AND enabled="true" ORDER BY position');

                    foreach ($images as $image){
                        array_push($imagesList, '<li>
                                                    <img class="Image" src="'.DOPTS_Plugin_URL.'uploads/'.$image->name.'" alt="'.stripslashes($image->title).'" title="'.stripslashes($image->title).'" /> 
                                                    <img class="Thumb" src="'.DOPTS_Plugin_URL.'uploads/thumbs/'.$image->name.'" alt="'.stripslashes($image->title).'" title="'.stripslashes($image->title).'" />
                                                    <span class="Title">'.stripslashes($image->title).'</span>
                                                    <span class="Caption">'.stripslashes($image->caption).'</span>
                                                    <span class="Media">'.stripslashes($image->media).'</span>
                                                    <span class="LightboxMedia">'.stripslashes($image->lightbox_media).'</span>
                                                    <span class="Link">'.stripslashes($image->link).'</span>
                                                    <span class="Target">'.stripslashes($image->target).'</span>
                                                 </li>');
                    }
                
                    $data = '<div class="DOPThumbnailScrollerContainer" id="DOPThumbnailScroller'.$atts['id'].'">
                                <ul class="Settings" style="display:none;">
                                    <li class="Width">'.$settings->width.'</li>
                                    <li class="Height">'.$settings->height.'</li>
                                    <li class="BgColor">'.$settings->bg_color.'</li>
                                    <li class="BgAlpha">'.$settings->bg_alpha.'</li>
                                    <li class="BgBorderSize">'.$settings->bg_border_size.'</li>
                                    <li class="BgBorderColor">'.$settings->bg_border_color.'</li>
                                    <li class="ThumbnailsOrder">'.$settings->images_order.'</li>
                                    <li class="ResponsiveEnabled">'.$settings->responsive_enabled.'</li>
                                    <li class="UltraResponsiveEnabled">'.$settings->ultra_responsive_enabled.'</li>
                                    <li class="ThumbnailsPosition">'.$settings->thumbnails_position.'</li>
                                    <li class="ThumbnailsBgColor">'.$settings->thumbnails_bg_color.'</li>
                                    <li class="ThumbnailsBgAlpha">'.$settings->thumbnails_bg_alpha.'</li>
                                    <li class="ThumbnailsBorderSize">'.$settings->thumbnails_border_size.'</li>
                                    <li class="ThumbnailsBorderColor">'.$settings->thumbnails_border_color.'</li>
                                    <li class="ThumbnailsSpacing">'.$settings->thumbnails_spacing.'</li>
                                    <li class="ThumbnailsMarginTop">'.$settings->thumbnails_margin_top.'</li>
                                    <li class="ThumbnailsMarginRight">'.$settings->thumbnails_margin_right.'</li>
                                    <li class="ThumbnailsMarginBottom">'.$settings->thumbnails_margin_bottom.'</li>
                                    <li class="ThumbnailsMarginLeft">'.$settings->thumbnails_margin_left.'</li>
                                    <li class="ThumbnailsPaddingTop">'.$settings->thumbnails_padding_top.'</li>
                                    <li class="ThumbnailsPaddingRight">'.$settings->thumbnails_padding_right.'</li>
                                    <li class="ThumbnailsPaddingBottom">'.$settings->thumbnails_padding_bottom.'</li>
                                    <li class="ThumbnailsPaddingLeft">'.$settings->thumbnails_padding_left.'</li>
                                    <li class="ThumbnailsInfo">'.$settings->thumbnails_info.'</li>
                                    <li class="ThumbnailsNavigationEasing">'.$settings->thumbnails_navigation_easing.'</li>
                                    <li class="ThumbnailsNavigationLoop">'.$settings->thumbnails_navigation_loop.'</li>
                                    <li class="ThumbnailsNavigationMouseEnabled">'.$settings->thumbnails_navigation_mouse_enabled.'</li>
                                    <li class="ThumbnailsNavigationScrollEnabled">'.$settings->thumbnails_navigation_scroll_enabled.'</li>
                                    <li class="ThumbnailsScrollPosition">'.$settings->thumbnails_scroll_position.'</li>
                                    <li class="ThumbnailsScrollSize">'.$settings->thumbnails_scroll_size.'</li>
                                    <li class="ThumbnailsScrollScrubColor">'.$settings->thumbnails_scroll_scrub_color.'</li>
                                    <li class="ThumbnailsScrollBarColor">'.$settings->thumbnails_scroll_bar_color.'</li>
                                    <li class="ThumbnailsNavigationArrowsEnabled">'.$settings->thumbnails_navigation_arrows_enabled.'</li>
                                    <li class="ThumbnailsNavigationArrowsNoItemsSlide">'.$settings->thumbnails_navigation_arrows_no_items_slide.'</li>
                                    <li class="ThumbnailsNavigationArrowsSpeed">'.$settings->thumbnails_navigation_arrows_speed.'</li>
                                    <li class="ThumbnailsNavigationPrev">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev.'</li>
                                    <li class="ThumbnailsNavigationPrevHover">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev_hover.'</li>
                                    <li class="ThumbnailsNavigationPrevDisabled">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev_disabled.'</li>
                                    <li class="ThumbnailsNavigationNext">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_next.'</li>
                                    <li class="ThumbnailsNavigationNextHover">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_next_hover.'</li>
                                    <li class="ThumbnailsNavigationNextDisabled">'.DOPTS_Plugin_URL.$settings->thumbnails_navigation_next_disabled.'</li>
                                    <li class="ThumbnailLoader">'.DOPTS_Plugin_URL.$settings->thumbnail_loader.'</li>
                                    <li class="ThumbnailWidth">'.$settings->thumbnail_width.'</li>
                                    <li class="ThumbnailHeight">'.$settings->thumbnail_height.'</li>
                                    <li class="ThumbnailAlpha">'.$settings->thumbnail_alpha.'</li>
                                    <li class="ThumbnailAlphaHover">'.$settings->thumbnail_alpha_hover.'</li>
                                    <li class="ThumbnailBgColor">'.$settings->thumbnail_bg_color.'</li>
                                    <li class="ThumbnailBgColorHover">'.$settings->thumbnail_bg_color_hover.'</li>
                                    <li class="ThumbnailBorderSize">'.$settings->thumbnail_border_size.'</li>
                                    <li class="ThumbnailBorderColor">'.$settings->thumbnail_border_color.'</li>
                                    <li class="ThumbnailBorderColorHover">'.$settings->thumbnail_border_color_hover.'</li>
                                    <li class="ThumbnailPaddingTop">'.$settings->thumbnail_padding_top.'</li>
                                    <li class="ThumbnailPaddingRight">'.$settings->thumbnail_padding_right.'</li>
                                    <li class="ThumbnailPaddingBottom">'.$settings->thumbnail_padding_bottom.'</li>
                                    <li class="ThumbnailPaddingLeft">'.$settings->thumbnail_padding_left.'</li>
                                    <li class="LightboxEnabled">'.$settings->lightbox_enabled.'</li>
                                    <li class="LightboxDisplayTime">'.$settings->lightbox_display_time.'</li>
                                    <li class="LightboxWindowColor">'.$settings->lightbox_window_color.'</li>
                                    <li class="LightboxWindowAlpha">'.$settings->lightbox_window_alpha.'</li>
                                    <li class="LightboxLoader">'.DOPTS_Plugin_URL.$settings->lightbox_loader.'</li>
                                    <li class="LightboxBgColor">'.$settings->lightbox_bg_color.'</li>
                                    <li class="LightboxBgAlpha">'.$settings->lightbox_bg_alpha.'</li>
                                    <li class="LightboxBorderSize">'.$settings->lightbox_border_size.'</li>
                                    <li class="LightboxBorderColor">'.$settings->lightbox_border_color.'</li>
                                    <li class="LightboxCaptionTextColor">'.$settings->lightbox_caption_text_color.'</li>
                                    <li class="LightboxMarginTop">'.$settings->lightbox_margin_top.'</li>
                                    <li class="LightboxMarginRight">'.$settings->lightbox_margin_right.'</li>
                                    <li class="LightboxMarginBottom">'.$settings->lightbox_margin_bottom.'</li>
                                    <li class="LightboxMarginLeft">'.$settings->lightbox_margin_left.'</li>
                                    <li class="LightboxPaddingTop">'.$settings->lightbox_padding_top.'</li>
                                    <li class="LightboxPaddingRight">'.$settings->lightbox_padding_right.'</li>
                                    <li class="LightboxPaddingBottom">'.$settings->lightbox_padding_bottom.'</li>
                                    <li class="LightboxPaddingLeft">'.$settings->lightbox_padding_left.'</li>
                                    <li class="LightboxNavigationPrev">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_prev.'</li>
                                    <li class="LightboxNavigationPrevHover">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_prev_hover.'</li>
                                    <li class="LightboxNavigationNext">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_next.'</li>
                                    <li class="LightboxNavigationNextHover">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_next_hover.'</li>
                                    <li class="LightboxNavigationClose">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_close.'</li>
                                    <li class="LightboxNavigationCloseHover">'.DOPTS_Plugin_URL.$settings->lightbox_navigation_close_hover.'</li>
                                    <li class="LightboxNavigationInfoBgColor">'.$settings->lightbox_navigation_info_bg_color.'</li>
                                    <li class="LightboxNavigationInfoTextColor">'.$settings->lightbox_navigation_info_text_color.'</li>
                                    <li class="LightboxNavigationDisplayTime">'.$settings->lightbox_navigation_display_time.'</li>
                                    <li class="LightboxNavigationTouchDeviceSwipeEnabled">'.$settings->lightbox_navigation_touch_device_swipe_enabled.'</li>
                                    <li class="SocialShareEnabled">'.$settings->social_share_enabled.'</li>
                                    <li class="SocialShareLightbox">'.DOPTS_Plugin_URL.$settings->social_share_lightbox.'</li>
                                    <li class="TooltipBgColor">'.$settings->tooltip_bg_color.'</li>
                                    <li class="TooltipStrokeColor">'.$settings->tooltip_stroke_color.'</li>
                                    <li class="TooltipTextColor">'.$settings->tooltip_text_color.'</li>
                                    <li class="LabelPosition">'.$settings->label_position.'</li>
                                    <li class="LabelAlwaysVisible">'.$settings->label_always_visible.'</li>
                                    <li class="LabelUnderHeight">'.$settings->label_under_height.'</li>
                                    <li class="LabelBgColor">'.$settings->label_bg_color.'</li>
                                    <li class="LabelBgAlpha">'.$settings->label_bg_alpha.'</li>
                                    <li class="LabelTextColor">'.$settings->label_text_color.'</li>
                                    <li class="SlideshowEnabled">'.$settings->slideshow_enabled.'</li>
                                    <li class="SlideshowTime">'.$settings->slideshow_time.'</li>
                                    <li class="SlideshowLoop">'.$settings->slideshow_loop.'</li>
                                </ul>
                                <ul class="Content" style="display:none;">'.implode('', $imagesList).'</ul>
                            </div>
                            <script type="text/JavaScript">
                                jQuery(document).ready(function(){
                                    jQuery(\'#DOPThumbnailScroller'.$atts['id'].'\').DOPThumbnailScroller({\'ParseMethod\': \'HTML\'});
                                });
                            </script>';
                }
                
                return $data;
            }

            function getScrollerData(){// Get Scroller Data.
                global $wpdb;
                $data = array();

                $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$_POST['id'].'"');
                
                $data['Width'] = $settings->width;
                $data['Height'] = $settings->height;
                $data['BgColor'] = $settings->bg_color;
                $data['BgAlpha'] = $settings->bg_alpha;
                $data['BgBorderSize'] = $settings->bg_border_size;
                $data['BgBorderColor'] = $settings->bg_border_color;
                $data['ThumbnailsOrder'] = $settings->images_order;
                $data['ResponsiveEnabled'] = $settings->responsive_enabled;
                $data['UltraResponsiveEnabled'] = $settings->ultra_responsive_enabled;
                $data['ThumbnailsPosition'] = $settings->thumbnails_position;
                $data['ThumbnailsBgColor'] = $settings->thumbnails_bg_color;
                $data['ThumbnailsBgAlpha'] = $settings->thumbnails_bg_alpha;
                $data['ThumbnailsBorderSize'] = $settings->thumbnails_border_size;
                $data['ThumbnailsBorderColor'] = $settings->thumbnails_border_color;
                $data['ThumbnailsSpacing'] = $settings->thumbnails_spacing;
                $data['ThumbnailsMarginTop'] = $settings->thumbnails_margin_top;
                $data['ThumbnailsMarginRight'] = $settings->thumbnails_margin_right;
                $data['ThumbnailsMarginBottom'] = $settings->thumbnails_margin_bottom;
                $data['ThumbnailsMarginLeft'] = $settings->thumbnails_margin_left;
                $data['ThumbnailsPaddingTop'] = $settings->thumbnails_padding_top;
                $data['ThumbnailsPaddingRight'] = $settings->thumbnails_padding_right;
                $data['ThumbnailsPaddingBottom'] = $settings->thumbnails_padding_bottom;
                $data['ThumbnailsPaddingLeft'] = $settings->thumbnails_padding_left;
                $data['ThumbnailsInfo'] = $settings->thumbnails_info;
                $data['ThumbnailsNavigationEasing'] = $settings->thumbnails_navigation_easing;
                $data['ThumbnailsNavigationLoop'] = $settings->thumbnails_navigation_loop;
                $data['ThumbnailsNavigationMouseEnabled'] = $settings->thumbnails_navigation_mouse_enabled;
                $data['ThumbnailsNavigationScrollEnabled'] = $settings->thumbnails_navigation_scroll_enabled;
                $data['ThumbnailsScrollPosition'] = $settings->thumbnails_scroll_position;
                $data['ThumbnailsScrollSize'] = $settings->thumbnails_scroll_size;
                $data['ThumbnailsScrollScrubColor'] = $settings->thumbnails_scroll_scrub_color;
                $data['ThumbnailsScrollBarColor'] = $settings->thumbnails_scroll_bar_color;
                $data['ThumbnailsNavigationArrowsEnabled'] = $settings->thumbnails_navigation_arrows_enabled;
                $data['ThumbnailsNavigationArrowsNoItemsSlide'] = $settings->thumbnails_navigation_arrows_no_items_slide;
                $data['ThumbnailsNavigationArrowsSpeed'] = $settings->thumbnails_navigation_arrows_speed;
                $data['ThumbnailsNavigationPrev'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev;
                $data['ThumbnailsNavigationPrevHover'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev_hover;
                $data['ThumbnailsNavigationPrevDisabled'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_prev_disabled;
                $data['ThumbnailsNavigationNext'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_next;
                $data['ThumbnailsNavigationNextHover'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_next_hover;
                $data['ThumbnailsNavigationNextDisabled'] = DOPTS_Plugin_URL.$settings->thumbnails_navigation_next_disabled;
                $data['ThumbnailLoader'] = DOPTS_Plugin_URL.$settings->thumbnail_loader;
                $data['ThumbnailWidth'] = $settings->thumbnail_width;
                $data['ThumbnailHeight'] = $settings->thumbnail_height;
                $data['ThumbnailAlpha'] = $settings->thumbnail_alpha;
                $data['ThumbnailAlphaHover'] = $settings->thumbnail_alpha_hover;
                $data['ThumbnailBgColor'] = $settings->thumbnail_bg_color;
                $data['ThumbnailBgColorHover'] = $settings->thumbnail_bg_color_hover;
                $data['ThumbnailBorderSize'] = $settings->thumbnail_border_size;
                $data['ThumbnailBorderColor'] = $settings->thumbnail_border_color;
                $data['ThumbnailBorderColorHover'] = $settings->thumbnail_border_color_hover;
                $data['ThumbnailPaddingTop'] = $settings->thumbnail_padding_top;
                $data['ThumbnailPaddingRight'] = $settings->thumbnail_padding_right;
                $data['ThumbnailPaddingBottom'] = $settings->thumbnail_padding_bottom;
                $data['ThumbnailPaddingLeft'] = $settings->thumbnail_padding_left;
                $data['LightboxEnabled'] = $settings->lightbox_enabled;
                $data['LightboxDisplayTime'] = $settings->lightbox_display_time;
                $data['LightboxWindowColor'] = $settings->lightbox_window_color;
                $data['LightboxWindowAlpha'] = $settings->lightbox_window_alpha;
                $data['LightboxLoader'] = DOPTS_Plugin_URL.$settings->lightbox_loader;
                $data['LightboxBgColor'] = $settings->lightbox_bg_color;
                $data['LightboxBgAlpha'] = $settings->lightbox_bg_alpha;
                $data['LightboxBorderSize'] = $settings->lightbox_border_size;
                $data['LightboxBorderColor'] = $settings->lightbox_border_color;
                $data['LightboxCaptionTextColor'] = $settings->lightbox_caption_text_color;
                $data['LightboxMarginTop'] = $settings->lightbox_margin_top;
                $data['LightboxMarginRight'] = $settings->lightbox_margin_right;
                $data['LightboxMarginBottom'] = $settings->lightbox_margin_bottom;
                $data['LightboxMarginLeft'] = $settings->lightbox_margin_left;
                $data['LightboxPaddingTop'] = $settings->lightbox_padding_top;
                $data['LightboxPaddingRight'] = $settings->lightbox_padding_right;
                $data['LightboxPaddingBottom'] = $settings->lightbox_padding_bottom;
                $data['LightboxPaddingLeft'] = $settings->lightbox_padding_left;
                $data['LightboxNavigationPrev'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_prev;
                $data['LightboxNavigationPrevHover'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_prev_hover;
                $data['LightboxNavigationNext'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_next;
                $data['LightboxNavigationNextHover'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_next_hover;
                $data['LightboxNavigationClose'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_close;
                $data['LightboxNavigationCloseHover'] = DOPTS_Plugin_URL.$settings->lightbox_navigation_close_hover;
                $data['LightboxNavigationInfoBgColor'] = $settings->lightbox_navigation_info_bg_color;
                $data['LightboxNavigationInfoTextColor'] = $settings->lightbox_navigation_info_text_color;
                $data['LightboxNavigationDisplayTime'] = $settings->lightbox_navigation_display_time;
                $data['LightboxNavigationTouchDeviceSwipeEnabled'] = $settings->lightbox_navigation_touch_device_swipe_enabled;
                $data['SocialShareEnabled'] = $settings->social_share_enabled;
                $data['SocialShareLightbox'] = DOPTS_Plugin_URL.$settings->social_share_lightbox;
                $data['TooltipBgColor'] = $settings->tooltip_bg_color;
                $data['TooltipStrokeColor'] = $settings->tooltip_stroke_color;
                $data['TooltipTextColor'] = $settings->tooltip_text_color;
                $data['LabelPosition'] = $settings->label_position;
                $data['LabelAlwaysVisible'] = $settings->label_always_visible;
                $data['LabelUnderHeight'] = $settings->label_under_height;
                $data['LabelBgColor'] = $settings->label_bg_color;
                $data['LabelBgAlpha'] = $settings->label_bg_alpha;
                $data['LabelTextColor'] = $settings->label_text_color;
                $data['SlideshowEnabled'] = $settings->slideshow_enabled;
                $data['SlideshowTime'] = $settings->slideshow_time;
                $data['SlideshowLoop'] = $settings->slideshow_loop;          

                echo json_encode($data);
            }
        }
    }
?>