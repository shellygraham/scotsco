<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : dopts-backend.php
* File Version            : 1.5
* Created / Last Modified : 01 October 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Back End Class.
*/

    if (!class_exists("DOPThumbnailScrollerBackEnd")){
        class DOPThumbnailScrollerBackEnd{
            private $DOPTS_AddEditScrollers;
            private $DOPTS_db_version = 1.6;

            function DOPThumbnailScrollerBackEnd(){// Constructor.
                if (is_admin()){
                    add_action('admin_enqueue_scripts', array(&$this, 'addWPAdminStyles'));
                    
                    if ($this->validPage()){
                        $this->DOPTS_AddEditScrollers = new DOPTSTemplates();
                        add_action('admin_enqueue_scripts', array(&$this, 'addStyles'));
                        add_action('admin_enqueue_scripts', array(&$this, 'addScripts'));
                    }

                    $this->addDOPTStoTinyMCE();
                    $this->init();
                }
            }
            
            function addWPAdminStyles(){
                // Register Styles.
                wp_register_style('DOPTS_WPAdminStyle', plugins_url('assets/gui/css/backend-wp-admin-style.css', __FILE__));

                // Enqueue Styles.
                wp_enqueue_style('DOPTS_WPAdminStyle');
            }
            
            function addStyles(){
                // Register Styles.
                wp_register_style('DOPTS_UploadifyStyle', plugins_url('libraries/gui/css/uploadify.css', __FILE__));
                wp_register_style('DOPTS_JcropStyle', plugins_url('libraries/gui/css/jquery.Jcrop.css', __FILE__));
                wp_register_style('DOPTS_ColorPickerStyle', plugins_url('libraries/gui/css/colorpicker.css', __FILE__));
                wp_register_style('DOPTS_AdminStyle', plugins_url('assets/gui/css/backend-style.css', __FILE__));

                // Enqueue Styles.
                wp_enqueue_style('thickbox');
                wp_enqueue_style('DOPTS_UploadifyStyle');
                wp_enqueue_style('DOPTS_JcropStyle');
                wp_enqueue_style('DOPTS_ColorPickerStyle');
                wp_enqueue_style('DOPTS_AdminStyle');
            }
            
            function addScripts(){
                // Register JavaScript.
                wp_register_script('DOPTS_SwfJS', plugins_url('libraries/js/swfobject.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPTS_UploadifyJS', plugins_url('libraries/js/jquery.uploadify.min.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPTS_JcropJS', plugins_url('libraries/js/jquery.Jcrop.min.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPTS_ColorPickerJS', plugins_url('libraries/js/colorpicker.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPTS_DOPImageLoaderJS', plugins_url('libraries/js/jquery.dop.ImageLoader.min.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPTS_DOPTSJS', plugins_url('assets/js/dopts-backend.js', __FILE__), array('jquery'), false, true);

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-ui-sortable', 'queue')){
                    wp_enqueue_script('jquery-ui-sortable');
                }
                
                wp_enqueue_script('media-upload');
                
                if (!wp_script_is('thickbox', 'queue')){
                    wp_enqueue_script('thickbox');
                }
                wp_enqueue_script('my-upload');
                wp_enqueue_script('DOPTS_SwfJS');
                wp_enqueue_script('DOPTS_UploadifyJS');
                wp_enqueue_script('DOPTS_JcropJS');
                wp_enqueue_script('DOPTS_ColorPickerJS');
                wp_enqueue_script('DOPTS_DOPImageLoaderJS');
                wp_enqueue_script('DOPTS_DOPTSJS');
            }
            
            function init(){// Admin init.
                $this->initConstants();
                $this->initTables();

                if (strrpos(strtolower(php_uname()), 'windows') === false && $this->validPage()){
                    $this->initUploadFolders();
                }
            }

            function initConstants(){// Constants init.
                global $wpdb;
                
                // Tables
                define('DOPTS_Settings_table', $wpdb->prefix.'dopts_settings');
                define('DOPTS_Scrollers_table', $wpdb->prefix.'dopts_scrollers');
                define('DOPTS_Images_table', $wpdb->prefix.'dopts_images');
            }

            function validPage(){// Valid Admin Page.
                if (isset($_GET['page'])){
                    if ($_GET['page'] == 'dopts' || $_GET['page'] == 'dopts-help'){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }

            function initTables(){// Tables init.
                //update_option('DOPTS_db_version', '1.0');
                $current_db_version = get_option('DOPTS_db_version');
                
                if ($this->DOPTS_db_version != $current_db_version){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');

                    $sql_settings = "CREATE TABLE " . DOPTS_Settings_table . " (
                                        id int NOT NULL AUTO_INCREMENT,
                                        name VARCHAR(128) DEFAULT '" . DOPTS_ADD_SCROLLER_NAME . "' COLLATE utf8_unicode_ci NOT NULL,
                                        scroller_id int DEFAULT 0 NOT NULL,
                                        data_parse_method VARCHAR(4) DEFAULT 'ajax' COLLATE utf8_unicode_ci NOT NULL,
                                        width int DEFAULT 900 NOT NULL,
                                        height int DEFAULT 128 NOT NULL,
                                        bg_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        bg_alpha int DEFAULT 100 NOT NULL,
                                        bg_border_size int DEFAULT 1 NOT NULL,
                                        bg_border_color VARCHAR(6) DEFAULT 'e0e0e0' COLLATE utf8_unicode_ci NOT NULL,
                                        images_order VARCHAR(6) DEFAULT 'normal' COLLATE utf8_unicode_ci NOT NULL,
                                        responsive_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        ultra_responsive_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_position VARCHAR(16) DEFAULT 'horizontal' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_bg_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_bg_alpha int DEFAULT 0 NOT NULL,
                                        thumbnails_border_size int DEFAULT 0 NOT NULL,
                                        thumbnails_border_color VARCHAR(6) DEFAULT 'e0e0e0' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_spacing int DEFAULT 10 NOT NULL,
                                        thumbnails_margin_top int DEFAULT 10 NOT NULL,
                                        thumbnails_margin_right int DEFAULT 0 NOT NULL,
                                        thumbnails_margin_bottom int DEFAULT 10 NOT NULL,
                                        thumbnails_margin_left int DEFAULT 0 NOT NULL,
                                        thumbnails_padding_top int DEFAULT 0 NOT NULL,
                                        thumbnails_padding_right int DEFAULT 0 NOT NULL,
                                        thumbnails_padding_bottom int DEFAULT 0 NOT NULL,
                                        thumbnails_padding_left int DEFAULT 0 NOT NULL,
                                        thumbnails_info VARCHAR(8) DEFAULT 'label' COLLATE utf8_unicode_ci NOT NULL, 
                                        thumbnails_navigation_easing VARCHAR(32) DEFAULT 'linear' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_loop VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_mouse_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_scroll_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_scroll_position VARCHAR(16) DEFAULT 'bottom/right' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_scroll_size int DEFAULT 5 NOT NULL,
                                        thumbnails_scroll_scrub_color VARCHAR(6) DEFAULT '808080' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_scroll_bar_color VARCHAR(6) DEFAULT 'e0e0e0' COLLATE utf8_unicode_ci NOT NULL,           
                                        thumbnails_navigation_arrows_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_arrows_no_items_slide int DEFAULT 1 NOT NULL,
                                        thumbnails_navigation_arrows_speed int DEFAULT 600 NOT NULL,
                                        thumbnails_navigation_prev VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsPrev.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_prev_hover VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsPrevHover.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_prev_disabled VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsPrevDisabled.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_next VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsNext.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_next_hover VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsNextHover.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnails_navigation_next_disabled VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailsNextDisabled.png' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_loader VARCHAR(128) DEFAULT 'assets/gui/images/ThumbnailLoader.gif' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_width int DEFAULT 100 NOT NULL,
                                        thumbnail_height int DEFAULT 100 NOT NULL,
                                        thumbnail_alpha int DEFAULT 100 NOT NULL,
                                        thumbnail_alpha_hover int DEFAULT 100 NOT NULL,
                                        thumbnail_bg_color VARCHAR(6) DEFAULT 'f1f1f1' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_bg_color_hover VARCHAR(6) DEFAULT 'f1f1f1' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_border_size int DEFAULT 1 NOT NULL,
                                        thumbnail_border_color VARCHAR(6) DEFAULT 'd0d0d0' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_border_color_hover VARCHAR(6) DEFAULT '303030' COLLATE utf8_unicode_ci NOT NULL,
                                        thumbnail_padding_top int DEFAULT 2 NOT NULL,
                                        thumbnail_padding_right int DEFAULT 2 NOT NULL,
                                        thumbnail_padding_bottom int DEFAULT 2 NOT NULL,
                                        thumbnail_padding_left int DEFAULT 2 NOT NULL,
                                        lightbox_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_display_time int DEFAULT 600 NOT NULL,
                                        lightbox_window_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_window_alpha int DEFAULT 80 NOT NULL,
                                        lightbox_loader VARCHAR(128) DEFAULT 'assets/gui/images/LightboxLoader.gif' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_bg_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_bg_alpha int DEFAULT 100 NOT NULL,
                                        lightbox_border_size int DEFAULT 1 NOT NULL,
                                        lightbox_border_color VARCHAR(6) DEFAULT 'e0e0e0' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_caption_text_color VARCHAR(6) DEFAULT '999999' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_margin_top int DEFAULT 30 NOT NULL,
                                        lightbox_margin_right int DEFAULT 30 NOT NULL,
                                        lightbox_margin_bottom int DEFAULT 30 NOT NULL,
                                        lightbox_margin_left int DEFAULT 30 NOT NULL,
                                        lightbox_padding_top int DEFAULT 10 NOT NULL,
                                        lightbox_padding_right int DEFAULT 10 NOT NULL,
                                        lightbox_padding_bottom int DEFAULT 10 NOT NULL,
                                        lightbox_padding_left int DEFAULT 10 NOT NULL,
                                        lightbox_navigation_prev VARCHAR(128) DEFAULT 'assets/gui/images/LightboxPrev.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_prev_hover VARCHAR(128) DEFAULT 'assets/gui/images/LightboxPrevHover.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_next VARCHAR(128) DEFAULT 'assets/gui/images/LightboxNext.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_next_hover VARCHAR(128) DEFAULT 'assets/gui/images/LightboxNextHover.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_close VARCHAR(128) DEFAULT 'assets/gui/images/LightboxClose.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_close_hover VARCHAR(128) DEFAULT 'assets/gui/images/LightboxCloseHover.png' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_info_bg_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_navigation_info_text_color VARCHAR(6) DEFAULT 'c0c0c0' COLLATE utf8_unicode_ci NOT NULL,        
                                        lightbox_navigation_display_time int DEFAULT 600 NOT NULL,
                                        lightbox_navigation_touch_device_swipe_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        social_share_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        social_share_lightbox VARCHAR(128) DEFAULT 'assets/gui/images/SocialShareLightbox.png' COLLATE utf8_unicode_ci NOT NULL,
                                        tooltip_bg_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        tooltip_stroke_color VARCHAR(6) DEFAULT '000000' COLLATE utf8_unicode_ci NOT NULL,
                                        tooltip_text_color VARCHAR(6) DEFAULT '000000' COLLATE utf8_unicode_ci NOT NULL,  
                                        label_position VARCHAR(6) DEFAULT 'bottom' COLLATE utf8_unicode_ci NOT NULL,
                                        label_always_visible VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        label_under_height int DEFAULT 50 NOT NULL,
                                        label_bg_color VARCHAR(6) DEFAULT '000000' COLLATE utf8_unicode_ci NOT NULL,  
                                        label_bg_alpha int DEFAULT 80 NOT NULL,                           
                                        label_text_color VARCHAR(6) DEFAULT 'ffffff' COLLATE utf8_unicode_ci NOT NULL,
                                        slideshow_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        slideshow_time int DEFAULT 5000 NOT NULL,
                                        slideshow_loop VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    $sql_scrollers = "CREATE TABLE " . DOPTS_Scrollers_table . " (
                                        id int NOT NULL AUTO_INCREMENT,
                                        name VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    $sql_images = "CREATE TABLE " . DOPTS_Images_table . " (
                                        id int NOT NULL AUTO_INCREMENT,
                                        scroller_id int DEFAULT 0 NOT NULL,
                                        name VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        title VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        caption TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        media TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        lightbox_media TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        link VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        target VARCHAR(16) DEFAULT '_blank' COLLATE utf8_unicode_ci NOT NULL,
                                        enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        position int DEFAULT 0 NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    dbDelta($sql_settings);
                    dbDelta($sql_scrollers);
                    dbDelta($sql_images);

                    if ($current_db_version == ''){
                        add_option('DOPTS_db_version', $this->DOPTS_db_version);
                    }
                    else{
                        update_option('DOPTS_db_version', $this->DOPTS_db_version);
                    }

                    $this->initTablesData();
                }
            }   
            
            function initTablesData(){
                global $wpdb;
                
                $settings = $wpdb->get_results('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id=0');
                
                if ($wpdb->num_rows == 0){
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => DOPTS_DEFAULT_SETTINGS,
                                                                      'scroller_id' => 0)));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 1',
                                                                      'scroller_id' => 0)));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 2',
                                                                      'scroller_id' => 0,
                                                                      'width' => 900,
                                                                      'height' => 147,
                                                                      'bg_color' => 'c0c0c0',
                                                                      'bg_alpha' => 100,
                                                                      'bg_border_size' => 3,
                                                                      'bg_border_color' => 'eeeeee',
                                                                      'images_order' => 'random',
                                                                      'responsive_enabled' => 'true',
                                                                      'ultra_responsive_enabled' => 'false',
                                                                      'thumbnails_position' => 'horizontal',
                                                                      'thumbnails_bg_color' => 'c0c0c0',
                                                                      'thumbnails_bg_alpha' => 0,
                                                                      'thumbnails_border_size' => 0,
                                                                      'thumbnails_border_color' => 'e0e0e0',
                                                                      'thumbnails_spacing' => 10,
                                                                      'thumbnails_margin_top' => 10,
                                                                      'thumbnails_margin_right' => 0,
                                                                      'thumbnails_margin_bottom' => 10,
                                                                      'thumbnails_margin_left' => 0,
                                                                      'thumbnails_padding_top' => 0,
                                                                      'thumbnails_padding_right' => 0,
                                                                      'thumbnails_padding_bottom' => 0,
                                                                      'thumbnails_padding_left' => 0,
                                                                      'thumbnails_info' => 'tooltip',
                                                                      'thumbnails_navigation_easing' => 'linear',
                                                                      'thumbnails_navigation_loop' => 'false',
                                                                      'thumbnails_navigation_mouse_enabled' => 'false',
                                                                      'thumbnails_navigation_scroll_enabled' => 'true',
                                                                      'thumbnails_scroll_position' => 'bottom/right',
                                                                      'thumbnails_scroll_size' => 5,
                                                                      'thumbnails_scroll_scrub_color' => '707070',
                                                                      'thumbnails_scroll_bar_color' => 'e0e0e0',
                                                                      'thumbnails_navigation_arrows_enabled' => 'true',
                                                                      'thumbnails_navigation_arrows_no_items_slide' => 1,
                                                                      'thumbnails_navigation_arrows_speed' => 600,
                                                                      'thumbnails_navigation_prev' => 'assets/gui/images/ThumbnailsPrev2.png',
                                                                      'thumbnails_navigation_prev_hover' => 'assets/gui/images/ThumbnailsPrevHover2.png',
                                                                      'thumbnails_navigation_prev_disabled' => 'assets/gui/images/ThumbnailsPrevDisabled2.png',
                                                                      'thumbnails_navigation_next' => 'assets/gui/images/ThumbnailsNext2.png',
                                                                      'thumbnails_navigation_next_hover' => 'assets/gui/images/ThumbnailsNextHover2.png',
                                                                      'thumbnails_navigation_next_disabled' => 'assets/gui/images/ThumbnailsNextDisabled2.png',
                                                                      'thumbnail_loader' => 'assets/gui/images/ThumbnailLoader2.gif',
                                                                      'thumbnail_width' => 100,
                                                                      'thumbnail_height' => 100,
                                                                      'thumbnail_alpha' => 100,
                                                                      'thumbnail_alpha_hover' => 100,
                                                                      'thumbnail_bg_color' => '606060',
                                                                      'thumbnail_bg_color_hover' => '202020',
                                                                      'thumbnail_border_size' => 0,
                                                                      'thumbnail_border_color' => 'c0c0c0',
                                                                      'thumbnail_border_color_hover' => '000000',
                                                                      'thumbnail_padding_top' => 3,
                                                                      'thumbnail_padding_right' => 3,
                                                                      'thumbnail_padding_bottom' => 3,
                                                                      'thumbnail_padding_left' => 3,
                                                                      'lightbox_enabled' => 'true',
                                                                      'lightbox_display_time' => 600,
                                                                      'lightbox_window_color' => 'f0f0f0',
                                                                      'lightbox_window_alpha' => 80,
                                                                      'lightbox_loader' => 'assets/gui/images/LightboxLoader2.gif',
                                                                      'lightbox_bg_color' => '606060',
                                                                      'lightbox_bg_alpha' => 100,
                                                                      'lightbox_border_size' => 1,
                                                                      'lightbox_border_color' => 'e0e0e0',
                                                                      'lightbox_caption_text_color' => '999999',
                                                                      'lightbox_margin_top' => 30,
                                                                      'lightbox_margin_right' => 30,
                                                                      'lightbox_margin_bottom' => 30,
                                                                      'lightbox_margin_left' => 30,
                                                                      'lightbox_padding_top' => 10,
                                                                      'lightbox_padding_right' => 10,
                                                                      'lightbox_padding_bottom' => 10,
                                                                      'lightbox_padding_left' => 10,
                                                                      'lightbox_navigation_prev' => 'assets/gui/images/LightboxPrev2.png',
                                                                      'lightbox_navigation_prev_hover' => 'assets/gui/images/LightboxPrevHover2.png',
                                                                      'lightbox_navigation_next' => 'assets/gui/images/LightboxNext2.png',
                                                                      'lightbox_navigation_next_hover' => 'assets/gui/images/LightboxNextHover2.png',
                                                                      'lightbox_navigation_close' => 'assets/gui/images/LightboxClose2.png',
                                                                      'lightbox_navigation_close_hover' => 'assets/gui/images/LightboxCloseHover2.png',
                                                                      'lightbox_navigation_info_bg_color' => '606060',
                                                                      'lightbox_navigation_info_text_color' => 'e0e0e0',
                                                                      'lightbox_navigation_display_time' => 600,
                                                                      'lightbox_navigation_touch_device_swipe_enabled' => 'true',
                                                                      'social_share_enabled' => 'true',
                                                                      'social_share_lightbox' => 'assets/gui/images/SocialShareLightbox2.png',
                                                                      'tooltip_bg_color' => 'ffffff',
                                                                      'tooltip_stroke_color' => '000000',
                                                                      'tooltip_text_color' => '000000',
                                                                      'label_position' => 'bottom',
                                                                      'label_always_visible' => 'false',
                                                                      'label_under_height' => 50,
                                                                      'label_bg_color' => '000000',
                                                                      'label_bg_alpha' => 80,
                                                                      'label_text_color' => 'ffffff',
                                                                      'slideshow_enabled' => 'true',
                                                                      'slideshow_time' => 5000,
                                                                      'slideshow_loop' => 'true')));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 3',
                                                                      'scroller_id' => 0,
                                                                      'width' => 901,
                                                                      'height' => 238,
                                                                      'bg_color' => '000000',
                                                                      'bg_alpha' => 100,
                                                                      'bg_border_size' => 1,
                                                                      'bg_border_color' => '000000',
                                                                      'images_order' => 'random',
                                                                      'responsive_enabled' => 'true',
                                                                      'ultra_responsive_enabled' => 'true',
                                                                      'thumbnails_position' => 'horizontal',
                                                                      'thumbnails_bg_color' => '000000',
                                                                      'thumbnails_bg_alpha' => 0,
                                                                      'thumbnails_border_size' => 0,
                                                                      'thumbnails_border_color' => 'e0e0e0',
                                                                      'thumbnails_spacing' => 9,
                                                                      'thumbnails_margin_top' => 10,
                                                                      'thumbnails_margin_right' => 0,
                                                                      'thumbnails_margin_bottom' => 10,
                                                                      'thumbnails_margin_left' => 0,
                                                                      'thumbnails_padding_top' => 0,
                                                                      'thumbnails_padding_right' => 0,
                                                                      'thumbnails_padding_bottom' => 0,
                                                                      'thumbnails_padding_left' => 0,
                                                                      'thumbnails_info' => 'label',
                                                                      'thumbnails_navigation_easing' => 'linear',
                                                                      'thumbnails_navigation_loop' => 'false',
                                                                      'thumbnails_navigation_mouse_enabled' => 'false',
                                                                      'thumbnails_navigation_scroll_enabled' => 'true',
                                                                      'thumbnails_scroll_position' => 'bottom/right',
                                                                      'thumbnails_scroll_size' => 7,
                                                                      'thumbnails_scroll_scrub_color' => 'afbd21',
                                                                      'thumbnails_scroll_bar_color' => '606060',
                                                                      'thumbnails_navigation_arrows_enabled' => 'true',
                                                                      'thumbnails_navigation_arrows_no_items_slide' => 3,
                                                                      'thumbnails_navigation_arrows_speed' => 600,
                                                                      'thumbnails_navigation_prev' => 'assets/gui/images/ThumbnailsPrev3.png',
                                                                      'thumbnails_navigation_prev_hover' => 'assets/gui/images/ThumbnailsPrevHover3.png',
                                                                      'thumbnails_navigation_prev_disabled' => 'assets/gui/images/ThumbnailsPrevDisabled3.png',
                                                                      'thumbnails_navigation_next' => 'assets/gui/images/ThumbnailsNext3.png',
                                                                      'thumbnails_navigation_next_hover' => 'assets/gui/images/ThumbnailsNextHover3.png',
                                                                      'thumbnails_navigation_next_disabled' => 'assets/gui/images/ThumbnailsNextDisabled3.png',
                                                                      'thumbnail_loader' => 'assets/gui/images/ThumbnailLoader3.gif',
                                                                      'thumbnail_width' => 262,
                                                                      'thumbnail_height' => 200,
                                                                      'thumbnail_alpha' => 90,
                                                                      'thumbnail_alpha_hover' => 100,
                                                                      'thumbnail_bg_color' => '000000',
                                                                      'thumbnail_bg_color_hover' => '000000',
                                                                      'thumbnail_border_size' => 0,
                                                                      'thumbnail_border_color' => 'd0d0d0',
                                                                      'thumbnail_border_color_hover' => '303030',
                                                                      'thumbnail_padding_top' => 0,
                                                                      'thumbnail_padding_right' => 0,
                                                                      'thumbnail_padding_bottom' => 0,
                                                                      'thumbnail_padding_left' => 0,
                                                                      'lightbox_enabled' => 'true',
                                                                      'lightbox_display_time' => 600,
                                                                      'lightbox_window_color' => '000000',
                                                                      'lightbox_window_alpha' => 80,
                                                                      'lightbox_loader' => 'assets/gui/images/LightboxLoader3.gif',
                                                                      'lightbox_bg_color' => '202020',
                                                                      'lightbox_bg_alpha' => 100,
                                                                      'lightbox_border_size' => 2,
                                                                      'lightbox_border_color' => '000000',
                                                                      'lightbox_caption_text_color' => '999999',
                                                                      'lightbox_margin_top' => 30,
                                                                      'lightbox_margin_right' => 30,
                                                                      'lightbox_margin_bottom' => 30,
                                                                      'lightbox_margin_left' => 30,
                                                                      'lightbox_padding_top' => 10,
                                                                      'lightbox_padding_right' => 10,
                                                                      'lightbox_padding_bottom' => 10,
                                                                      'lightbox_padding_left' => 10,
                                                                      'lightbox_navigation_prev' => 'assets/gui/images/LightboxPrev3.png',
                                                                      'lightbox_navigation_prev_hover' => 'assets/gui/images/LightboxPrevHover3.png',
                                                                      'lightbox_navigation_next' => 'assets/gui/images/LightboxNext3.png',
                                                                      'lightbox_navigation_next_hover' => 'assets/gui/images/LightboxNextHover3.png',
                                                                      'lightbox_navigation_close' => 'assets/gui/images/LightboxClose3.png',
                                                                      'lightbox_navigation_close_hover' => 'assets/gui/images/LightboxCloseHover3.png',
                                                                      'lightbox_navigation_info_bg_color' => '202020',
                                                                      'lightbox_navigation_info_text_color' => 'ffffff',
                                                                      'lightbox_navigation_display_time' => 600,
                                                                      'lightbox_navigation_touch_device_swipe_enabled' => 'true',
                                                                      'social_share_enabled' => 'false',
                                                                      'social_share_lightbox' => 'assets/gui/images/SocialShareLightbox3.png',
                                                                      'tooltip_bg_color' => 'ffffff',
                                                                      'tooltip_stroke_color' => '000000',
                                                                      'tooltip_text_color' => '000000',
                                                                      'label_position' => 'top',
                                                                      'label_always_visible' => 'false',
                                                                      'label_under_height' => 50,
                                                                      'label_bg_color' => '000000',
                                                                      'label_bg_alpha' => 80,
                                                                      'label_text_color' => 'ffffff',
                                                                      'slideshow_enabled' => 'false',
                                                                      'slideshow_time' => 5000,
                                                                      'slideshow_loop' => 'false')));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 4',
                                                                      'scroller_id' => 0,
                                                                      'width' => 901,
                                                                      'height' => 128,
                                                                      'bg_color' => 'ffffff',
                                                                      'bg_alpha' => 0,
                                                                      'bg_border_size' => 0,
                                                                      'bg_border_color' => 'e0e0e0',
                                                                      'images_order' => 'random',
                                                                      'ultra_responsive_enabled' => 'true',
                                                                      'thumbnails_position' => 'horizontal',
                                                                      'thumbnails_bg_color' => 'ffffff',
                                                                      'thumbnails_bg_alpha' => 100,
                                                                      'thumbnails_border_size' => 1,
                                                                      'thumbnails_border_color' => 'e0e0e0',
                                                                      'thumbnails_spacing' => 10,
                                                                      'thumbnails_margin_top' => 0,
                                                                      'thumbnails_margin_right' => 0,
                                                                      'thumbnails_margin_bottom' => 0,
                                                                      'thumbnails_margin_left' => 0,
                                                                      'thumbnails_padding_top' => 10,
                                                                      'thumbnails_padding_right' => 10,
                                                                      'thumbnails_padding_bottom' => 10,
                                                                      'thumbnails_padding_left' => 10,
                                                                      'thumbnails_info' => 'tooltip',
                                                                      'thumbnails_navigation_easing' => 'linear',
                                                                      'thumbnails_navigation_loop' => 'false',
                                                                      'thumbnails_navigation_mouse_enabled' => 'true',
                                                                      'thumbnails_navigation_scroll_enabled' => 'false',
                                                                      'thumbnails_scroll_position' => 'bottom/right',
                                                                      'thumbnails_scroll_size' => 5,
                                                                      'thumbnails_scroll_scrub_color' => '808080',
                                                                      'thumbnails_scroll_bar_color' => 'e0e0e0',
                                                                      'thumbnails_navigation_arrows_enabled' => 'true',
                                                                      'thumbnails_navigation_arrows_no_items_slide' => 1,
                                                                      'thumbnails_navigation_arrows_speed' => 600,
                                                                      'thumbnails_navigation_prev' => 'assets/gui/images/ThumbnailsPrev4.png',
                                                                      'thumbnails_navigation_prev_hover' => 'assets/gui/images/ThumbnailsPrevHover4.png',
                                                                      'thumbnails_navigation_prev_disabled' => 'assets/gui/images/ThumbnailsPrevDisabled4.png',
                                                                      'thumbnails_navigation_next' => 'assets/gui/images/ThumbnailsNext4.png',
                                                                      'thumbnails_navigation_next_hover' => 'assets/gui/images/ThumbnailsNextHover4.png',
                                                                      'thumbnails_navigation_next_disabled' => 'assets/gui/images/ThumbnailsNextDisabled4.png',
                                                                      'thumbnail_loader' => 'assets/gui/images/ThumbnailLoader.gif',
                                                                      'thumbnail_width' => 100,
                                                                      'thumbnail_height' => 100,
                                                                      'thumbnail_alpha' => 100,
                                                                      'thumbnail_alpha_hover' => 100,
                                                                      'thumbnail_bg_color' => 'f1f1f1',
                                                                      'thumbnail_bg_color_hover' => 'f1f1f1',
                                                                      'thumbnail_border_size' => 1,
                                                                      'thumbnail_border_color' => 'd0d0d0',
                                                                      'thumbnail_border_color_hover' => '303030',
                                                                      'thumbnail_padding_top' => 2,
                                                                      'thumbnail_padding_right' => 2,
                                                                      'thumbnail_padding_bottom' => 2,
                                                                      'thumbnail_padding_left' => 2,
                                                                      'lightbox_enabled' => 'true',
                                                                      'lightbox_display_time' => 600,
                                                                      'lightbox_window_color' => 'ffffff',
                                                                      'lightbox_window_alpha' => 80,
                                                                      'lightbox_loader' => 'assets/gui/images/LightboxLoader.gif',
                                                                      'lightbox_bg_color' => 'ffffff',
                                                                      'lightbox_bg_alpha' => 100,
                                                                      'lightbox_border_size' => 1,
                                                                      'lightbox_border_color' => 'e0e0e0',
                                                                      'lightbox_caption_text_color' => '999999',
                                                                      'lightbox_margin_top' => 30,
                                                                      'lightbox_margin_right' => 30,
                                                                      'lightbox_margin_bottom' => 30,
                                                                      'lightbox_margin_left' => 30,
                                                                      'lightbox_padding_top' => 10,
                                                                      'lightbox_padding_right' => 10,
                                                                      'lightbox_padding_bottom' => 10,
                                                                      'lightbox_padding_left' => 10,
                                                                      'lightbox_navigation_prev' => 'assets/gui/images/LightboxPrev.png',
                                                                      'lightbox_navigation_prev_hover' => 'assets/gui/images/LightboxPrevHover.png',
                                                                      'lightbox_navigation_next' => 'assets/gui/images/LightboxNext.png',
                                                                      'lightbox_navigation_next_hover' => 'assets/gui/images/LightboxNextHover.png',
                                                                      'lightbox_navigation_close' => 'assets/gui/images/LightboxClose.png',
                                                                      'lightbox_navigation_close_hover' => 'assets/gui/images/LightboxCloseHover.png',
                                                                      'lightbox_navigation_info_bg_color' => 'ffffff',
                                                                      'lightbox_navigation_info_text_color' => 'c0c0c0',
                                                                      'lightbox_navigation_display_time' => 600,
                                                                      'lightbox_navigation_touch_device_swipe_enabled' => 'true',
                                                                      'social_share_enabled' => 'false',
                                                                      'social_share_lightbox' => 'assets/gui/images/SocialShareLightbox.png',
                                                                      'tooltip_bg_color' => 'ffffff',
                                                                      'tooltip_stroke_color' => '000000',
                                                                      'tooltip_text_color' => '000000',
                                                                      'label_position' => 'bottom',
                                                                      'label_always_visible' => 'false',
                                                                      'label_under_height' => 50,
                                                                      'label_bg_color' => '000000',
                                                                      'label_bg_alpha' => 80,
                                                                      'label_text_color' => 'ffffff',
                                                                      'slideshow_enabled' => 'true',
                                                                      'slideshow_time' => 5000,
                                                                      'slideshow_loop' => 'true')));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 5',
                                                                      'scroller_id' => 0,
                                                                      'width' => 243,
                                                                      'height' => 360,
                                                                      'bg_color' => 'ffffff',
                                                                      'bg_alpha' => 100,
                                                                      'bg_border_size' => 1,
                                                                      'bg_border_color' => 'e0e0e0',
                                                                      'images_order' => 'random',
                                                                      'responsive_enabled' => 'true',
                                                                      'ultra_responsive_enabled' => 'true',
                                                                      'thumbnails_position' => 'vertical',
                                                                      'thumbnails_bg_color' => 'ffffff',
                                                                      'thumbnails_bg_alpha' => 0,
                                                                      'thumbnails_border_size' => 0,
                                                                      'thumbnails_border_color' => 'e0e0e0',
                                                                      'thumbnails_spacing' => 10,
                                                                      'thumbnails_margin_top' => 10,
                                                                      'thumbnails_margin_right' => 0,
                                                                      'thumbnails_margin_bottom' => 10,
                                                                      'thumbnails_margin_left' => 10,
                                                                      'thumbnails_padding_top' => 0,
                                                                      'thumbnails_padding_right' => 0,
                                                                      'thumbnails_padding_bottom' => 0,
                                                                      'thumbnails_padding_left' => 15,
                                                                      'thumbnails_info' => 'label',
                                                                      'thumbnails_navigation_easing' => 'easeInOutCirc',
                                                                      'thumbnails_navigation_loop' => 'false',
                                                                      'thumbnails_navigation_mouse_enabled' => 'false',
                                                                      'thumbnails_navigation_scroll_enabled' => 'true',
                                                                      'thumbnails_scroll_position' => 'top/left',
                                                                      'thumbnails_scroll_size' => 5,
                                                                      'thumbnails_scroll_scrub_color' => '808080',
                                                                      'thumbnails_scroll_bar_color' => 'e0e0e0',
                                                                      'thumbnails_navigation_arrows_enabled' => 'false',
                                                                      'thumbnails_navigation_arrows_no_items_slide' => 1,
                                                                      'thumbnails_navigation_arrows_speed' => 600,
                                                                      'thumbnails_navigation_prev' => 'assets/gui/images/ThumbnailsPrev.png',
                                                                      'thumbnails_navigation_prev_hover' => 'assets/gui/images/ThumbnailsPrevHover.png',
                                                                      'thumbnails_navigation_prev_disabled' => 'assets/gui/images/ThumbnailsPrevDisabled.png',
                                                                      'thumbnails_navigation_next' => 'assets/gui/images/ThumbnailsNext.png',
                                                                      'thumbnails_navigation_next_hover' => 'assets/gui/images/ThumbnailsNextHover.png',
                                                                      'thumbnails_navigation_next_disabled' => 'assets/gui/images/ThumbnailsNextDisabled.png',
                                                                      'thumbnail_loader' => 'assets/gui/images/ThumbnailLoader.gif',
                                                                      'thumbnail_width' => 200,
                                                                      'thumbnail_height' => 100,
                                                                      'thumbnail_alpha' => 100,
                                                                      'thumbnail_alpha_hover' => 100,
                                                                      'thumbnail_bg_color' => 'f1f1f1',
                                                                      'thumbnail_bg_color_hover' => 'f1f1f1',
                                                                      'thumbnail_border_size' => 1,
                                                                      'thumbnail_border_color' => 'd0d0d0',
                                                                      'thumbnail_border_color_hover' => '303030',
                                                                      'thumbnail_padding_top' => 2,
                                                                      'thumbnail_padding_right' => 2,
                                                                      'thumbnail_padding_bottom' => 2,
                                                                      'thumbnail_padding_left' => 2,
                                                                      'lightbox_enabled' => 'true',
                                                                      'lightbox_display_time' => 600,
                                                                      'lightbox_window_color' => 'ffffff',
                                                                      'lightbox_window_alpha' => 80,
                                                                      'lightbox_loader' => 'assets/gui/images/LightboxLoader.gif',
                                                                      'lightbox_bg_color' => 'ffffff',
                                                                      'lightbox_bg_alpha' => 100,
                                                                      'lightbox_border_size' => 1,
                                                                      'lightbox_border_color' => 'e0e0e0',
                                                                      'lightbox_caption_text_color' => '999999',
                                                                      'lightbox_margin_top' => 30,
                                                                      'lightbox_margin_right' => 30,
                                                                      'lightbox_margin_bottom' => 30,
                                                                      'lightbox_margin_left' => 30,
                                                                      'lightbox_padding_top' => 10,
                                                                      'lightbox_padding_right' => 10,
                                                                      'lightbox_padding_bottom' => 10,
                                                                      'lightbox_padding_left' => 10,
                                                                      'lightbox_navigation_prev' => 'assets/gui/images/LightboxPrev.png',
                                                                      'lightbox_navigation_prev_hover' => 'assets/gui/images/LightboxPrevHover.png',
                                                                      'lightbox_navigation_next' => 'assets/gui/images/LightboxNext.png',
                                                                      'lightbox_navigation_next_hover' => 'assets/gui/images/LightboxNextHover.png',
                                                                      'lightbox_navigation_close' => 'assets/gui/images/LightboxClose.png',
                                                                      'lightbox_navigation_close_hover' => 'assets/gui/images/LightboxCloseHover.png',
                                                                      'lightbox_navigation_info_bg_color' => 'ffffff',
                                                                      'lightbox_navigation_info_text_color' => 'c0c0c0',
                                                                      'lightbox_navigation_display_time' => 600,
                                                                      'lightbox_navigation_touch_device_swipe_enabled' => 'true',
                                                                      'social_share_enabled' => 'false',
                                                                      'social_share_lightbox' => 'assets/gui/images/SocialShareLightbox.png',
                                                                      'tooltip_bg_color' => 'ffffff',
                                                                      'tooltip_stroke_color' => '000000',
                                                                      'tooltip_text_color' => '000000',
                                                                      'label_position' => 'bottom',
                                                                      'label_always_visible' => 'false',
                                                                      'label_under_height' => 50,
                                                                      'label_bg_color' => '000000',
                                                                      'label_bg_alpha' => 80,
                                                                      'label_text_color' => 'ffffff',
                                                                      'slideshow_enabled' => 'true',
                                                                      'slideshow_time' => 3000,
                                                                      'slideshow_loop' => 'true')));
                    
                    dbDelta($wpdb->insert(DOPTS_Settings_table, array('name' => 'Example 6',
                                                                      'scroller_id' => 0,
                                                                      'width' => 900,
                                                                      'height' => 263,
                                                                      'bg_color' => 'ffffff',
                                                                      'bg_alpha' => 0,
                                                                      'bg_border_size' => 0,
                                                                      'bg_border_color' => 'e0e0e0',
                                                                      'images_order' => 'random',
                                                                      'responsive_enabled' => 'true',
                                                                      'ultra_responsive_enabled' => 'true',
                                                                      'thumbnails_position' => 'horizontal',
                                                                      'thumbnails_bg_color' => 'ffffff',
                                                                      'thumbnails_bg_alpha' => 0,
                                                                      'thumbnails_border_size' => 0,
                                                                      'thumbnails_border_color' => 'e0e0e0',
                                                                      'thumbnails_spacing' => 5,
                                                                      'thumbnails_margin_top' => 0,
                                                                      'thumbnails_margin_right' => 0,
                                                                      'thumbnails_margin_bottom' => 0,
                                                                      'thumbnails_margin_left' => 0,
                                                                      'thumbnails_padding_top' => 0,
                                                                      'thumbnails_padding_right' => 0,
                                                                      'thumbnails_padding_bottom' => 0,
                                                                      'thumbnails_padding_left' => 0,
                                                                      'thumbnails_info' => 'label',
                                                                      'thumbnails_navigation_easing' => 'linear',
                                                                      'thumbnails_navigation_loop' => 'true',
                                                                      'thumbnails_navigation_mouse_enabled' => 'true',
                                                                      'thumbnails_navigation_scroll_enabled' => 'false',
                                                                      'thumbnails_scroll_position' => 'bottom/right',
                                                                      'thumbnails_scroll_size' => 5,
                                                                      'thumbnails_scroll_scrub_color' => '808080',
                                                                      'thumbnails_scroll_bar_color' => 'e0e0e0',
                                                                      'thumbnails_navigation_arrows_enabled' => 'false',
                                                                      'thumbnails_navigation_arrows_no_items_slide' => 1,
                                                                      'thumbnails_navigation_arrows_speed' => 600,
                                                                      'thumbnails_navigation_prev' => 'assets/gui/images/ThumbnailsPrev.png',
                                                                      'thumbnails_navigation_prev_hover' => 'assets/gui/images/ThumbnailsPrevHover.png',
                                                                      'thumbnails_navigation_prev_disabled' => 'assets/gui/images/ThumbnailsPrevDisabled.png',
                                                                      'thumbnails_navigation_next' => 'assets/gui/images/ThumbnailsNext.png',
                                                                      'thumbnails_navigation_next_hover' => 'assets/gui/images/ThumbnailsNextHover.png',
                                                                      'thumbnails_navigation_next_disabled' => 'assets/gui/images/ThumbnailsNextDisabled.png',
                                                                      'thumbnail_loader' => 'assets/gui/images/ThumbnailLoader.gif',
                                                                      'thumbnail_width' => 118,
                                                                      'thumbnail_height' => 200,
                                                                      'thumbnail_alpha' => 100,
                                                                      'thumbnail_alpha_hover' => 100,
                                                                      'thumbnail_bg_color' => 'f1f1f1',
                                                                      'thumbnail_bg_color_hover' => 'f1f1f1',
                                                                      'thumbnail_border_size' => 1,
                                                                      'thumbnail_border_color' => 'd0d0d0',
                                                                      'thumbnail_border_color_hover' => '303030',
                                                                      'thumbnail_padding_top' => 2,
                                                                      'thumbnail_padding_right' => 2,
                                                                      'thumbnail_padding_bottom' => 2,
                                                                      'thumbnail_padding_left' => 2,
                                                                      'lightbox_enabled' => 'false',
                                                                      'lightbox_display_time' => 600,
                                                                      'lightbox_window_color' => 'ffffff',
                                                                      'lightbox_window_alpha' => 80,
                                                                      'lightbox_loader' => 'assets/gui/images/LightboxLoader.gif',
                                                                      'lightbox_bg_color' => 'ffffff',
                                                                      'lightbox_bg_alpha' => 100,
                                                                      'lightbox_border_size' => 1,
                                                                      'lightbox_border_color' => 'e0e0e0',
                                                                      'lightbox_caption_text_color' => '999999',
                                                                      'lightbox_margin_top' => 30,
                                                                      'lightbox_margin_right' => 30,
                                                                      'lightbox_margin_bottom' => 30,
                                                                      'lightbox_margin_left' => 30,
                                                                      'lightbox_padding_top' => 10,
                                                                      'lightbox_padding_right' => 10,
                                                                      'lightbox_padding_bottom' => 10,
                                                                      'lightbox_padding_left' => 10,
                                                                      'lightbox_navigation_prev' => 'assets/gui/images/LightboxPrev.png',
                                                                      'lightbox_navigation_prev_hover' => 'assets/gui/images/LightboxPrevHover.png',
                                                                      'lightbox_navigation_next' => 'assets/gui/images/LightboxNext.png',
                                                                      'lightbox_navigation_next_hover' => 'assets/gui/images/LightboxNextHover.png',
                                                                      'lightbox_navigation_close' => 'assets/gui/images/LightboxClose.png',
                                                                      'lightbox_navigation_close_hover' => 'assets/gui/images/LightboxCloseHover.png',
                                                                      'lightbox_navigation_info_bg_color' => 'ffffff',
                                                                      'lightbox_navigation_info_text_color' => 'c0c0c0',
                                                                      'lightbox_navigation_display_time' => 600,
                                                                      'lightbox_navigation_touch_device_swipe_enabled' => 'true',
                                                                      'social_share_enabled' => 'false',
                                                                      'social_share_lightbox' => 'assets/gui/images/SocialShareLightbox.png',
                                                                      'tooltip_bg_color' => 'ffffff',
                                                                      'tooltip_stroke_color' => '000000',
                                                                      'tooltip_text_color' => '000000',
                                                                      'label_position' => 'under',
                                                                      'label_always_visible' => 'true',
                                                                      'label_under_height' => 55,
                                                                      'label_bg_color' => '000000',
                                                                      'label_bg_alpha' => 100,
                                                                      'label_text_color' => 'ffffff',
                                                                      'slideshow_enabled' => 'true',
                                                                      'slideshow_time' => 5000,
                                                                      'slideshow_loop' => 'true')));
                }
            }

            function initUploadFolders(){
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-loader');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-close');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-close-hover');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-next');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-next-hover');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-prev');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/lightbox-navigation-prev-hover');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/social-share-lightbox');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumb-loader');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-next');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-next-disabled');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-next-hover');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-prev');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-prev-disabled');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/settings/thumbnails-navigation-prev-hover');
                $this->verifyUploadFolder('../wp-content/plugins/dopts/uploads/thumbs');
            }
            
            function verifyUploadFolder($folder){
                if (!file_exists($folder)){
                    mkdir($folder, 0777);                
                }
                else{
                    if (substr(decoct(fileperms($folder)), 1) != '0777'){
                        if (@chmod($folder, 0777)){
                            // File permissions changed.
                        }
                        else{
                            // File permissions didn't changed.
                        }
                    }
                }
            }

            function printAdminPage(){// Prints out the admin page.
                $this->DOPTS_AddEditScrollers->scrollersList();
            }

