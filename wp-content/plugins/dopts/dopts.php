<?php
/*
Plugin Name: Thumbnail Scroller (WordPress Plugin)
Version: 1.6
Plugin URI: http://codecanyon.net/item/thumbnail-scroller-wordpress-plugin/2068683?ref=DOTonPAPER
Description: This Plugin will help you to easily add a thumbnail scroller to your WordPress website or blog. The scroller is completely customizable, resizable and is compatible with all browsers and devices (iPhone, iPad and Android smartphones). You will be able to insert it in any page or post you want with an inbuilt short code generator.<br /><br />If you like this plugin, feel free to rate it five stars at <a href="http://codecanyon.net/item/wallgrid-gallery-wordpress-plugin/270895?ref=DOTonPAPER" target="_blank">CodeCanyon</a> in your downloads section. If you encounter any problems please do not give a low rating but <a href="http://envato-support.dotonpaper.net">visit</a> our <a href="http://envato-support.dotonpaper.net">Support Forums</a> first so we can help you.
Author: Dot on Paper
Author URI: http://www.dotonpaper.net

Change log:

        1.6 (2012-10-01)

                * Admin interface changes.
                * CSS fixes.
                * Delete/Enable/Disable multiple images.
                * Help tooltip updated.
                * Small bugs fixed.
                * Translation structure has changed.

        1.5 (2012-05-05)

                * 2 responsive levels added.
                * AddThis fixed.
                * Responsive Media bug fix.
                * SEO fixes.

        1.4 (2013-03-30)

                * Database is deleted when you delete the plugin.
                * Display a list with default settings & all settings you created.
                * You have the option to add the label under the thumbnail.
                * Scroller resize on hidden elements bug fix.
                * Slow admin bug fix.
                * Small Admin changes.
                * Social Share added.
                * Update notification added.
                * Uploading Settings Images on MU bug fix.
 
        1.3 (2012-12-10)

                * Lightbox display bug on Chrome is fixed.
                * Remove lightbox margins on mobile devices. 
                * Small bugs fixes.
         
        1.2 (2012-10-11)

                * Data can be parsed in the scroller using HTML.
                * Small bugs fixes.
                * Upload methods script changes.
 
        1.1 (2012-05-15)

                * Loop added.
                * Minor bugs fixes. 
                * Mouse navigation speed change added.
                * Responsive layout added.
  
        1.0 (2012-04-01)
	
		* Initial release.
		
Installation: Upload the folder dopts from the zip file to "wp-content/plugins/" and activate the plugin in your admin panel or upload dopts.zip in the "Add new" section.
*/

    include_once "views/lang.php";
    include_once "views/templates.php";
    include_once "dopts-update.php";
    include_once "dopts-frontend.php";
    include_once "dopts-backend.php";
    include_once "dopts-widget.php";
    
// Paths
    
    if (!defined('DOPTS_Plugin_URL')){
        define('DOPTS_Plugin_URL', plugin_dir_url(__FILE__));
    }
    if (!defined('DOPTS_Plugin_AbsPath')){
        define('DOPTS_Plugin_AbsPath', str_replace('\\', '/', plugin_dir_path(__FILE__)));
    }

    if (is_admin()){// If admin is loged in admin init administration panel.
        if (class_exists("DOPThumbnailScrollerBackEnd")){
            $DOPTS_pluginSeries = new DOPThumbnailScrollerBackEnd();
        }

        if (!function_exists("DOPThumbnailScrollerBackEnd_ap")){// Initialize the admin panel.
            function DOPThumbnailScrollerBackEnd_ap(){
                global $DOPTS_pluginSeries;

                if (!isset($DOPTS_pluginSeries)){
                    return;
                }
                if (function_exists('add_options_page')){
                    add_menu_page(DOPTS_TITLE, DOPTS_TITLE, 'edit_posts', 'dopts', array(&$DOPTS_pluginSeries, 'printAdminPage'), 'div');
                }
            }
        }

        if (isset($DOPTS_pluginSeries)){// Init AJAX functions.
            add_action('admin_menu', 'DOPThumbnailScrollerBackEnd_ap');
            add_action('wp_ajax_dopts_show_scrollers', array(&$DOPTS_pluginSeries, 'showScrollers'));
            add_action('wp_ajax_dopts_add_scroller', array(&$DOPTS_pluginSeries, 'addScroller'));
            add_action('wp_ajax_dopts_delete_scroller', array(&$DOPTS_pluginSeries, 'deleteScroller'));
            add_action('wp_ajax_dopts_show_scroller_settings', array(&$DOPTS_pluginSeries, 'showScrollerSettings'));
            add_action('wp_ajax_dopts_edit_scroller_settings', array(&$DOPTS_pluginSeries, 'editScrollerSettings'));
            add_action('wp_ajax_dopts_update_settings_image', array(&$DOPTS_pluginSeries, 'updateSettingsImage'));
            add_action('wp_ajax_dopts_show_images', array(&$DOPTS_pluginSeries, 'showImages'));
            add_action('wp_ajax_dopts_add_image_wp', array(&$DOPTS_pluginSeries, 'addImageWP'));
            add_action('wp_ajax_dopts_add_image_ftp', array(&$DOPTS_pluginSeries, 'addImageFTP'));
            add_action('wp_ajax_dopts_add_image', array(&$DOPTS_pluginSeries, 'addImage'));
            add_action('wp_ajax_dopts_edit_images', array(&$DOPTS_pluginSeries, 'editImages'));
            add_action('wp_ajax_dopts_sort_images', array(&$DOPTS_pluginSeries, 'sortImages'));
            add_action('wp_ajax_dopts_show_image', array(&$DOPTS_pluginSeries, 'showImage'));
            add_action('wp_ajax_dopts_edit_image', array(&$DOPTS_pluginSeries, 'editImage'));
            add_action('wp_ajax_dopts_delete_image', array(&$DOPTS_pluginSeries, 'deleteImage'));
        }
    }
    else{// If you view the WordPress website init the scroller.
        if (class_exists("DOPThumbnailScrollerFrontEnd")){
            $DOPTS_pluginSeries = new DOPThumbnailScrollerFrontEnd();
        }

        if (isset($DOPTS_pluginSeries)){// Init AJAX functions.
            add_action('wp_ajax_dopts_get_scroller_data', array(&$DOPTS_pluginSeries, 'getScrollerData'));
        }
    }
                
    add_action('widgets_init', create_function('', 'return register_widget("DOPThumbnailScrollerWidget");'));

// Uninstall

    if (!function_exists("DOPThumbnailScrollerUninstall")){
        function DOPThumbnailScrollerUninstall() {
            global $wpdb;

            $tables = $wpdb->get_results('SHOW TABLES');

            foreach ($tables as $table){
                $table_name = $table->Tables_in_studios_wp;

                if (strrpos($table_name, 'dopts_settings') !== false ||
                    strrpos($table_name, 'dopts_scrollers') !== false ||
                    strrpos($table_name, 'dopts_images') !== false){
                    $wpdb->query("DROP TABLE IF EXISTS $table_name");
                }
            }
            
            delete_option('DOPTS_db_version');
        }
        
        register_uninstall_hook(__FILE__, 'DOPThumbnailScrollerUninstall');
    }
    
?>