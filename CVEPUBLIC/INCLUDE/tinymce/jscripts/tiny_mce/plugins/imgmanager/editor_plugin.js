/* Import theme specific language pack */
tinyMCE.importPluginLanguagePack('imgmanager', 'en,de,pl');

/**
 * Insert image template function.
 */
function TinyMCE_imgmanager_getInsertImageTemplate() {
    var template = new Array();

    template['file']   = '../../plugins/imgmanager/ImageManager/manager.php';
    template['width']  = 650;
    template['height'] = 560;

    // Language specific width and height addons
    template['width']  += tinyMCE.getLang('lang_insert_image_delta_width', 0);
    template['height'] += tinyMCE.getLang('lang_insert_image_delta_height', 0);

    return template;
}
