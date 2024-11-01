(function() {
    tinymce.create("tinymce.plugins.smoothbook_plugin", {

            //url argument holds the absolute url of our plugin directory
            init : function(ed, url) {

                //add new button
                ed.addButton("smoothbook", {
                        title : "Smoothbook",
                            cmd : "smoothbook_command",
                            text : "Smoothbook",
                            icon: false
                });

                //button functionality.
                ed.addCommand("smoothbook_command", function() {
                    var shortcode = '[smoothbook]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
                });
            },

            createControl : function(n, cm) {
                return null;
            },

            getInfo : function() {
                return {
                    longname : "Smoothbook Calendar",
                    author : "James Drummond",
                    version : "1"
                };
            }
    });
    tinymce.PluginManager.add("smoothbook_plugin", tinymce.plugins.smoothbook_plugin);
})();
