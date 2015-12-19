<?php

/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : templates.php
* File Version            : 1.5
* Created / Last Modified : 01 October 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Thumbnail Scroller Templates Class.
*/

    if (!class_exists("DOPTSTemplates")){
        class DOPTSTemplates{
            function DOPTSTemplates(){// Constructor.
            }

            function scrollersList(){// Return Template      
                global $blog_id;            
?>
    <script type="text/JavaScript">
        var DOPTS_curr_page = "Scrollers List",
        DOPTS_plugin_url = "<?php echo DOPTS_Plugin_URL?>",
        DOPTS_plugin_abs = "<?php echo DOPTS_Plugin_AbsPath?>",
<?php
    global $DOPTS_lang;
    
    for ($i=0; $i<count($DOPTS_lang); $i++){
        echo $DOPTS_lang[$i]['key']." = '".$DOPTS_lang[$i]['text']."', ";
    }
?>
        DOPTS_END_TRANSLATION_LIST = 'End translation.';
    </script>
    <div class="wrap DOPTS-admin">
        <h2><?php echo DOPTS_TITLE?></h2>
        <div id="DOPTS-admin-message"></div>
        <a href="http://envato-help.dotonpaper.net/thumbnail-scroller-wordpress-plugin.html#faq" target="_blank" class="DOPTS-help"><?php echo DOPTS_HELP_FAQ ?></a>
        <a href="http://envato-help.dotonpaper.net/thumbnail-scroller-wordpress-plugin.html" target="_blank" class="DOPTS-help"><?php echo DOPTS_HELP_DOCUMENTATION ?></a>
        
        <input type="hidden" id="blog_id" value="<?php echo $blog_id; ?>" />
        <input type="hidden" id="scroller_id" value="" />
        <br class="DOPTS-clear" />
        <div class="main">
            <div class="column column1">
                <div class="column-header">
                    <div class="add-button">
                        <a href="javascript:doptsAddScroller()" title="<?php echo DOPTS_ADD_SCROLLER_SUBMIT?>"></a>
                    </div>
                    <div class="edit-button">
                        <a href="javascript:doptsShowDefaultSettings()" title="<?php echo DOPTS_EDIT_SCROLLERS_SUBMIT?>"></a>
                    </div>
                    <a href="javascript:void()" class="header-help"><span><?php echo DOPTS_SCROLLERS_HELP?></span></a>
                </div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column3">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <br class="DOPTS-clear" />
    </div>
<?php
            }
        }
    }
?>