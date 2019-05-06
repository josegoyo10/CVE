/**
 * Functions for the Advanced Link, used by link.php and search.html.php
 *@author $Author: Ryan Demmer $
 * @version $Id: link.js 26 200-02-20 Ryan Demmer $
 * @package Advanced Link
 * Some elements by Michael Keck (me@michaelkeck.de)
 */

    function init() {
    // modified 2004-11-10 by Michael Keck (me@michaelkeck.de)
    // supporting onclick event to open pop windows
               for (var i=0; i<document.forms[0].target.options.length; i++) {
                        var option = document.forms[0].target.options[i];

                        if (option.value == tinyMCE.getWindowArg('target'))
                                option.selected = true;
                }
        document.forms[0].href.value = tinyMCE.getWindowArg('href');
        document.forms[0].title.value = tinyMCE.getWindowArg('title');
        document.forms[0].insert.value = tinyMCE.getLang('lang_' + tinyMCE.getWindowArg('action'));
        window.focus();
    }

    function insertLink() {
        if (window.opener) {
            var href = document.forms[0].href.value;
            var target = document.forms[0].target.options[document.forms[0].target.selectedIndex].value;
            var title = document.forms[0].title.value;
            window.opener.tinyMCE.insertLink(href, target, title);
                        top.close();
        }
    }

    function cancelAction() {
        top.close();
    }

        function UpdateProtocol() {

        var selectedItem              = document.forms[0].formProt.selectedIndex;
        var selectedItemValue         = document.forms[0].formProt.options[selectedItem].value;

        document.forms[0].href.value = selectedItemValue;

        }

    function SearchLink(searchlink)
        {
                var topDoc = window.top.document;
                var formObj = window.top.document.forms[0];

                var obj = topDoc.getElementById('href');  obj.value = searchlink;
        }
