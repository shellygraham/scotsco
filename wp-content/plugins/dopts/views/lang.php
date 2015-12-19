<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : lang.php
* File Version            : 1.5
* Created / Last Modified : 01 October 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Translation.
*/

    $DOPTS_lang = array();

    array_push($DOPTS_lang, array('key' => 'DOPTS_TITLE', 'text' => 'Thumbnail Scroller'));

    // Loading ...
    array_push($DOPTS_lang, array('key' => 'DOPTS_LOAD', 'text' => 'Load data ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLERS_LOADED', 'text' => 'Scrollers list loaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_IMAGES_LOADED', 'text' => 'Images list loaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_NO_SCROLLERS', 'text' => 'No scrollers.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_NO_IMAGES', 'text' => 'No images.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLER_LOADED', 'text' => 'Scroller data loaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_IMAGE_LOADED', 'text' => 'Image loaded.'));

    // Save ...
    array_push($DOPTS_lang, array('key' => 'DOPTS_SAVE', 'text' => 'Save data ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SELECT_FILE', 'text' => 'Select File'));

    // Help
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLERS_HELP', 'text' => 'Click on the "Plus" icon to add a scroller. Click on a scroller item to open the editing area. Click on the "Pencil" icon to edit scrollers default settings.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLERS_EDIT_INFO_HELP', 'text' => 'Click "Submit Button" to save changes.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLER_EDIT_HELP', 'text' => 'Click on the "Plus" icon to add images. Click on an image to open the editing area. You can drag images to sort them. Click on the "Pencil" icon to edit scroller settings. Check images, select action and click "Apply" to bulk edit images.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLER_EDIT_INFO_HELP', 'text' => 'Click "Submit Button" to save changes. Images are saved automaticaly. Click "Delete Button" to delete the scroller. Click "Use Settings" to use the predefined settings; the current settings will be deleted.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGES_HELP', 'text' => 'You have 4 upload types (WordPress, AJAX, Uploadify, FTP). At least one should work.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGES_HELP_WP', 'text' => 'You can use the default WordPress Uploader. To add an image to the scroller select it from WordPress and press Insert into Post.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGES_HELP_AJAX', 'text' => 'Just a simple AJAX upload. Just select an image and the upload will start automatically.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGES_HELP_UPLOADIFY', 'text' => 'You can use this option if you want to upload a single or multiple images to your scroller. Just select the images and the upload will start automatically. Uploadify will not display the progress bar and image processing will go slower if you have a firewall enabled.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGES_HELP_FTP', 'text' => 'Copy all the images in ftp-uploads in Thumbnail Scroller plugin folder. Press Add Images to add the content of the folder to your scroller. This will take some time depending on the number and size of the images. On some servers the images names that contain other characters different from alphanumeric ones will not be uploaded. Change the names for them to work.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_IMAGE_EDIT_HELP', 'text' => 'Drag the mouse over the big image to select a new thumbnail. Click "Submit Button" to save the thumbnail, title, media, lightbox media, link, link target or enable/disable the image. Click "Delete Button" to delete the image.'));

    // Form
    array_push($DOPTS_lang, array('key' => 'DOPTS_SELECT_ACTION', 'text' => 'Select Action'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_APPLY', 'text' => 'Apply'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SUBMIT', 'text' => 'Submit'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE', 'text' => 'Delete'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ENABLE', 'text' => 'Enable'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DISABLE', 'text' => 'Disable'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DEFAULT', 'text' => 'Use Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGES_CONFIRMATION', 'text' => 'Are you sure you want to delete images?'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGES_SUBMITED', 'text' => 'Deleting images ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGES_SUCCESS', 'text' => 'You have succesfully deleted the images.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ENABLE_IMAGES_CONFIRMATION', 'text' => 'Are you sure you want to enable images?'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ENABLE_IMAGES_SUBMITED', 'text' => 'Enabling images ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ENABLE_IMAGES_SUCCESS', 'text' => 'You have succesfully enabled the images.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DISABLE_IMAGES_CONFIRMATION', 'text' => 'Are you sure you want to disable images?'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DISABLE_IMAGES_SUBMITED', 'text' => 'Disabling images ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DISABLE_IMAGES_SUCCESS', 'text' => 'You have succesfully disabled the images.'));

    //Form Text
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_ENABLED_TEXT', 'text' => 'Enabled'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_DISABLED_TEXT', 'text' => 'Disabled'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_NORMAL_TEXT', 'text' => 'Normal'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_RANDOM_TEXT', 'text' => 'Random'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_HORIZONTAL_TEXT', 'text' => 'Horizontal'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_VERTICAL_TEXT', 'text' => 'Vertical'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_NONE_TEXT', 'text' => 'None'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_TOOLTIP_TEXT', 'text' => 'Tooltip'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_LABEL_TEXT', 'text' => 'Label'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_BOTTOM_SLASH_RIGHT_TEXT', 'text' => 'Bottom/Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_TOP_SLASH_LEFT_TEXT', 'text' => 'Top/Left'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_BOTTOM_TEXT', 'text' => 'Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_TOP_TEXT', 'text' => 'Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_FORM_UNDER_TEXT', 'text' => 'Under'));
    
    // Add Scroller
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_SCROLLER_NAME', 'text' => 'New Scroller'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_SCROLLER_SUBMIT', 'text' => 'Add Scroller'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_SCROLLER_SUBMITED', 'text' => 'Adding scroller ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_GALERRY_SUCCESS', 'text' => 'You have succesfully added a new scroller.'));

    // Edit Scrollers
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_SCROLLERS_SUBMIT', 'text' => 'Edit Scrollers Default Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_SCROLLERS_SUCCESS', 'text' => 'You have succesfully edited the default settings.'));

    // Edit Scroller
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_SCROLLER_SUBMIT', 'text' => 'Edit Scroller'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_SCROLLER_SUCCESS', 'text' => 'You have succesfully edited the scroller.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_SCROLLER_USE_DEFAULT_CONFIRMATION', 'text' => 'Are you sure you want to use this predefined settings. Current settings are going to be deleted?'));

    // Delete Scroller
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_SCROLLER_CONFIRMATION', 'text' => 'Are you sure you want to delete this scroller?'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_SCROLLER_SUBMIT', 'text' => 'Delete Scroller'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_SCROLLER_SUBMITED', 'text' => 'Deleting scroller ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_GALERRY_SUCCESS', 'text' => 'You have succesfully deleted the scroller.'));

    // Add Image
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_SUBMIT', 'text' => 'Add Images'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_WP_UPLOAD', 'text' => 'Default WordPress file upload'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_SIMPLE_UPLOAD', 'text' => 'Simple AJAX file upload'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_MULTIPLE_UPLOAD', 'text' => 'Multiple files upload (Uploadify jQuery Plugin)'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_FTP_UPLOAD', 'text' => 'FTP file upload'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_SUBMITED', 'text' => 'Adding images ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_IMAGE_SUCCESS', 'text' => 'You have succesfully added a new image.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SELECT_IMAGES', 'text' => 'Select Images'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SELECT_FTP_IMAGES', 'text' => 'Add Images'));

    // Sort Image
    array_push($DOPTS_lang, array('key' => 'DOPTS_SORT_IMAGES_SUBMITED', 'text' => 'Sorting images ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SORT_IMAGES_SUCCESS', 'text' => 'You have succesfully sorted the images.'));

    // Edit Image
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_SUBMIT', 'text' => 'Edit Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_SUCCESS', 'text' => 'You have succesfully edited the image.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_CROP_THUMBNAIL', 'text' => 'Crop Thumbnail'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_CURRENT_THUMBNAIL', 'text' => 'Current Thumbnail'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_TITLE', 'text' => 'Title'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_CAPTION', 'text' => 'Caption'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_MEDIA', 'text' => 'Media: Add HTML, Flash, ...<br />IMPORTANT: Make sure that all the code is in one html tag. Iframe embedding code will work :).'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_LIGHTBOX_MEDIA', 'text' => 'Lightbox Media: Add HTML, Flash, ... in the lightbox.<br />IMPORTANT: Make sure that all the code is in one html tag. Iframe embedding code will work :).'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_LINK', 'text' => 'Link ... if you add <strong>none</strong> the thumbnail will have no event'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_LINK_TARGET', 'text' => 'Link Target'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_EDIT_IMAGE_ENABLED', 'text' => 'Enabled'));

    // Delete Image
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGE_CONFIRMATION', 'text' => 'Are you sure you want to delete this image?'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGE_SUBMIT', 'text' => 'Delete Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGE_SUBMITED', 'text' => 'Deleting image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DELETE_IMAGE_SUCCESS', 'text' => 'You have succesfully deleted the image.'));

    // TinyMCE
    array_push($DOPTS_lang, array('key' => 'DOPTS_TINYMCE_ADD', 'text' => 'Add Thumbnail Scroller'));
    
    // Settings
    array_push($DOPTS_lang, array('key' => 'DOPTS_DEFAULT_SETTINGS', 'text' => 'Default Settings'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_GENERAL_STYLES_SETTINGS', 'text' => 'General Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLER_NAME', 'text' => 'Name'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DATA_PARSE_METHOD', 'text' => 'Scroller Data Parse Method'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDTH', 'text' => 'Width'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_HEIGHT', 'text' => 'Height'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_COLOR', 'text' => 'Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_ALPHA', 'text' => 'Background Alpha'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_BORDER_SIZE', 'text' => 'Background Border Size'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_BORDER_COLOR', 'text' => 'Background Border Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_IMAGES_ORDER', 'text' => 'Thumbnails Order'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_RESPONSIVE_ENABLED', 'text' => 'Responsive Enabled'));   
    array_push($DOPTS_lang, array('key' => 'DOPTS_ULTRA_RESPONSIVE_ENABLED', 'text' => 'Ultra Responsive Enabled'));   
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_STYLES_SETTINGS', 'text' => 'Thumbnails Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_POSITION', 'text' => 'Thumbnails Position'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BG_COLOR', 'text' => 'Thumbnails Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BG_ALPHA', 'text' => 'Thumbnails Background Alpha'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BORDER_SIZE', 'text' => 'Thumbnails Background Border Size'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BORDER_COLOR', 'text' => 'Thumbnails Background Border Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_SPACING', 'text' => 'Thumbnails Spacing'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_TOP', 'text' => 'Thumbnails Margin Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_RIGHT', 'text' => 'Thumbnails Margin Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_BOTTOM', 'text' => 'Thumbnails Margin Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_LEFT', 'text' => 'Thumbnails Margin Left')); 
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_TOP', 'text' => 'Thumbnails Padding Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_RIGHT', 'text' => 'Thumbnails Padding Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_BOTTOM', 'text' => 'Thumbnails Padding Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_LEFT', 'text' => 'Thumbnails Padding Left'));    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_INFO', 'text' => 'Info Thumbnails Display'));
            
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_STYLES_SETTINGS', 'text' => 'Thumbnails Navigation Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_EASING', 'text' => 'Thumbnails Navigation Easing'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_LOOP', 'text' => 'Enable Thumbnails Loop'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_MOUSE_ENABLED', 'text' => 'Enable Thumbnails Mouse Navigation'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_ENABLED', 'text' => 'Enable Thumbnails Scroll Navigation'));            
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_POSITION', 'text' => 'Thumbnails Scroll Position'));          
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SIZE', 'text' => 'Thumbnails Scroll Size'));                   
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SCRUB_COLOR', 'text' => 'Thumbnails Scroll Scrub Color'));            
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_BAR_COLOR', 'text' => 'Thumbnails Scroll Bar Color'));          
                
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_ENABLED', 'text' => 'Enable Thumbnails Arrows Navigation'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_NO_ITEMS_SLIDE', 'text' => 'Thumbnails Navigation Arrows Number Items Slide'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_SPEED', 'text' => 'Thumbnails Navigation Arrows Speed'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV', 'text' => 'Thumbnails Navigation Previous Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_SUBMITED', 'text' => 'Uploading previous button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_SUCCESS', 'text' => 'Previous button image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV_HOVER', 'text' => 'Thumbnails Navigation Previous Button Hover Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_HOVER_SUBMITED', 'text' => 'Uploading previous button hover image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_HOVER_SUCCESS', 'text' => 'Previous button hover image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV_DISABLED', 'text' => 'Thumbnails Navigation Previous Button Disabled Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_DISABLED_SUBMITED', 'text' => 'Uploading previous button disabled image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_PREV_DISABLED_SUCCESS', 'text' => 'Previous button disabled image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT', 'text' => 'Thumbnails Navigation Next Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_SUBMITED', 'text' => 'Uploading next button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_SUCCESS', 'text' => 'Next button image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT_HOVER', 'text' => 'Thumbnails Navigation Next Button Hover Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_HOVER_SUBMITED', 'text' => 'Uploading next button hover image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_HOVER_SUCCESS', 'text' => 'Next button hover image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT_DISABLED', 'text' => 'Thumbnails Navigation Next Button Disabled Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_DISABLED_SUBMITED', 'text' => 'Uploading next button disabled image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAILS_NAVIGATION_NEXT_DISABLED_SUCCESS', 'text' => 'Next button disabled image uploaded.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_STYLES_SETTINGS', 'text' => 'Styles & Settings for a Thumbnail'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_LOADER', 'text' => 'Thumbnail Loader'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAIL_LOADER_SUBMITED', 'text' => 'Adding thumbnail loader...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_THUMBNAIL_LOADER_SUCCESS', 'text' => 'Thumbnail loader added.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_WIDTH', 'text' => 'Thumbnail Width'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_HEIGHT', 'text' => 'Thumbnail Height'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_ALPHA', 'text' => 'Thumbnail Alpha'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_ALPHA_HOVER', 'text' => 'Thumbnail Alpha Hover'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BG_COLOR', 'text' => 'Thumbnail Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BG_COLOR_HOVER', 'text' => 'Thumbnail Background Color Hover'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_SIZE', 'text' => 'Thumbnail Border Size'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_COLOR', 'text' => 'Thumbnail Border Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_COLOR_HOVER', 'text' => 'Thumbnail Border Color Hover'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_TOP', 'text' => 'Thumbnail Padding Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_RIGHT', 'text' => 'Thumbnail Padding Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_BOTTOM', 'text' => 'Thumbnail Padding Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_LEFT', 'text' => 'Thumbnail Padding Left'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_STYLES_SETTINGS', 'text' => 'Lightbox Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_ENABLED', 'text' => 'Lightbox Enabled'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_DISPLAY_TIME', 'text' => 'Lightbox Display Time'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_WINDOW_COLOR', 'text' => 'Lightbox Window Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_WINDOW_ALPHA', 'text' => 'Lightbox Window Alpha'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_LOADER', 'text' => 'Lightbox Loader'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_LOADER_SUBMITED', 'text' => 'Adding lightbox loader...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_LOADER_SUCCESS', 'text' => 'Lightbox loader added.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BACKGROUND_COLOR', 'text' => 'Lightbox Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BACKGROUND_ALPHA', 'text' => 'Lightbox Background Alpha'));    
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BORDER_SIZE', 'text' => 'Lightbox Border Size'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BORDER_COLOR', 'text' => 'Lightbox Border Color'));    
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_CAPTION_TEXT_COLOR', 'text' => 'Lightbox Caption Text Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_TOP', 'text' => 'Lightbox Margin Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_RIGHT', 'text' => 'Lightbox Margin Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_BOTTOM', 'text' => 'Lightbox Margin Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_LEFT', 'text' => 'Lightbox Margin Left'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_TOP', 'text' => 'Lightbox Padding Top'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_RIGHT', 'text' => 'Lightbox Padding Right'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_BOTTOM', 'text' => 'Lightbox Padding Bottom'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_LEFT', 'text' => 'Lightbox Padding Left'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_STYLES_SETTINGS', 'text' => 'Lightbox Navigation Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_PREV', 'text' => 'Lightbox Navigation Previous Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_SUBMITED', 'text' => 'Uploading previous button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_SUCCESS', 'text' => 'Previous button image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_PREV_HOVER', 'text' => 'Lightbox Navigation Previous Button Hover Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_HOVER_SUBMITED', 'text' => 'Uploading previous button hover image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_PREV_HOVER_SUCCESS', 'text' => 'Previous button hover image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_NEXT', 'text' => 'Lightbox Navigation Next Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_SUBMITED', 'text' => 'Uploading next button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_SUCCESS', 'text' => 'Next button image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_NEXT_HOVER', 'text' => 'Lightbox Navigation Next Button Hover Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_HOVER_SUBMITED', 'text' => 'Uploading next button hover image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_NEXT_HOVER_SUCCESS', 'text' => 'Next button hover image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_CLOSE', 'text' => 'Lightbox Navigation Close Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_SUBMITED', 'text' => 'Uploading close button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_SUCCESS', 'text' => 'Close button image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_CLOSE_HOVER', 'text' => 'Lightbox Navigation Close Button Hover Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_HOVER_SUBMITED', 'text' => 'Uploading close button hover image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ADD_LIGHTBOX_NAVIGATION_CLOSE_HOVER_SUCCESS', 'text' => 'Close button hover image uploaded.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_INFO_BG_COLOR', 'text' => 'Lightbox Navigation Info Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_INFO_TEXT_COLOR', 'text' => 'Lightbox Navigation Info Text Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_DISPLAY_TIME', 'text' => 'Lightbox Navigation Display Time'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_TOUCH_DEVICE_SWIPE_ENABLED', 'text' => 'Swipe Lightbox Navigation Enabled'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_STYLES_SETTINGS', 'text' => 'Social Share Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_ENABLED', 'text' => 'Social Share Enabled'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_LIGHTBOX', 'text' => 'Lightbox Social Share Button Image'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_LIGHTBOX_SUBMITED', 'text' => 'Uploading lightbox social share button image ...'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_LIGHTBOX_SUCCESS', 'text' => 'Lightbox social share button image uploaded.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_STYLES_SETTINGS', 'text' => 'Tooltip Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_BG_COLOR', 'text' => 'Tooltip Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_STROKE_COLOR', 'text' => 'Tooltip Stroke Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_TEXT_COLOR', 'text' => 'Tooltip Text Color'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_STYLES_SETTINGS', 'text' => 'Label Styles & Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_POSITION', 'text' => 'Label Position'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_ALWAYS_VISIBLE', 'text' => 'Label Always Visible'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_UNDER_HEIGHT', 'text' => 'Height for Under Label'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_BG_COLOR', 'text' => 'Label Background Color'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_BG_ALPHA', 'text' => 'Label Background Alpha'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_TEXT_COLOR', 'text' => 'Label Text Color'));    
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_SETTINGS', 'text' => 'Slideshow Settings'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_ENABLED', 'text' => 'Slideshow Enabled'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_TIME', 'text' => 'Slideshow Time'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_LOOP', 'text' => 'Slideshow Loop'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_GO_TOP', 'text' => 'go top'));

    array_push($DOPTS_lang, array('key' => 'DOPTS_SCROLLER_NAME_INFO', 'text' => 'Change scroller name.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_DATA_PARSE_METHOD_INFO', 'text' => 'Scroller Data Parse Method (AJAX, HTML). Default value: AJAX. Set the method by which the data will be parsed to the scroller.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDTH_INFO', 'text' => 'Width (value in pixels). Default value: 900. Set the width of the scroller.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_HEIGHT_INFO', 'text' => 'Height (value in pixels). Default value: 128. Set the height of the scroller.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_COLOR_INFO', 'text' => 'Background Color (color hex code). Default value: ffffff. Set scroller background color.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_ALPHA_INFO', 'text' => 'Background Alpha (value from 0 to 100). Default value: 100. Set scroller alpha.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_BORDER_SIZE_INFO', 'text' => 'Background Border Size (value in pixels). Default value: 1. Set the size of the scroller border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_BG_BORDER_COLOR_INFO', 'text' => 'Background Border Color (color hex code). Default value: e0e0e0. Set the color of the scroller border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_IMAGES_ORDER_INFO', 'text' => 'Thumbnails Order (Normal, Random). Default value: Normal. Set thumbnails order.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_RESPONSIVE_ENABLED_INFO', 'text' => 'Responsive Enabled (Enabled, Disabled). Default value: Enabled. Enable responsive layout. Resize only width or height.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_ULTRA_RESPONSIVE_ENABLED_INFO', 'text' => 'Ultra Responsive Enabled (Enabled, Disabled). Default value: Disabled. Enable ultra responsive layout. Resize both width and height. It is a boost to normal response function which you must have enabled.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_POSITION_INFO', 'text' => 'Thumbnails Position (Horizontal, Vertical). Default value: Horizontal. Set the position of the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BG_COLOR_INFO', 'text' => 'Thumbnails Background Color (color hex code). Default value: ffffff. Set the color for the thumbnails background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BG_ALPHA_INFO', 'text' => 'Thumbnails Background Alpha (value from 0 to 100). Default value: 0. Set the transparancy for the thumbnails background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BORDER_SIZE_INFO', 'text' => 'Thumbnails Background Border Size (value in pixels). Default value: 0. Set the size of the thumbnails border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_BORDER_COLOR_INFO', 'text' => 'Thumbnails Background Border Color (color hex code). Default value: e0e0e0. Set the color of the thumbnails border.'));    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_SPACING_INFO', 'text' => 'Thumbnails Spacing (value in pixels). Default value: 10. Set the space between thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_TOP_INFO', 'text' => 'Thumbnails Margin Top (value in pixels). Default value: 10. Set the top margin for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_RIGHT_INFO', 'text' => 'Thumbnails Margin Right (value in pixels). Default value: 0. Set the right margin for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_BOTTOM_INFO', 'text' => 'Thumbnails Margin Bottom (value in pixels). Default value: 10. Set the bottom margin for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_MARGIN_LEFT_INFO', 'text' => 'Thumbnails Margin Left (value in pixels). Default value: 0. Set the left margin for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_TOP_INFO', 'text' => 'Thumbnails Padding Top (value in pixels). Default value: 0. Set the top padding for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_RIGHT_INFO', 'text' => 'Thumbnails Padding Right (value in pixels). Default value: 0. Set the right padding for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_BOTTOM_INFO', 'text' => 'Thumbnails Padding Bottom (value in pixels). Default value: 0. Set the bottom padding for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_PADDING_LEFT_INFO', 'text' => 'Thumbnails Padding Left (value in pixels). Default value: 0. Set the left padding for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_INFO_INFO', 'text' => 'Info Thumbnails Display (None, Tooltip, Label). Default value: Label. Display a small info text on the thumbnails, a tooltip or a label.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_EASING_INFO', 'text' => 'Thumbnails Navigation Easing (linear, swing, easeInQuad, easeOutQuad, easeInOutQuad, easeInCubic, easeOutCubic, easeInOutCubic, easeInQuart, easeOutQuart, easeInOutQuart, easeInQuint, easeOutQuint, easeInOutQuint, easeInSine, easeOutSine, easeInOutSine, easeInExpo, easeOutExpo, easeInOutExpo, easeInCirc, easeOutCirc, easeInOutCirc, easeInElastic, easeOutElastic, easeInOutElastic, easeInBack, easeOutBack, easeInOutBack, easeInBounce, easeOutBounce, easeInOutBounce). Default value: linear. Set thumbnails navigation easing.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_LOOP_INFO', 'text' => 'Enable Thumbnails Loop (Enabled, Disabled). Default value: Disabled. Enable thumbnails loop ... scroll will be disabled.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_MOUSE_ENABLED_INFO', 'text' => 'Enable Thumbnails Mouse Navigation (Enabled, Disabled). Default value: Disabled. Enable thumbnails mouse navigation.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_ENABLED_INFO', 'text' => 'Enable Thumbnails Scroll Navigation (Enabled, Disabled). Default value: Disabled. Enable thumbnails scroll navigation.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_POSITION_INFO', 'text' => 'Thumbnails Scroll Position (Bottom/Right, Top/Left). Default value: Bottom/Right. Set thumbnails scroll position.'));  
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SIZE_INFO', 'text' => 'Thumbnails Scroll Size (value in pixels). Default value: 5. Set the scroll size color.'));  
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_SCRUB_COLOR_INFO', 'text' => 'Thumbnails Scroll Scrub Color (color hex code). Default value: 808080. Set the scroll scrub color.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_SCROLL_BAR_COLOR_INFO', 'text' => 'Thumbnails Scroll Bar Color (color hex code). Default value: e0e0e0. Set the scroll bar color.'));
                                            
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_ENABLED_INFO', 'text' => 'Enable Thumbnails Arrows Navigation (Enabled, Disabled). Default value: Enabled. Enable thumbnails arrows navigation.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_NO_ITEMS_SLIDE_INFO', 'text' => 'Thumbnails Navigation Arrows Number Items Slide (number of thumbnails). Default value: 1. The number of thumbnails that will slide when you click the arrows.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_ARROWS_SPEED_INFO', 'text' => 'Thumbnails Navigation Arrows Speed (time in miliseconds). Default value: 600. The time the thumbnails will slide after you click the arrows.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV_INFO', 'text' => 'Thumbnails Navigation Previous Button Image (path to image). Upload the image for thumbnails navigation previous button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV_HOVER_INFO', 'text' => 'Thumbnails Navigation Previous Button Hover Image (path to image). Upload the image for thumbnails navigation previous hover button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_PREV_DISABLED_INFO', 'text' => 'Thumbnails Navigation Previous Button Disabled Image (path to image). Upload the image for thumbnails navigation previous disabled button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT_INFO', 'text' => 'Thumbnails Navigation Next Button Image (path to image). Upload the image for thumbnails navigation next button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT_HOVER_INFO', 'text' => 'Thumbnails Navigation Next Button Hover Image (path to image). Upload the image for thumbnails navigation next hover button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAILS_NAVIGATION_NEXT_DISABLED_INFO', 'text' => 'Thumbnails Navigation Next Button Disabled Image (path to image). Upload the image for thumbnails navigation next disabled button.'));
                                                
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_LOADER_INFO', 'text' => 'Thumbnail Loader (path to image). Set the loader for the thumbnails.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_WIDTH_INFO', 'text' => 'Thumbnail Width (the size in pixels). Default value: 100. Set the width of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_HEIGHT_INFO', 'text' => 'Thumbnail Height (the size in pixels). Default value: 100. Set the height of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_ALPHA_INFO', 'text' => 'Thumbnail Alpha (value from 0 to 100). Default value: 100. Set the transparancy of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_ALPHA_HOVER_INFO', 'text' => 'Thumbnail Alpha Hover (value from 0 to 100). Default value: 100. Set the transparancy of a thumbnail when hover.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BG_COLOR_INFO', 'text' => 'Thumbnail Background Color (color hex code). Default value: f1f1f1. Set the color of a thumbnail background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BG_COLOR_HOVER_INFO', 'text' => 'Thumbnail Background Color Hover (color hex code). Default value: f1f1f1. Set the color of a thumbnail background when hover.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_SIZE_INFO', 'text' => 'Thumbnail Border Size (value in pixels). Default value: 1. Set the size of a thumbnail border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_COLOR_INFO', 'text' => 'Thumbnail Border Color (color hex code). Default value: d0d0d0. Set the color of a thumbnail border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_BORDER_COLOR_HOVER_INFO', 'text' => 'Thumbnail Border Color Hover (color hex code). Default value: 303030. Set the color of a thumbnail border when hover.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_TOP_INFO', 'text' => 'Thumbnail Padding Top (value in pixels). Default value: 2. Set top padding value of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_RIGHT_INFO', 'text' => 'Thumbnail Padding Right (value in pixels). Default value: 2. Set right padding value of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_BOTTOM_INFO', 'text' => 'Thumbnail Padding Bottom (value in pixels). Default value: 2. Set bottom padding value of a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_THUMBNAIL_PADDING_LEFT_INFO', 'text' => 'Thumbnail Padding Left (value in pixels). Default value: 2. Set left padding value of a thumbnail.'));

    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_ENABLED_INFO', 'text' => 'Enable Lightbox (Enabled, Disabled). Default value: Enabled. Enable the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_DISPLAY_TIME_INFO', 'text' => 'Lightbox Display Time (time in miliseconds). Default value: 600. The time the lightbox will be displayed.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_WINDOW_COLOR_INFO', 'text' => 'Lightbox Window Color (color hex code). Default value: ffffff. Set the color for the lightbox window.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_WINDOW_ALPHA_INFO', 'text' => 'Lightbox Window Alpha (value from 0 to 100). Default value: 80. Set the transparancy for the lightbox window.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_LOADER_INFO', 'text' => 'Lightbox Loader (path to image). Set the loader for the lightbox image.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BACKGROUND_COLOR_INFO', 'text' => 'Lightbox Background Color (color hex code). Default value: ffffff. Set the color for the lightbox background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BACKGROUND_ALPHA_INFO', 'text' => 'Lightbox Background Alpha (value from 0 to 100). Default value: 100. Set the transparancy for the lightbox background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BORDER_SIZE_INFO', 'text' => 'Lightbox Border Size (value in pixels). Default value: 1. Set the size of a lightbox border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_BORDER_COLOR_INFO', 'text' => 'Lightbox Border Color (color hex code). Default value: e0e0e0. Set the color of a lightbox border.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_CAPTION_TEXT_COLOR_INFO', 'text' => 'Lightbox Caption Text Color (color hex code). Default value: 999999. Set the color for the lightbox caption.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_TOP_INFO', 'text' => 'Lightbox Margin Top (value in pixels). Default value: 30. Set top margin value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_RIGHT_INFO', 'text' => 'Lightbox Margin Right (value in pixels). Default value: 30. Set right margin value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_BOTTOM_INFO', 'text' => 'Lightbox Margin Bottom (value in pixels). Default value: 30. Set bottom margin value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_MARGIN_LEFT_INFO', 'text' => 'Lightbox Margin Left (value in pixels). Default value: 30. Set top left value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_TOP_INFO', 'text' => 'Lightbox Padding Top (value in pixels). Default value: 10. Set top padding value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_RIGHT_INFO', 'text' => 'Lightbox Padding Right (value in pixels). Default value: 10. Set right padding value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_BOTTOM_INFO', 'text' => 'Lightbox Padding Bottom (value in pixels). Default value: 10. Set bottom padding value for the lightbox.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_PADDING_LEFT_INFO', 'text' => 'Lightbox Padding Left (value in pixels). Default value: 10. Set left padding value for the lightbox.'));
                                                
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_PREV_INFO', 'text' => 'Lightbox Navigation Previous Button Image (path to image). Upload the image for lightbox navigation previous button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_PREV_HOVER_INFO', 'text' => 'Lightbox Navigation Previous Button Hover Image (path to image). Upload the image for lightbox navigation previous hover button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_NEXT_INFO', 'text' => 'Lightbox Navigation Next Button Image (path to image). Upload the image for lightbox navigation next button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_NEXT_HOVER_INFO', 'text' => 'Lightbox Navigation Next Button Hover Image (path to image). Upload the image for lightbox navigation next hover button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_CLOSE_INFO', 'text' => 'Lightbox Navigation Close Button Image (path to image). Upload the image for lightbox navigation close button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_CLOSE_HOVER_INFO', 'text' => 'Lightbox Navigation Close Button Hover Image (path to image). Upload the image for lightbox navigation close hover button.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_INFO_BG_COLOR_INFO', 'text' => 'Lightbox Navigation Info Background Color (color hex code). Default value: ffffff. Set the color for the lightbox info background.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_INFO_TEXT_COLOR_INFO', 'text' => 'Lightbox Navigation Info Text Color (color hex code). Default value: c0c0c0. Set the color for the lightbox info text.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_DISPLAY_TIME_INFO', 'text' => 'Lightbox Navigation Display Time (time in miliseconds). Default value: 600. The time the lightbox navigation will be displayed.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LIGHTBOX_NAVIGATION_TOUCH_DEVICE_SWIPE_ENABLED_INFO', 'text' => 'Swipe Lightbox Navigation Enabled (Enabled, Disabled). Default value: Enabled. Enable swipe lightbox navigation on touch devices.'));

    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_ENABLED_INFO', 'text' => 'Social Share Enabled (Enabled, Disabled). Default value: Enabled. Enable AddThis Social Share.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SOCIAL_SHARE_LIGHTBOX_INFO', 'text' => 'Lightbox Social Share Button Image (path to image). Upload the image for lightbox social share button.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_BG_COLOR_INFO', 'text' => 'Tooltip Background Color (color hex code). Default value: ffffff. Set tooltip background color.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_STROKE_COLOR_INFO', 'text' => 'Tooltip Stroke Color (color hex code). Default value: 000000. Set tooltip stroke color.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_TOOLTIP_TEXT_COLOR_INFO', 'text' => 'Tooltip Text Color (color hex code). Default value: 000000. Set tooltip text color.'));

    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_POSITION_INFO', 'text' => 'Label Position (Bottom, Top, Under). Default value: Bottom. Set label position.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_ALWAYS_VISIBLE_INFO', 'text' => 'Label Always Visible (Enabled, Disabled). Default value: Disabled. On true the label is always visible, on false it will be visible only on hover.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_UNDER_HEIGHT_INFO', 'text' => 'Height for Under Label (the size in pixels). Default value: 50. Set the height only for the label under a thumbnail.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_BG_COLOR_INFO', 'text' => 'Label Background Color (color hex code). Default value: 000000. Set label background color.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_BG_ALPHA_INFO', 'text' => 'Label Background Alpha (value from 0 to 100). Default value: 80. Set label background transparancy.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_LABEL_TEXT_COLOR_INFO', 'text' => 'Label Text Color (color hex code). Default value: ffffff. Set label text color.'));
    
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_ENABLED_INFO', 'text' => 'Slideshow Enabled (Enabled, Disabled). Default value: Disabled. Enable or disable the slideshow.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_TIME_INFO', 'text' => 'Slideshow Time (time in miliseconds). Default: 5000. How much time a thumbnail stays until it passes to the next one.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_SLIDESHOW_LOOP_INFO', 'text' => 'Slideshow Loop (Enabled, Disabled). Default: false. Set it to true if you do not want the slideshow to stop when it reaches the last thumbnail.'));
    
    // Widget    
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDGET_TITLE', 'text' => 'Thumbnail Scroller'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDGET_DESCRIPTION', 'text' => 'Select the ID of the Scroller you want in the widget.'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDGET_LABEL_TITLE', 'text' => 'Title:'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDGET_LABEL_ID', 'text' => 'Select Scroller ID:'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_WIDGET_NO_SCROLLERS', 'text' => 'No scrollers.'));
    
    // Help
    array_push($DOPTS_lang, array('key' => 'DOPTS_HELP_DOCUMENTATION', 'text' => 'Documentation'));
    array_push($DOPTS_lang, array('key' => 'DOPTS_HELP_FAQ', 'text' => 'FAQ'));
    
    for ($i=0; $i<count($DOPTS_lang); $i++){
        define($DOPTS_lang[$i]['key'], $DOPTS_lang[$i]['text']);
    }

?>