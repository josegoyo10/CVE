/* Import theme	specific language pack */
tinyMCE.importPluginLanguagePack('word', 'en,de,pl');

function TinyMCE_word_getControlHTML(control_name)	{
	switch (control_name) {
		case "word":
			return '<img id="{$editor_id}_word" src="{$pluginurl}/images/word.gif" title="{$lang_word_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceWord\',true);" />';
	}

	return "";
}

/**
 * Executes	the	Word Clean commands.
 */
function TinyMCE_word_execCommand(editor_id, element, command,	user_interface,	value) {
	// Handle commands
	switch (command) {
		case "mceWord":

        var	html = tinyMCE.getContent();
			
        // Cleanup madness that breaks the editor in MSIE
        if (tinyMCE.isMSIE)
                element.innerHTML = tinyMCE.regexpReplace(element.innerHTML, '<!([^-(DOCTYPE)]* )|<!/[^-]*>', '', 'gi');

        // Remove pesky HR paragraphs
        html = tinyMCE.regexpReplace(html, '<p><hr /></p>', '<hr />');
        html = tinyMCE.regexpReplace(html, '<p>&nbsp;</p><hr /><p>&nbsp;</p>', '<hr />');

        // Remove some undesirable Word formatting
                html = html.replace(new RegExp('<(font)([^>]*)>', 'g'), "");
                html = html.replace(new RegExp('</font>', 'g'), "");
                html = html.replace(new RegExp('</span>', 'g'), "");
                html = html.replace(new RegExp('<(span)([^>]*)>', 'g'), "");
                html = html.replace(new RegExp('<(!--)([^>]*)>', 'g'), "");
                html = html.replace(new RegExp('<(div class="Mso)([^>]*)>', 'g'), "<div>");
                html = html.replace(new RegExp('<(p class="Mso)([^>]*)>', 'g'), "<p>");
                
        if (tinyMCE.settings['apply_source_formatting']) {
                html = html.replace(new RegExp('<(p|div)([^>]*)>', 'g'), "\n<$1$2>\n");
                html = html.replace(new RegExp('<\/(p|div)([^>]*)>', 'g'), "\n</$1$2>\n");
                html = html.replace(new RegExp('<br />', 'g'), "<br />\n");
        }

        if (!tinyMCE.settings['force_p_newlines']) {
                var re = new RegExp('<p>&nbsp;</p>', 'g');
                html = html.replace(re, "<br /><br />");
        }

        if (!tinyMCE.isMSIE && !tinyMCE.settings['force_p_newlines']) {
                html = html.replace(new RegExp('<(p)([^>]*)>', 'g'), "");
                html = html.replace(new RegExp('<p></p>', 'g'), "<br /><br />");
        }

        if (tinyMCE.settings['force_p_newlines']) {
                // Remove weridness!
                var re = new RegExp('&lt;&gt;', 'g');
                html = html.replace(re, "");
        }

        // Emtpy node, return empty
        if (html == "<br />" || html == "<p>&nbsp;</p>")
                html = "";

        tinyMCE.execCommand("mceAddUndoLevel");
        tinyMCE.setContent(html);

            return true;
	}

	// Pass to next handler in chain
	return false;
}