// Scrollers
            function showScrollers(){// Show Scrollers List.
                global $wpdb;
                
                $scrollersHTML = array();
                array_push($scrollersHTML, '<ul>');

                $scrollers = $wpdb->get_results('SELECT * FROM '.DOPTS_Scrollers_table.' ORDER BY id DESC');
                
                if ($wpdb->num_rows != 0){
                    foreach ($scrollers as $scroller) {
                        array_push($scrollersHTML, '<li class="item" id="DOPTS-ID-'.$scroller->id.'"><span class="id">ID '.$scroller->id.':</span> <span class="name">'.$this->shortScrollerName($scroller->name, 25).'</span></li>');
                    }
                }
                else{
                    array_push($scrollersHTML, '<li class="no-data">'.DOPTS_NO_SCROLLERS.'</li>');
                }
                array_push($scrollersHTML, '</ul>');
                
                echo implode('', $scrollersHTML);
                
            	die();                
            }
        
            function addScroller(){// Add Scroller.
                global $wpdb;

                $wpdb->insert(DOPTS_Scrollers_table, array('name' => DOPTS_ADD_SCROLLER_NAME));
                $wpdb->insert(DOPTS_Settings_table, array('scroller_id' => $wpdb->insert_id));
                $this->showScrollers();

            	die();
            }

            function deleteScroller(){// Delete Scroller.
                global $wpdb;

                $wpdb->query('DELETE FROM '.DOPTS_Scrollers_table.' WHERE id="'.$_POST['id'].'"');
                $wpdb->query('DELETE FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$_POST['id'].'"');
                
                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$_POST['id'].'" ORDER BY position');
                foreach ($images as $image) {
                    $wpdb->query('DELETE FROM '.DOPTS_Images_table.' WHERE id="'.$image->id.'"');
                    unlink(DOPTS_Plugin_AbsPath.'uploads/'.$image->name);
                    unlink(DOPTS_Plugin_AbsPath.'uploads/thumbs/'.$image->name);
                }

                $scrollers = $wpdb->get_results('SELECT * FROM '.DOPTS_Scrollers_table.' ORDER BY id');
                echo $wpdb->num_rows;

            	die();
            }            

            function shortScrollerName($name, $size){// Return a short name for the scroller.
                $new_name = '';
                $pieces = str_split($name);
               
                if (count($pieces) <= $size){
                    $new_name = $name;
                }
                else{
                    for ($i=0; $i<$size-3; $i++){
                        $new_name .= $pieces[$i];
                    }
                    $new_name .= '...';
                }

                return $new_name;
            }

