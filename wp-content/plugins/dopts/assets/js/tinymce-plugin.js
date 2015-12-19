/*
* Title                   : Thumbnail Scroller (WordPress Plugin)
* Version                 : 1.6
* File                    : tinymce-plugin.js
* File Version            : 1.0
* Created / Last Modified : 25 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : TinyMCE Editor Plugin.
*/

(function(){
    var title, i,
    galleriesData,
    galleries = new Array();

    tinymce.create('tinymce.plugins.DOPTS', {
        init:function(ed, url){
            title = DOPTS_tinyMCE_data.split(';;;;;')[0];
            galleriesData = DOPTS_tinyMCE_data.split(';;;;;')[1];
            galleries = galleriesData.split(';;;');

            if (parseFloat(WP_version) > 3.8) { 
                var values = [],
                    valueNew = '',
                    valueALL = [];

                for (i=0; i<galleries.length; i++){
                    if (galleries[i] != ''){
                        valueNew = {text:"ID "+galleries[i].split(';;')[0]+": "+galleries[i].split(';;')[1],value:galleries[i].split(';;')[0]};

                        if (i<1){
                            valueALL = [valueNew];
                        } else {
                            valueALL.push(valueNew);
                        }
                        valueNew = '';
                    }
                }

                 ed.addButton('DOPTS', {
                    text: title,
                    type: 'listbox',
                    values:  valueALL, // [{text:"",value:""},{text:"",value:""}]
                    onPostRender: function() {
                        var ctrl = this;

                        ed.on('NodeChange', function(e) {
                            ctrl.active(e.element.nodeName == 'A');
                        });
                    },
                    onselect: function() {
                       //insert key
                       ed.insertContent('[dopts id="'+this.value()+'"]');

                       //reset selected value
                       this.value(null);
                    },        
                });
            }
    
        },

        createControl:function(n, cm){// Init Combo Box.
            
            if (parseFloat(WP_version) < 3.9) { 
                
                switch (n){
                    case 'DOPTS':
                        if (galleriesData != ''){
                            var mlb = cm.createListBox('DOPTS', {
                                 title: title,
                                 onselect: function(value){
                                     tinyMCE.activeEditor.selection.setContent(value);
                                 }
                            });

                            for (i=0; i<galleries.length; i++){
                                if (galleries[i] != ''){
                                    mlb.add('ID '+galleries[i].split(';;')[0]+': '+galleries[i].split(';;')[1], '[dopts id="'+galleries[i].split(';;')[0]+'"]');
                                }
                            }

                            return mlb;
                        }
                }
                
            }

            return null;
        },

        getInfo:function(){
            return {longname  : 'Booking System PRO',
                    author    : 'Dot on Paper',
                    authorurl : 'http://www.dotonpaper.net',
                    infourl   : 'http://www.dotonpaper.net',
                    version   : '1.0'};
        }
    });

    tinymce.PluginManager.add('DOPTS', tinymce.plugins.DOPTS);
})();