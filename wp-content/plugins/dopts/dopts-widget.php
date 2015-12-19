<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : dopts-widget.php
* File Version            : 1.3
* Created / Last Modified : 05 May 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Widget Class.
*/
  
    class DOPThumbnailScrollerWidget extends WP_Widget{
        
        function DOPThumbnailScrollerWidget(){
            $widget_ops = array('classname' => 'DOPThumbnailScrollerWidget', 'description' => !is_admin() ? '':DOPTS_WIDGET_DESCRIPTION);
            $this->WP_Widget('DOPThumbnailScrollerWidget', !is_admin() ? '':DOPTS_WIDGET_TITLE, $widget_ops);
        }
 
        function form($instance){
            global $wpdb;
            
            $instance = wp_parse_args((array)$instance, array('title' => '', 'id' => '0'));
            $title = $instance['title'];
            $id = $instance['id'];
                            
            $scrollersHTML = array();
            
            array_push($scrollersHTML, '<p>');
            array_push($scrollersHTML, '    <label for="'.$this->get_field_id('title').'">'.DOPTS_WIDGET_LABEL_TITLE.' </label>');
            array_push($scrollersHTML, '    <input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'" />');
            
            array_push($scrollersHTML, '    <label for="'.$this->get_field_id('id').'" style=" display: block; padding-top: 10px;">'.DOPTS_WIDGET_LABEL_ID.' </label>');
            array_push($scrollersHTML, '    <select class="widefat" id="'.$this->get_field_id('id').'" name="'.$this->get_field_name('id').'">');

            $scrollers = $wpdb->get_results('SELECT * FROM '.DOPTS_Scrollers_table.' ORDER BY id DESC');

            if ($wpdb->num_rows != 0){
                foreach ($scrollers as $scroller) {
                    if (esc_attr($id) == $scroller->id){
                        array_push($scrollersHTML, '<option value="'.$scroller->id.'" selected="selected">'.$scroller->id.' - '.$scroller->name.'</option>');
                        
                    }
                    else{
                        array_push($scrollersHTML, '<option value="'.$scroller->id.'">'.$scroller->id.' - '.$scroller->name.'</option>');
                    }
                }
            }
            else{
                array_push($scrollersHTML, '<option value="0">'.DOPTS_WIDGET_NO_SCROLLERS.'</option>');
            }
            
            array_push($scrollersHTML, '    </select>');
            array_push($scrollersHTML, '</p>');

            echo implode('', $scrollersHTML);
        }
 
        function update($new_instance, $old_instance){
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['id'] = $new_instance['id'];
            
            return $instance;
        }

        function widget($args, $instance){
            global $wpdb;
            $data = array();
            $imagesList = array();
            extract($args, EXTR_SKIP);

            echo $before_widget;
            $title = empty($instance['title']) ? ' ':apply_filters('widget_title', $instance['title']);
            $id = empty($instance['id']) ? '0':$instance['id'];
 
            if (!empty($title)){
                echo $before_title.$title.$after_title;        
            }
                
            $default_settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="0"');
            $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$id.'"');

            if ($default_settings->data_parse_method == 'ajax'){
                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$id.'" AND enabled="true" ORDER BY position');

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
                    
                echo '<div class="DOPThumbnailScrollerContainer" id="DOPThumbnailScroller'.$id.'">
                          <a href="'.DOPTS_Plugin_URL.'frontend-ajax.php" class="Settings"></a>
                          <ul class="Content" style="display:none;">'.implode('', $imagesList).'</ul>
                      </div>
                      <script type="text/JavaScript">
                          jQuery(document).ready(function(){
                              jQuery(\'#DOPThumbnailScroller'.$id.'\').DOPThumbnailScroller();
                          });
                      </script>';
            }
            else{
                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$id.'" AND enabled="true" ORDER BY position');

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

                echo '<div class="DOPThumbnailScrollerContainer" id="DOPThumbnailScroller'.$id.'">
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
                            jQuery(\'#DOPThumbnailScroller'.$id.'\').DOPThumbnailScroller({\'ParseMethod\': \'HTML\'});
                        });
                    </script>';
            }

            return $data;

            echo $after_widget;
        }

    }

?>