<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : dopts-frontend.php
* File Version            : 1.0
* Created / Last Modified : 10 December 2012
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Front End AJAX.
*/

    define("DOING_AJAX", true);

    require_once("../../../wp-load.php"); // Add wp-load.php file.
    
    if(!isset($_REQUEST["action"]) || trim($_REQUEST["action"])==""){
        die("-1");
    }

    @header("Content-Type: text/html; charset=".get_option("blog_charset"));

    include_once('dopts.php'); // Including your plugin’s main file where ajax actions are defined.
    send_nosniff_header();

    if (has_action("wp_ajax_".$_REQUEST["action"])){
        do_action("wp_ajax_".$_REQUEST["action"]);
        exit;
    }
    status_header(404);

?>