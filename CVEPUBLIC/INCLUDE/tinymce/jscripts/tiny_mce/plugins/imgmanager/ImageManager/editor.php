<?php
/**
 * The PHP Image Editor user interface.
 * @author $Author: Wei Zhuo $
 * @version $Id: editor.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */
define( '_VALID_MOS', 1 );

$base_path = "../../../../../../../../";

require_once ($base_path."configuration.php");
require_once($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/auth_plugin.php");
include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/langs/$editor_lang.php");

//Reset auth variables
$isAdmin=False;
$isUser=False;

// Check for access rights

// Check for Admin rights
$isAdmin=checkType('admin');

// Check for User rights
if (!$isAdmin) {
     $isUser=checkType('user');
   }


if ($isAdmin || $isUser) {

//End Authorisation

require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/config.inc.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/ImageManager.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/ImageEditor.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/Functions.php');

$manager = new ImageManager($IMConfig);
$editor = new ImageEditor($manager);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="assets/editor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/slider.js"></script>
<script type="text/javascript" src="assets/popup.js"></script>
<script type="text/javascript">
        window.resizeTo(673, 531);
        if(window.opener)
           I18N = window.opener.I18N;
</script>
<script type="text/javascript" src="assets/editor.js"></script>
</head>
<body>
<div id="indicator">
<img src="img/spacer.gif" id="indicator_image" height="20" width="20" alt="" />
</div>
<div id="tools">
        <div id="tools_crop" style="display:none;">
                <div id="tool_inputs">
                        <label for="cx"><?php echo _imgmanager_startX ?>:</label><input type="text" id="cx"  class="textInput" onchange="updateMarker('crop')"/>
                        <label for="cy"><?php echo _imgmanager_startY ?>:</label><input type="text" id="cy" class="textInput" onchange="updateMarker('crop')"/>
                        <label for="cw"><?php echo _imgmanager_width ?>:</label><input type="text" id="cw" class="textInput" onchange="updateMarker('crop')"/>
                        <label for="ch"><?php echo _imgmanager_height ?>:</label><input type="text" id="ch" class="textInput" onchange="updateMarker('crop')"/>
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                </div>
                <a href="javascript: editor.doSubmit('crop');" class="buttons" title="<?php echo _imgmanager_ok ?>"><img src="img/btn_ok.gif" height="30" width="30" alt="<?php echo _imgmanager_ok ?>" /></a>
                <a href="javascript: editor.reset();" class="buttons" title="<?php echo _imgmanager_cancel ?>"><img src="img/btn_cancel.gif" height="30" width="30" alt="<?php echo _imgmanager_cancel ?>" /></a>
        </div>
        <div id="tools_scale" style="display:none;">
                <div id="tool_inputs">
                        <label for="sw"><?php echo _imgmanager_width ?>:</label><input type="text" id="sw" class="textInput" onchange="checkConstrains('width')"/>
                        <a href="javascript:toggleConstraints();" title="Lock"><img src="img/islocked2.gif" id="scaleConstImg" height="14" width="8" alt="Lock" class="div" /></a><label for="sh"><?php echo _imgmanager_height ?>:</label>
                        <input type="text" id="sh" class="textInput" onchange="checkConstrains('height')"/>
                        <input type="checkbox" id="constProp" value="1" checked="checked" onclick="toggleConstraints()"/>
                        <label for="constProp"><?php echo _imgmanager_constrain ?></label>
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                </div>
                <a href="javascript: editor.doSubmit('scale');" class="buttons" title="<?php echo _imgmanager_ok ?>"><img src="img/btn_ok.gif" height="30" width="30" alt="<?php echo _imgmanager_ok ?>" /></a>
                <a href="javascript: editor.reset();" class="buttons" title="<?php echo _imgmanager_cancel ?>"><img src="img/btn_cancel.gif" height="30" width="30" alt="<?php echo _imgmanager_cancel ?>" /></a>
        </div>
        <div id="tools_rotate" style="display:none;">
                <div id="tool_inputs">
                        <select id="flip" name="flip" style="margin-left: 10px; vertical-align: middle;">
              <option selected><?php echo _imgmanager_flip ?></option>
              <option>-----------------</option>
              <option value="hoz"><?php echo _imgmanager_flipHoriz ?></option>
              <option value="ver"><?php echo _imgmanager_flipVert ?></option>
         </select>
                        <select name="rotate" onchange="rotatePreset(this)" style="margin-left: 20px; vertical-align: middle;">
              <option selected><?php echo _imgmanager_rotate ?></option>
              <option>-----------------</option>

              <option value="180"><?php echo _imgmanager_rotate180 ?></option>
              <option value="90"><?php echo _imgmanager_rotate90CW ?></option>
              <option value="-90"><?php echo _imgmanager_rotate90CCW ?></option>
         </select>
                        <label for="ra"><?php echo _imgmanager_angle ?>:</label><input type="text" id="ra" class="textInput" />
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                </div>
                <a href="javascript: editor.doSubmit('rotate');" class="buttons" title="<?php echo _imgmanager_ok ?>"><img src="img/btn_ok.gif" height="30" width="30" alt="<?php echo _imgmanager_ok ?>" /></a>
                <a href="javascript: editor.reset();" class="buttons" title="<?php echo _imgmanager_cancel ?>"><img src="img/btn_cancel.gif" height="30" width="30" alt="<?php echo _imgmanager_cancel ?>" /></a>
        </div>
        <div id="tools_measure" style="display:none;">
                <div id="tool_inputs">
                        <label>X:</label><input type="text" class="measureStats" id="sx" />
                        <label>Y:</label><input type="text" class="measureStats" id="sy" />
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                        <label>W:</label><input type="text" class="measureStats" id="mw" />
                        <label>H:</label><input type="text" class="measureStats" id="mh" />
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                        <label>A:</label><input type="text" class="measureStats" id="ma" />
                        <label>D:</label><input type="text" class="measureStats" id="md" />
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                        <button type="button" onclick="editor.reset();" ><?php echo _imgmanager_clear ?></button>
                </div>
        </div>
        <div id="tools_save" style="display:none;">
                <div id="tool_inputs">
                        <label for="save_filename"><?php echo _imgmanager_filename ?>:</label><input type="text" id="save_filename" value="<?php echo $editor->getDefaultSaveFile();?>"/>
                        <select name="format" id="save_format" style="margin-left: 10px; vertical-align: middle;" onchange="updateFormat(this)">
            <option value="" selected><?php echo _imgmanager_format ?></option>
            <option value="">---------------------</option>
            <option value="jpeg,85">JPEG High</option>
            <option value="jpeg,60">JPEG Medium</option>
            <option value="jpeg,35">JPEG Low</option>
            <option value="png">PNG</option>
                        <?php if($editor->isGDGIFAble() != -1) { ?>
            <option value="gif">GIF</option>
                        <?php } ?>
         </select>
                        <label><?php echo _imgmanager_quality ?>:</label>
                        <table style="display: inline; vertical-align: middle;" cellpadding="0" cellspacing="0">
                                <tr>
                                <td>
                                        <div id="slidercasing">
                                <div id="slidertrack" style="width:100px"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
            <div id="sliderbar" style="left:85px" onmousedown="captureStart();"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
                        </div>
                                </td>
                                </tr>
                        </table>
                        <input type="text" id="quality" onchange="updateSlider(this.value)" style="width: 2em;" value="85"/>
                        <img src="img/div.gif" height="30" width="2" class="div" alt="|" />
                </div>
                <a href="javascript: editor.doSubmit('save');" class="buttons" title="<?php echo _imgmanager_ok ?>"><img src="img/btn_ok.gif" height="30" width="30" alt="<?php echo _imgmanager_ok ?>" /></a>
                <a href="javascript: editor.reset();" class="buttons" title="<?php echo _imgmanager_cancel ?>"><img src="img/btn_cancel.gif" height="30" width="30" alt="<?php echo _imgmanager_cancel ?>" /></a>
        </div>
</div>
<div id="toolbar">
<a href="javascript:toggle('crop')" id="icon_crop" title="<?php echo _imgmanager_crop ?>"><img src="img/crop.gif" height="20" width="20" alt="<?php echo _imgmanager_crop ?>" /><span><?php echo _imgmanager_crop ?></span></a>
<a href="javascript:toggle('scale')" id="icon_scale" title="<?php echo _imgmanager_resize ?>"><img src="img/scale.gif" height="20" width="20" alt="<?php echo _imgmanager_resize ?>" /><span><?php echo _imgmanager_resize ?></span></a>
<a href="javascript:toggle('rotate')" id="icon_rotate" title="<?php echo _imgmanager_rotate ?>"><img src="img/rotate.gif" height="20" width="20" alt="<?php echo _imgmanager_rotate ?>" /><span><?php echo _imgmanager_rotate ?></span></a>
<a href="javascript:toggle('measure')" id="icon_measure" title="<?php echo _imgmanager_measure ?>"><img src="img/measure.gif" height="20" width="20" alt="<?php echo _imgmanager_measure ?>" /><span><?php echo _imgmanager_measure ?></span></a>
<a href="javascript: toggleMarker();" title="<?php echo _imgmanager_marker ?>"><img id="markerImg" src="img/t_black.gif" height="20" width="20" alt="<?php echo _imgmanager_marker ?>" /><span><?php echo _imgmanager_marker ?></span></a>
<a href="javascript:toggle('save')" id="icon_save" title="<?php echo _imgmanager_save ?>"><img src="img/save.gif" height="20" width="20" alt="<?php echo _imgmanager_save ?>" /><span><?php echo _imgmanager_save ?></span></a>
</div>
<div id="contents">
<iframe src="editorFrame.php?img=<?php if(isset($_GET['img'])) echo rawurlencode($_GET['img']); ?>" name="editor" id="editor"  scrolling="auto" title="Image Editor" frameborder="0"></iframe>
</div>
<div id="bottom"></div>
</body>
</html>
<?php
} else {
die( 'Direct Access to this location is not allowed.' );
}
?>
