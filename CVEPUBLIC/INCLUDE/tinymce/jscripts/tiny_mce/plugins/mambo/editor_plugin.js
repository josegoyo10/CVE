/* Import theme specific language pack */
tinyMCE.importPluginLanguagePack('mambo', 'en,de,pl');

function TinyMCE_mambo_getControlHTML(control_name) {
    switch (control_name) {
        case "mosimage":
            return '<img id="{$editor_id}_mosimage" src="{$pluginurl}/images/mosimage.gif" title="{$lang_insert_mosimage_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'{mosimage}\')" />';
        case "mospagebreak":
            return '<img id="{$editor_id}_mospagebreak" src="{$pluginurl}/images/mospagebreak.gif" title="{$lang_insert_mospagebreak_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceMosPageBreak\');" />';
    }
    return "";
}

function TinyMCE_mambo_execCommand(editor_id, element, command, user_interface, value) {
    // Handle commands
    switch (command) {
        case "mceMosPageBreak":
            var template = new Array();
            template['file']   = '../../plugins/mambo/mospagebreak.htm'; // Relative to theme
            template['width']  = 270;
            template['height'] = 250;
            var title = "", atext = "", ctext = "";
            tinyMCE.openWindow(template, {editor_id : editor_id, title : title, atext : atext, ctext : ctext, mceDo : 'insert'});
       return true;
   }
   // Pass to next handler in chain
   return false;
}