// Settings
            function showScrollerSettings(){// Show Scroller Info.
                global $wpdb;
                $result = array();
                $predefined_settings_list = array();
                
                $predefined_settings = $wpdb->get_results('SELECT * FROM '.DOPTS_Settings_table.' ORDER BY id');
                
                foreach ($predefined_settings as $ps){
                    array_push($predefined_settings_list, '<option value="'.$ps->id.'">'.($ps->scroller_id != 0 ? $ps->scroller_id.'. ':'').$ps->name.'</option>');
                }
                
                $result['predefined_settings'] = implode('', $predefined_settings_list);
                                
                $scroller = $wpdb->get_row('SELECT * FROM '.DOPTS_Scrollers_table.' WHERE id="'.$_POST['scroller_id'].'"');
    
                if ($_POST['settings_id'] != 0){
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE id="'.$_POST['settings_id'].'"');
                    
                }
                else{
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$_POST['scroller_id'].'"');
                }
                
                if ($_POST['scroller_id'] != 0){
                    $result['name'] = $scroller->name;
                }
                else{
                    $result['name'] = $settings->name;
                }
                
                $result['data_parse_method'] = $settings->data_parse_method;
                $result['width'] = $settings->width;
                $result['height'] = $settings->height;
                $result['bg_color'] = $settings->bg_color;
                $result['bg_alpha'] = $settings->bg_alpha;
                $result['bg_border_size'] = $settings->bg_border_size;
                $result['bg_border_color'] = $settings->bg_border_color;
                $result['images_order'] = $settings->images_order;
                $result['responsive_enabled'] = $settings->responsive_enabled;
                $result['ultra_responsive_enabled'] = $settings->ultra_responsive_enabled;
                $result['thumbnails_position'] = $settings->thumbnails_position;
                $result['thumbnails_bg_color'] = $settings->thumbnails_bg_color;
                $result['thumbnails_bg_alpha'] = $settings->thumbnails_bg_alpha;
                $result['thumbnails_border_size'] = $settings->thumbnails_border_size;
                $result['thumbnails_border_color'] = $settings->thumbnails_border_color;
                $result['thumbnails_spacing'] = $settings->thumbnails_spacing;
                $result['thumbnails_margin_top'] = $settings->thumbnails_margin_top;
                $result['thumbnails_margin_right'] = $settings->thumbnails_margin_right;
                $result['thumbnails_margin_bottom'] = $settings->thumbnails_margin_bottom;
                $result['thumbnails_margin_left'] = $settings->thumbnails_margin_left;
                $result['thumbnails_padding_top'] = $settings->thumbnails_padding_top;
                $result['thumbnails_padding_right'] = $settings->thumbnails_padding_right;
                $result['thumbnails_padding_bottom'] = $settings->thumbnails_padding_bottom;
                $result['thumbnails_padding_left'] = $settings->thumbnails_padding_left;
                $result['thumbnails_info'] = $settings->thumbnails_info;
                $result['thumbnails_navigation_easing'] = $settings->thumbnails_navigation_easing;
                $result['thumbnails_navigation_loop'] = $settings->thumbnails_navigation_loop;
                $result['thumbnails_navigation_mouse_enabled'] = $settings->thumbnails_navigation_mouse_enabled;
                $result['thumbnails_navigation_scroll_enabled'] = $settings->thumbnails_navigation_scroll_enabled;
                $result['thumbnails_scroll_position'] = $settings->thumbnails_scroll_position;
                $result['thumbnails_scroll_size'] = $settings->thumbnails_scroll_size;
                $result['thumbnails_scroll_scrub_color'] = $settings->thumbnails_scroll_scrub_color;
                $result['thumbnails_scroll_bar_color'] = $settings->thumbnails_scroll_bar_color;
                $result['thumbnails_navigation_arrows_enabled'] = $settings->thumbnails_navigation_arrows_enabled;
                $result['thumbnails_navigation_arrows_no_items_slide'] = $settings->thumbnails_navigation_arrows_no_items_slide;
                $result['thumbnails_navigation_arrows_speed'] = $settings->thumbnails_navigation_arrows_speed;
                $result['thumbnails_navigation_prev'] = $settings->thumbnails_navigation_prev;
                $result['thumbnails_navigation_prev_hover'] = $settings->thumbnails_navigation_prev_hover;
                $result['thumbnails_navigation_prev_disabled'] = $settings->thumbnails_navigation_prev_disabled;
                $result['thumbnails_navigation_next'] = $settings->thumbnails_navigation_next;
                $result['thumbnails_navigation_next_hover'] = $settings->thumbnails_navigation_next_hover;
                $result['thumbnails_navigation_next_disabled'] = $settings->thumbnails_navigation_next_disabled;
                $result['thumbnail_loader'] = $settings->thumbnail_loader;
                $result['thumbnail_width'] = $settings->thumbnail_width;
                $result['thumbnail_height'] = $settings->thumbnail_height;
                $result['thumbnail_alpha'] = $settings->thumbnail_alpha;
                $result['thumbnail_alpha_hover'] = $settings->thumbnail_alpha_hover;
                $result['thumbnail_bg_color'] = $settings->thumbnail_bg_color;
                $result['thumbnail_bg_color_hover'] = $settings->thumbnail_bg_color_hover;
                $result['thumbnail_border_size'] = $settings->thumbnail_border_size;
                $result['thumbnail_border_color'] = $settings->thumbnail_border_color;
                $result['thumbnail_border_color_hover'] = $settings->thumbnail_border_color_hover;
                $result['thumbnail_padding_top'] = $settings->thumbnail_padding_top;
                $result['thumbnail_padding_right'] = $settings->thumbnail_padding_right;
                $result['thumbnail_padding_bottom'] = $settings->thumbnail_padding_bottom;
                $result['thumbnail_padding_left'] = $settings->thumbnail_padding_left;
                $result['lightbox_enabled'] = $settings->lightbox_enabled;
                $result['lightbox_display_time'] = $settings->lightbox_display_time;
                $result['lightbox_window_color'] = $settings->lightbox_window_color;
                $result['lightbox_window_alpha'] = $settings->lightbox_window_alpha;
                $result['lightbox_loader'] = $settings->lightbox_loader;
                $result['lightbox_bg_color'] = $settings->lightbox_bg_color;
                $result['lightbox_bg_alpha'] = $settings->lightbox_bg_alpha;
                $result['lightbox_border_size'] = $settings->lightbox_border_size;
                $result['lightbox_border_color'] = $settings->lightbox_border_color;
                $result['lightbox_caption_text_color'] = $settings->lightbox_caption_text_color;    
                $result['lightbox_margin_top'] = $settings->lightbox_margin_top;
                $result['lightbox_margin_right'] = $settings->lightbox_margin_right;
                $result['lightbox_margin_bottom'] = $settings->lightbox_margin_bottom;
                $result['lightbox_margin_left'] = $settings->lightbox_margin_left;
                $result['lightbox_padding_top'] = $settings->lightbox_padding_top;
                $result['lightbox_padding_right'] = $settings->lightbox_padding_right;
                $result['lightbox_padding_bottom'] = $settings->lightbox_padding_bottom;
                $result['lightbox_padding_left'] = $settings->lightbox_padding_left;
                $result['lightbox_navigation_prev'] = $settings->lightbox_navigation_prev;
                $result['lightbox_navigation_prev_hover'] = $settings->lightbox_navigation_prev_hover;
                $result['lightbox_navigation_next'] = $settings->lightbox_navigation_next;
                $result['lightbox_navigation_next_hover'] = $settings->lightbox_navigation_next_hover;
                $result['lightbox_navigation_close'] = $settings->lightbox_navigation_close;
                $result['lightbox_navigation_close_hover'] = $settings->lightbox_navigation_close_hover;
                $result['lightbox_navigation_info_bg_color'] = $settings->lightbox_navigation_info_bg_color;
                $result['lightbox_navigation_info_text_color'] = $settings->lightbox_navigation_info_text_color;            
                $result['lightbox_navigation_display_time'] = $settings->lightbox_navigation_display_time;
                $result['lightbox_navigation_touch_device_swipe_enabled'] = $settings->lightbox_navigation_touch_device_swipe_enabled;
                $result['social_share_enabled'] = $settings->social_share_enabled;
                $result['social_share_lightbox'] = $settings->social_share_lightbox;
                $result['tooltip_bg_color'] = $settings->tooltip_bg_color;
                $result['tooltip_stroke_color'] = $settings->tooltip_stroke_color;
                $result['tooltip_text_color'] = $settings->tooltip_text_color;
                $result['label_position'] = $settings->label_position;
                $result['label_always_visible'] = $settings->label_always_visible;
                $result['label_under_height'] = $settings->label_under_height;
                $result['label_bg_color'] = $settings->label_bg_color;
                $result['label_bg_alpha'] = $settings->label_bg_alpha;
                $result['label_text_color'] = $settings->label_text_color;
                $result['slideshow_enabled'] = $settings->slideshow_enabled;
                $result['slideshow_time'] = $settings->slideshow_time;
                $result['slideshow_loop'] = $settings->slideshow_loop;

                echo json_encode($result);
            	die();
            }

            function editScrollerSettings(){// Edit Scroller Settings.
                global $wpdb;
                
                $settings = array('name' => $_POST['name'],
                                  'data_parse_method' => $_POST['data_parse_method'],
                                  'width' => $_POST['width'],
                                  'height' => $_POST['height'],
                                  'bg_color' => $_POST['bg_color'],
                                  'bg_alpha' => $_POST['bg_alpha'],
                                  'bg_border_size' => $_POST['bg_border_size'],
                                  'bg_border_color' => $_POST['bg_border_color'],
                                  'images_order' => $_POST['images_order'],
                                  'responsive_enabled' => $_POST['responsive_enabled'],
                                  'ultra_responsive_enabled' => $_POST['ultra_responsive_enabled'],
                                  'thumbnails_position' => $_POST['thumbnails_position'],
                                  'thumbnails_bg_color' => $_POST['thumbnails_bg_color'],
                                  'thumbnails_bg_alpha' => $_POST['thumbnails_bg_alpha'],
                                  'thumbnails_border_size' => $_POST['thumbnails_border_size'],
                                  'thumbnails_border_color' => $_POST['thumbnails_border_color'],
                                  'thumbnails_spacing' => $_POST['thumbnails_spacing'],
                                  'thumbnails_margin_top' => $_POST['thumbnails_margin_top'],
                                  'thumbnails_margin_right' => $_POST['thumbnails_margin_right'],
                                  'thumbnails_margin_bottom' => $_POST['thumbnails_margin_bottom'],
                                  'thumbnails_margin_left' => $_POST['thumbnails_margin_left'],
                                  'thumbnails_padding_top' => $_POST['thumbnails_padding_top'],
                                  'thumbnails_padding_right' => $_POST['thumbnails_padding_right'],
                                  'thumbnails_padding_bottom' => $_POST['thumbnails_padding_bottom'],
                                  'thumbnails_padding_left' => $_POST['thumbnails_padding_left'],
                                  'thumbnails_info' => $_POST['thumbnails_info'],
                                  'thumbnails_navigation_easing' => $_POST['thumbnails_navigation_easing'],
                                  'thumbnails_navigation_loop' => $_POST['thumbnails_navigation_loop'],
                                  'thumbnails_navigation_mouse_enabled' => $_POST['thumbnails_navigation_mouse_enabled'],
                                  'thumbnails_navigation_scroll_enabled' => $_POST['thumbnails_navigation_scroll_enabled'],
                                  'thumbnails_scroll_position' => $_POST['thumbnails_scroll_position'],
                                  'thumbnails_scroll_size' => $_POST['thumbnails_scroll_size'],
                                  'thumbnails_scroll_scrub_color' => $_POST['thumbnails_scroll_scrub_color'],
                                  'thumbnails_scroll_bar_color' => $_POST['thumbnails_scroll_bar_color'],
                                  'thumbnails_navigation_arrows_enabled' => $_POST['thumbnails_navigation_arrows_enabled'],
                                  'thumbnails_navigation_arrows_no_items_slide' => $_POST['thumbnails_navigation_arrows_no_items_slide'],
                                  'thumbnails_navigation_arrows_speed' => $_POST['thumbnails_navigation_arrows_speed'],
                                  'thumbnail_width' => $_POST['thumbnail_width'],
                                  'thumbnail_height' => $_POST['thumbnail_height'],
                                  'thumbnail_alpha' => $_POST['thumbnail_alpha'],
                                  'thumbnail_alpha_hover' => $_POST['thumbnail_alpha_hover'],
                                  'thumbnail_bg_color' => $_POST['thumbnail_bg_color'],
                                  'thumbnail_bg_color_hover' => $_POST['thumbnail_bg_color_hover'],
                                  'thumbnail_border_size' => $_POST['thumbnail_border_size'],
                                  'thumbnail_border_color' => $_POST['thumbnail_border_color'],
                                  'thumbnail_border_color_hover' => $_POST['thumbnail_border_color_hover'],
                                  'thumbnail_padding_top' => $_POST['thumbnail_padding_top'],
                                  'thumbnail_padding_right' => $_POST['thumbnail_padding_right'],
                                  'thumbnail_padding_bottom' => $_POST['thumbnail_padding_bottom'],
                                  'thumbnail_padding_left' => $_POST['thumbnail_padding_left'],
                                  'lightbox_enabled' => $_POST['lightbox_enabled'],
                                  'lightbox_display_time' => $_POST['lightbox_display_time'],
                                  'lightbox_window_color' => $_POST['lightbox_window_color'],
                                  'lightbox_window_alpha' => $_POST['lightbox_window_alpha'],
                                  'lightbox_bg_color' => $_POST['lightbox_bg_color'],
                                  'lightbox_bg_alpha' => $_POST['lightbox_bg_alpha'],
                                  'lightbox_border_size' => $_POST['lightbox_border_size'],
                                  'lightbox_border_color' => $_POST['lightbox_border_color'],
                                  'lightbox_caption_text_color' => $_POST['lightbox_caption_text_color'],
                                  'lightbox_margin_top' => $_POST['lightbox_margin_top'],
                                  'lightbox_margin_right' => $_POST['lightbox_margin_right'],
                                  'lightbox_margin_bottom' => $_POST['lightbox_margin_bottom'],
                                  'lightbox_margin_left' => $_POST['lightbox_margin_left'],
                                  'lightbox_padding_top' => $_POST['lightbox_padding_top'],
                                  'lightbox_padding_right' => $_POST['lightbox_padding_right'],
                                  'lightbox_padding_bottom' => $_POST['lightbox_padding_bottom'],
                                  'lightbox_padding_left' => $_POST['lightbox_padding_left'],
                                  'lightbox_navigation_info_bg_color' => $_POST['lightbox_navigation_info_bg_color'],
                                  'lightbox_navigation_info_text_color' => $_POST['lightbox_navigation_info_text_color'],
                                  'lightbox_navigation_display_time' => $_POST['lightbox_navigation_display_time'],
                                  'lightbox_navigation_touch_device_swipe_enabled' => $_POST['lightbox_navigation_touch_device_swipe_enabled'],
                                  'social_share_enabled' => $_POST['social_share_enabled'],
                                  'tooltip_bg_color' => $_POST['tooltip_bg_color'],
                                  'tooltip_stroke_color' => $_POST['tooltip_stroke_color'],
                                  'tooltip_text_color' => $_POST['tooltip_text_color'],
                                  'label_position' => $_POST['label_position'],
                                  'label_always_visible' => $_POST['label_always_visible'],
                                  'label_under_height' => $_POST['label_under_height'],
                                  'label_bg_color' => $_POST['label_bg_color'],
                                  'label_bg_alpha' => $_POST['label_bg_alpha'],
                                  'label_text_color' => $_POST['label_text_color'],
                                  'slideshow_enabled' => $_POST['slideshow_enabled'],
                                  'slideshow_time' => $_POST['slideshow_time'],
                                  'slideshow_loop' => $_POST['slideshow_loop']);
                
                if (isset($_POST['thumbnail_loader'])){
                    $settings['thumbnails_navigation_prev'] = $_POST['thumbnails_navigation_prev'];
                    $settings['thumbnails_navigation_prev_hover'] = $_POST['thumbnails_navigation_prev_hover'];
                    $settings['thumbnails_navigation_prev_disabled'] = $_POST['thumbnails_navigation_prev_disabled'];
                    $settings['thumbnails_navigation_next'] = $_POST['thumbnails_navigation_next'];
                    $settings['thumbnails_navigation_next_hover'] = $_POST['thumbnails_navigation_next_hover'];
                    $settings['thumbnails_navigation_next_disabled'] = $_POST['thumbnails_navigation_next_disabled'];
                    $settings['thumbnail_loader'] = $_POST['thumbnail_loader'];                    
                    $settings['lightbox_loader'] = $_POST['lightbox_loader'];
                    $settings['lightbox_navigation_prev'] = $_POST['lightbox_navigation_prev'];
                    $settings['lightbox_navigation_prev_hover'] = $_POST['lightbox_navigation_prev_hover'];
                    $settings['lightbox_navigation_next'] = $_POST['lightbox_navigation_next'];
                    $settings['lightbox_navigation_next_hover'] = $_POST['lightbox_navigation_next_hover'];
                    $settings['lightbox_navigation_close'] = $_POST['lightbox_navigation_close'];
                    $settings['lightbox_navigation_close_hover'] = $_POST['lightbox_navigation_close_hover'];
                    $settings['social_share_lightbox'] = $_POST['social_share_lightbox'];
                }
                
                $wpdb->update(DOPTS_Scrollers_table, array('name' => $_POST['name']), array('id' => $_POST['scroller_id']));
                
                if ($_POST['scroller_id'] == 0){
                    $wpdb->update(DOPTS_Settings_table, $settings, array(id => 1));
                }
                else{
                    $wpdb->update(DOPTS_Settings_table, $settings, array('scroller_id' => $_POST['scroller_id']));
                }
                
                echo '';
                
            	die();
            }
            
            function updateSettingsImage(){// Update Settings Images via AJAX.
                if (isset($_POST['scroller_id'])){
                    global $wpdb;
                    
                    switch ($_POST['item']){
                        case 'thumbnails_navigation_prev':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_prev' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnails_navigation_prev_hover':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_prev_hover' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnails_navigation_prev_disabled':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_prev_disabled' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnails_navigation_next':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_next' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnails_navigation_next_hover':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_next_hover' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnails_navigation_next_disabled':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnails_navigation_next_disabled' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'thumbnail_loader':
                            $wpdb->update(DOPTS_Settings_table, array('thumbnail_loader' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_loader':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_loader' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_prev':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_prev' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_prev_hover':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_prev_hover' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_next':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_next' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_next_hover':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_next_hover' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_close':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_close' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'lightbox_navigation_close_hover':
                            $wpdb->update(DOPTS_Settings_table, array('lightbox_navigation_close_hover' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                        case 'social_share_lightbox':
                            $wpdb->update(DOPTS_Settings_table, array('social_share_lightbox' => $_POST['path']), array(scroller_id => $_POST['scroller_id']));
                            break;
                    }
                    
                    echo '';
                }
            }

// Images            
            function showImages(){// Show Images List.
                if (isset($_POST['scroller_id'])){
                    global $wpdb;
                    $imagesHTML = array();
                    $scroller_id = $_POST['scroller_id'];
                    array_push($imagesHTML, '<ul>');

                    $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$_POST['scroller_id'].'" ORDER BY position');
                    if ($wpdb->num_rows != 0){
                        foreach ($images as $image) {
                            if ($image->enabled == 'true'){
                                array_push($imagesHTML, '<li class="item-image" id="DOPTS-image-ID-'.$image->id.'"><img src="'.DOPTS_Plugin_URL.'uploads/thumbs/'.$image->name.'" alt="" /></li>');
                            }
                            else{
                                array_push($imagesHTML, '<li class="item-image item-image-disabled" id="DOPTS-image-ID-'.$image->id.'"><img src="'.DOPTS_Plugin_URL.'uploads/thumbs/'.$image->name.'" alt="" /></li>');
                            }
                        }
                    }
                    else{
                        array_push($imagesHTML, '<li class="no-data">'.DOPTS_NO_IMAGES.'</li>');
                    }

                    array_push($imagesHTML, '</ul>');
                    echo implode('', $imagesHTML);

                    die();
                }
            }

            function addImageWP(){// Add Images from WP Media.
                global $wpdb;
                
                $urlPieces = explode('wp-content/', $_POST['image_url']);
                $imagePieces = explode('/', $urlPieces[1]);
                
                $targetPath = DOPTS_Plugin_AbsPath.'uploads';
                $ext = substr($imagePieces[count($imagePieces)-1], strrpos($imagePieces[count($imagePieces)-1], '.') + 1);

                $newName = $this->generateName();
                
                // File and new size
                $filename = str_replace('//','/',$targetPath).'/'.$newName.'.'.$ext;
                copy(str_replace('\\', '/', ABSPATH).'wp-content/'.$urlPieces[1], $filename);
                
                // CREATE THUMBNAIL
               
                // Get new sizes
                list($width, $height) = getimagesize($filename);
                $newheight = 300;
                $newwidth = $width*$newheight/$height;

                if ($newwidth < 300){
                    $newwidth = 300;
                    $newheight = $height*$newwidth/$width;
                }

                // Load
                $thumb = ImageCreateTrueColor($newwidth, $newheight);
                
                if ($ext == 'png'){
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);  
                }
                
                if ($ext == 'png'){
                    $source = imagecreatefrompng($filename);
                    imagealphablending($source, true);
                }
                else{
                    $source = imagecreatefromjpeg($filename);
                }

                // Resize
                imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                // Output
                if ($ext == 'png'){
                    $source = imagepng($thumb, $targetPath.'/thumbs/'.$newName.'.'.$ext);
                }
                else{
                    $source = imagejpeg($thumb, $targetPath.'/thumbs/'.$newName.'.'.$ext, 100);
                }
                
                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$_POST['scroller_id'].'" ORDER BY position');
                $wpdb->insert(DOPTS_Images_table, array('scroller_id' => $_POST['scroller_id'],
                                                        'name' => $newName.'.'.$ext,
                                                        'caption' => '',
                                                        'media' => '',
                                                        'lightbox_media' => '',
                                                        'position' => $wpdb->num_rows+1));
                
                echo $wpdb->insert_id.';;;'.$newName.'.'.$ext;
                
            	die();
            }
            
            function addImageFTP(){// Add Images from FTP.
                global $wpdb;
                
                $folder = DOPTS_Plugin_AbsPath.'ftp-uploads';
                $images = array();
                $folderData = opendir($folder);
   
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' && $file != '..'){
                        array_push($images, "$file");
                    }
                }
                
                closedir($folderData);

                $result = array();
                $targetPath = DOPTS_Plugin_AbsPath.'uploads';
                sort($images);
                
                foreach ($images as $image):
                    $ext = substr($image, strrpos($image, '.')+1);
                    $newName = $this->generateName();

                    // File and new size
                    $filename = str_replace('//','/',$targetPath).'/'.$newName.'.'.$ext;

                    // Get new sizes
                    copy(DOPTS_Plugin_AbsPath.'ftp-uploads/'.$image, $filename);

                    // CREATE THUMBNAIL

                    // Get new sizes
                    list($width, $height) = getimagesize($filename);
                    $newheight = 300;
                    $newwidth = $width*$newheight/$height;

                    if ($newwidth < 300){
                        $newwidth = 300;
                        $newheight = $height*$newwidth/$width;
                    }

                    // Load
                    $thumb = ImageCreateTrueColor($newwidth, $newheight);
                    
                    if ($ext == 'png'){
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);  
                    }
                    
                    if ($ext == 'png'){
                        $source = imagecreatefrompng($filename);
                        imagealphablending($source, true);
                    }
                    else{
                        $source = imagecreatefromjpeg($filename);
                    }

                    // Resize
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                    // Output
                    if ($ext == 'png'){
                        $source = imagepng($thumb, $targetPath.'/thumbs/'.$newName.'.'.$ext);
                    }
                    else{
                        $source = imagejpeg($thumb, $targetPath.'/thumbs/'.$newName.'.'.$ext, 100);
                    }

                    $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$_POST['scroller_id'].'" ORDER BY position');
                    $wpdb->insert(DOPTS_Images_table, array('scroller_id' => $_POST['scroller_id'],
                                                            'name' => $newName.'.'.$ext,
                                                            'caption' => '',
                                                            'media' => '',
                                                            'lightbox_media' => '',
                                                            'position' => $wpdb->num_rows+1));

                    array_push($result, $wpdb->insert_id.';;;'.$newName.'.'.$ext);
                endforeach;
                
                echo implode(';;;;;', $result);
                
            	die();
            }
            
            function addImage(){// Add Image via AJAX.
                global $wpdb;                
                
                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$_POST['scroller_id'].'" ORDER BY position');
                $wpdb->insert(DOPTS_Images_table, array('scroller_id' => $_POST['scroller_id'],
                                                        'name' => $_POST['name'],
                                                        'caption' => '',
                                                        'media' => '',
                                                        'lightbox_media' => '',
                                                        'position' => $wpdb->num_rows+1));
                echo $wpdb->insert_id;
                
            	die();
            }

            function editImages(){// Edit Images.
                global $wpdb;
                
                $images_action = $_POST['images_action'];
                $images_list = $_POST['images'];
                
                switch ($images_action){
                    case 'delete':
                        for ($i=0; $i<count($images_list); $i++){
                            $image = $wpdb->get_row('SELECT * FROM '.DOPTS_Images_table.' WHERE id="'.$images_list[$i].'"');
                            $position = $image->position;

                            $wpdb->query('DELETE FROM '.DOPTS_Images_table.' WHERE id="'.$images_list[$i].'"');
                            unlink(DOPTS_Plugin_AbsPath.'uploads/'.$image->name);
                            unlink(DOPTS_Plugin_AbsPath.'uploads/thumbs/'.$image->name);

                            $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$image->scroller_id.'" ORDER BY position');
                            $num_rows = $wpdb->num_rows;
                            
                            foreach ($images as $image) {
                                if($image->position > $position){
                                    $newPosition = $image->position-1;
                                    $wpdb->update(DOPTG_Images_table, array('position' => $newPosition), array(id => $image->id));
                                }
                            }
                        }
                        break;
                    case 'enable':
                        for ($i=0; $i<count($images_list); $i++){
                            $wpdb->update(DOPTS_Images_table, array('enabled' => 'true'), array('id' => $images_list[$i]));
                        }
                        break;
                    case 'disable':
                        for ($i=0; $i<count($images_list); $i++){
                            $wpdb->update(DOPTS_Images_table, array('enabled' => 'false'), array('id' => $images_list[$i]));
                        }
                        break;
                }
                
                die();
            }

            function sortImages(){// Sort Images via AJAX.
                global $wpdb;

                $order = array();
                $order = explode(',', $_POST['data']);

                for ($i=0; $i<count($order)-1; $i++){
                    $newPos = $i+1;
                    $wpdb->update(DOPTS_Images_table, array('position' => $newPos), array(id => $order[$i]));
                }

                echo $_POST['data'];

            	die();
            }

            function showImage(){// Show Image details.
                global $wpdb;
                $result = array();

                $image = $wpdb->get_row('SELECT * FROM '.DOPTS_Images_table.' WHERE id="'.$_POST['image_id'].'"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPTS_Settings_table.' WHERE scroller_id="'.$image->scroller_id.'"');
                
                $result['id'] = $image->id;
                $result['name'] = $image->name;
                $result['thumbnail_width'] = $settings->thumbnail_width;
                $result['thumbnail_height'] = $settings->thumbnail_height;
                $result['title'] = stripslashes($image->title);
                $result['caption'] = stripslashes($image->caption);
                $result['media'] = stripslashes($image->media);
                $result['lightbox_media'] = stripslashes($image->lightbox_media);
                $result['link'] = stripslashes($image->link);
                $result['target'] = stripslashes($image->target);
                $result['enabled'] = $image->enabled;
                
                echo json_encode($result);
            	die();
            }

            function editImage(){// Edit Image.
                global $wpdb;

                $wpdb->update(DOPTS_Images_table, array('title' => $_POST['image_title'], 'caption' => $_POST['image_caption'], 'media' => $_POST['image_media'], 'lightbox_media' => $_POST['image_lightbox_media'], 'link' => $_POST['image_link'], 'target' => $_POST['image_link_target'], 'enabled' => $_POST['image_enabled']), array('id' => $_POST['image_id']));

                if ($_POST['crop_width'] > 0){
                    list($width, $height) = getimagesize(DOPTS_Plugin_AbsPath.'uploads/'.$_POST['image_name']);
                    $pr = $width/$_POST['image_width'];
                    $ext = substr($_POST['image_name'], strrpos($_POST['image_name'], '.') + 1);

                    $src = DOPTS_Plugin_AbsPath.'uploads/'.$_POST['image_name'];

                    if ($ext == 'png'){
                        $img_r = imagecreatefrompng($src);
                        imagealphablending($img_r, true);
                    }
                    else $img_r = imagecreatefromjpeg($src);

                    $thumb = ImageCreateTrueColor($_POST['thumb_width'], $_POST['thumb_height']);
                    if ($ext == 'png'){
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);  
                    }

                    imagecopyresampled($thumb, $img_r , 0, 0, $_POST['crop_x']*$pr, $_POST['crop_y']*$pr, $_POST['thumb_width'], $_POST['thumb_height'], $_POST['crop_width']*$pr, $_POST['crop_height']*$pr);

                    if ($ext == 'png') $source = imagepng($thumb, DOPTS_Plugin_AbsPath.'uploads/thumbs/'.$_POST['image_name']);
                    else $source = imagejpeg($thumb, DOPTS_Plugin_AbsPath.'uploads/thumbs/'.$_POST['image_name'], 100);

                    echo DOPTS_Plugin_URL.'uploads/thumbs/'.$_POST['image_name'];
                }
                else{
                    echo '';
                }

            	die();
            }

            function deleteImage(){// Delete Image.
                global $wpdb;

                $image = $wpdb->get_row('SELECT * FROM '.DOPTS_Images_table.' WHERE id="'.$_POST['image_id'].'"');
                $position = $image->position;

                $wpdb->query('DELETE FROM '.DOPTS_Images_table.' WHERE id="'.$_POST['image_id'].'"');
                unlink(DOPTS_Plugin_AbsPath.'uploads/'.$image->name);
                unlink(DOPTS_Plugin_AbsPath.'uploads/thumbs/'.$image->name);

                $images = $wpdb->get_results('SELECT * FROM '.DOPTS_Images_table.' WHERE scroller_id="'.$image->scroller_id.'" ORDER BY position');
                $num_rows = $wpdb->num_rows;
                
                foreach ($images as $image) {
                    if($image->position > $position){
                        $newPosition = $image->position-1;
                        $wpdb->update(DOPTS_Images_table, array('position' => $newPosition), array(id => $image->id));
                    }
                }
                
                echo $num_rows;

            	die();
            }
        
