jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.twiquote_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('twiquote_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[blockquote]'+selected+'[/blockquote]';
                    }else{
                        content =  '[blockquote][/blockquote]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('twiquote_button', {title : 'Twi-blockquote', cmd : 'twiquote_insert_shortcode', image: url + '/i/icon-twiquote.png' });
        },
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('twiquote_button', tinymce.plugins.twiquote_plugin);
});