// Functions            
            private function generateName(){
                $len = 64;
                $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
                $max = strlen($base)-1;
                $newName = '';
                mt_srand((double)microtime()*1000000);
                
                while (strlen($newName)<$len+1){
                    $newName .= $base{mt_rand(0,$max)};
                }
                
                return $newName;
            }  
            
// Editor Changes
            function addDOPTStoTinyMCE(){// Add scroller button to TinyMCE Editor.
                add_filter('tiny_mce_version', array (&$this, 'changeTinyMCEVersion'));
                add_action('init', array (&$this, 'addDOPTSButtons'));
            }

            function tinyMCEScrollers(){// Send data to editor button.
                global $wpdb;
                $tinyMCE_data = '';
                $scrollersList = array();

                $scrollers = $wpdb->get_results('SELECT * FROM '.DOPTS_Scrollers_table.' ORDER BY id');
                foreach ($scrollers as $scroller) {
                    array_push($scrollersList, $scroller->id.';;'.$scroller->name);
                }
                $tinyMCE_data = DOPTS_TINYMCE_ADD.';;;;;'.implode(';;;', $scrollersList);
                echo '<script type="text/JavaScript">'.
                     '    var DOPTS_tinyMCE_data = "'.$tinyMCE_data.'",'.
                     '        WP_version          = "'.get_bloginfo("version").'";'.  
                     '</script>';
            }

            function addDOPTSButtons(){// Add Button.
                if (!current_user_can('edit_posts') && !current_user_can('edit_pages')){
                    return;
                }

                if ( get_user_option('rich_editing') == 'true'){
                    add_action('admin_head', array (&$this, 'tinyMCEScrollers'));
                    add_filter('mce_external_plugins', array (&$this, 'addDOPTSTinyMCEPlugin'), 5);
                    add_filter('mce_buttons', array (&$this, 'registerDOPTSTinyMCEPlugin'), 5);
                }
            }

            function registerDOPTSTinyMCEPlugin($buttons){// Register editor buttons.
                array_push($buttons, '', 'DOPTS');
                return $buttons;
            }

            function addDOPTSTinyMCEPlugin($plugin_array){// Add plugin to TinyMCE editor.
                $plugin_array['DOPTS'] =  DOPTS_Plugin_URL.'assets/js/tinymce-plugin.js';
                return $plugin_array;
            }

            function changeTinyMCEVersion($version){// TinyMCE version.
                $version = $version+100;
                return $version;
            }
        }
    }
?>