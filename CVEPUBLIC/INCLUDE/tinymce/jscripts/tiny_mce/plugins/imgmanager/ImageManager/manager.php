<?php
/**
 * The main GUI for the ImageManager.
 * Modifications for Mambo TinyMCE - Ryan Demmer Dec 2004
 * Portions from remository.php
 * @author $Author: Wei Zhuo $
 * @version $Id: manager.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */
define( '_VALID_MOS', 1 );

$base_path = "../../../../../../../../";

//Start Authorisation
//Some includes

require_once ($base_path."configuration.php");
require_once($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/auth_plugin.php");
include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/langs/$editor_lang.php");

//Reset auth variables
$isAdmin=False;
$isUser=False;
$upload_auth=False;
$new_folder_auth=False;

//Check for access rights

//Check for Admin rights
$isAdmin=checkType('admin');

//Check for User rights
if (!$isAdmin) {
     $isUser=checkType('user');
     $upload_auth=checkType('IM_upload');
     $new_folder_auth=checkType('IM_new_folder');
   }
if ($isAdmin || $isUser) {

//End Authorisation

require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/config.inc.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/ImageManager.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/Functions.php');


$manager = new ImageManager($IMConfig);
$dirs = $manager->getDirs();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <title><?php echo _imgmanager_desc ?></title>
     <meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
     <meta http-equiv="Pragma" content="no-cache" />
     <meta http-equiv="Cache-Control" content="no-cache" />
     <meta http-equiv="Expires" content="Fri, Oct 24 1976 00:00:00 GMT" />
     <link href="assets/manager.css" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="assets/popup.js">
     </script>
     <script type="text/javascript" src="assets/dialog.js">
     </script>
     <script language="javascript" src="../../../tiny_mce_popup.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     /*<![CDATA[*/
        var thumbdir = "<?php echo $IMConfig['thumbnail_dir']; ?>";
        var base_url = "<?php echo $manager->getBaseURL(); ?>";
        var hostUrl = "<?php echo $mosConfig_live_site; ?>";
        var defVSpace = "<?php echo $editor_im_def_vspace; ?>";
        var defHSpace = "<?php echo $editor_im_def_hspace; ?>";
        var defBorder = "<?php echo $editor_im_def_border; ?>";
        var editor_im_thumbs = "<?php echo $editor_im_thumbs; ?>";
     /*]]>*/
     </script>
     <script type="text/javascript">
     /**
     * Javascript Functions for the ImageManager
     */
        function myRegexpReplace(in_str, reg_exp, replace_str, opts) {
        if (typeof opts == "undefined")
            opts = 'g';
        var re = new RegExp(reg_exp, opts);
        return in_str.replace(re, replace_str);
        }
        //set the alignment options
        function setAlign(align)
        {
                var selection = document.getElementById('f_align');
                for(var i = 0; i < selection.length; i++)
                {
                        if(selection.options[i].value == align)
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }
        }
        //initialise the form
        //Added modifications for TinyMCE - Ryan Demmer
        init = function ()
        {
                var arrOnOver = new Array(), arrOnOut  = new Array();
                var strOnOver = "", strOnOut  = "";
                var formObj = document.forms[0];
                var uploadForm = document.getElementById('uploadForm');
                if(uploadForm) uploadForm.target = 'imgManager';
                
                var selection = document.getElementById('f_align');
                for(var i = 0; i < selection.length; i++)
                {
                        if(selection.options[i].value == tinyMCE.getWindowArg('align'))
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }
                document.getElementById('f_url').value = tinyMCE.getWindowArg('src');
                document.getElementById('f_alt').value = tinyMCE.getWindowArg('alt');
                document.getElementById('f_width').value = tinyMCE.getWindowArg('width');
                document.getElementById('f_height').value = tinyMCE.getWindowArg('height');
                if (tinyMCE.getWindowArg('border') == ''){
                    document.getElementById('f_border').value = defBorder;
                }else{
                    document.getElementById('f_border').value = tinyMCE.getWindowArg('border');
                }
                if (tinyMCE.getWindowArg('vspace') == ''){
                    document.getElementById('f_vert').value = defVSpace;
                }else{
                    document.getElementById('f_vert').value = tinyMCE.getWindowArg('vspace');
                }
                if (tinyMCE.getWindowArg('hspace') == ''){
                    document.getElementById('f_horiz').value = defHSpace;
                }else{
                    document.getElementById('f_horiz').value = tinyMCE.getWindowArg('hspace');
                }
                document.getElementById('original_width').value = tinyMCE.getWindowArg('width');
                document.getElementById('original_height').value = tinyMCE.getWindowArg('height');
                
                // supporting onmouse over / out for image swap ...Michael Keck (me@michaelkeck.de)
                arrOnOver = tinyMCE.getWindowArg('onmouseover').split(';');
                arrOnOut = tinyMCE.getWindowArg('onmouseout').split(';');
                for (var i=0; i<arrOnOver.length; i++) {
                if (arrOnOver[i].indexOf('this.src=\'')!=-1) {
                    strOnOver = arrOnOver[i];
                    break;
                    }
                }
                for (var i=0; i<arrOnOut.length; i++) {
                     if (arrOnOut[i].indexOf('this.src=\'')!=-1) {
                     strOnOut = arrOnOut[i];
                     break;
                     }
                }
                if (strOnOver!='') {
                    strOnOver = myRegexpReplace(strOnOver,"this.src='","","gi");
                    strOnOver = myRegexpReplace(strOnOver,"'","","gi");
                    strOnOver = myRegexpReplace(strOnOver,";","","gi");
                }
                if (strOnOut!='') {
                    strOnOut = myRegexpReplace(strOnOut,"this.src='","","gi");
                    strOnOut = myRegexpReplace(strOnOut,"'","","gi");
                    strOnOut = myRegexpReplace(strOnOut,";","","gi");
                }
                if (strOnOver!='' && strOnOut!='') {
                    setOnMouseInput('enabled');
                    formObj.onmousemove.checked = true;
                    formObj.onmouseover.value   = strOnOver;
                    formObj.onmouseout.value    = strOnOut;
                } else {
                setOnMouseInput('disabled');
                formObj.onmousemove.checked = false;
                formObj.onmouseover.value   = '';
                formObj.onmouseout.value    = '';
                }
                setPopupImage('disabled');
                formObj.popupenable.checked = false;
                formObj.popupthumb.value   = '';
                formObj.thumbcaption.checked = false;
                
                if (editor_im_thumbs == 'false')
                {
                  formObj.popupenable.disabled = true;
                  formObj.thumbcaption.disabled = true;
                }

                window.focus();
        }
        //Added modifications for TinyMCE - Ryan Demmer
        function onCancel()
        {
                top.close();
                return false;
        };
        // supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
        // this function is needed for visual show, if onmouse over/out available
            function setOnMouseInput(stat){
                var formObj = document.forms[0];
                if (stat=='enabled') {
                    formObj.onmouseover.disabled = false;
                    formObj.onmouseout.disabled  = false;
                    formObj.popupenable.disabled = true;
                    formObj.thumbcaption.disabled = true;

                    if (document.getElementById) {
                        document.getElementById('showInput1').style.color="#000000";
                        document.getElementById('showInput2').style.color="#000000";
                        document.getElementById('showInput5').style.color="#000000";
                    }
                    formObj.onmouseout.value     = document.getElementById('f_url').value;
                } else {
                    formObj.onmouseover.disabled = true;
                    formObj.onmouseout.disabled  =true;
                    if (editor_im_thumbs == 'true'){
                        formObj.popupenable.disabled = false;
                        formObj.thumbcaption.disabled = false;
                    }
                    if (document.getElementById) {
                        document.getElementById('showInput1').style.color="#666666";
                        document.getElementById('showInput2').style.color="#666666";
                        document.getElementById('showInput5').style.color="#666666";
                    }
                }
            }
        // supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
        // this function is needed for visual show, if onmouse over/out available
            function setPopupImage(stat){
                var formObj = document.forms[0];
                if (stat=='enabled') {
                    formObj.popupthumb.disabled = false;
                    formObj.thumbcaption.disabled = false;
                    formObj.onmousemove.disabled = true;
                    formObj.onmouseheight.disabled = true;
                    formObj.onmousewidth.disabled = true;
                    if (document.getElementById) {
                        document.getElementById('showInput3').style.color="#000000";
                        document.getElementById('showInput4').style.color="#000000";
                        document.getElementById('showInput6').style.color="#000000";
                    }
                } else {
                    formObj.popupthumb.disabled = true;
                    formObj.onmousemove.disabled = false;
                    formObj.onmouseheight.disabled = false;
                    formObj.onmousewidth.disabled = false;
                    if (document.getElementById) {
                        document.getElementById('showInput3').style.color="#666666";
                        document.getElementById('showInput4').style.color="#666666";
                        document.getElementById('showInput6').style.color="#666666";
                    }
                }
            }
                //Added modifications for TinyMCE - Ryan Demmer
                //Added Mouseover and Popup functionality - Ryan Demmer Feb 2005
                function onOK()
                {
                var required = {
                                 "f_url": "Please enter a URL, choose an image or Cancel"
                                 };
                                for (var i in required) {
                                      var el = MM_findObj(i);
                                      if (!el.value) {
                                      alert(required[i]);
                                      el.focus();
                                      return false;
                                }
                }
                          if (window.opener) {
                              if (document.getElementById("popupthumb").disabled == false && editor_im_thumbs == 'true'){

                                var thumbSrc    = document.getElementById("popupthumb").value;
                                var popupSrc = document.getElementById("f_url").value;
                                var popupWidth = document.getElementById("f_width").value;
                                var popupHeight = document.getElementById("f_height").value;
                                var popupName = document.getElementById("f_alt").value;
                                var popupAlign = document.getElementById('f_align').options[document.getElementById('f_align').selectedIndex].value;
                                var popupVspace = document.getElementById("f_vert").value;
                                var popupHspace = document.getElementById("f_horiz").value;
                                var popupBorder = document.getElementById("f_border").value;
                                var popupSrcShort = popupSrc.replace(hostUrl+'/', '', 'gi');

        						var popupClose =  document.getElementById("popupClose").value;
                                var thumbWidth = document.getElementById("thumbWidth").value;
                                var thumbHeight = document.getElementById("thumbHeight").value;

                                if (document.getElementById("thumbcaption").checked == true){
                                    html = '<table border="0" align="'+popupAlign+'" cellspacing="1" cellpadding="1"><tr><td><div align="center">';
                                    html += '<a href="javascript:void window.open(';
                                    html += "'" + hostUrl + "/mambots/editors/tinymce_exp/jscripts/tiny_mce/popupImage.php?img=";
                                    html += "" + popupSrcShort + "";
                                    html += '&imgwidth=';
                                    html += "" + popupWidth + "";
                                    html += '&imgheight=';
                                    html += "" + popupHeight + "";
                                    html += '&alt=';
                                    html += "" + popupName + "',";
                                    html += "'Image',";
                                    html += "'menubar=no,toolbar=no,scrollbars=yes,resizable=yes, left='+(screen.availWidth/2-(" + popupWidth + "/2))+',top='+(screen.availHeight/2-(" + popupHeight + "/2))+',width='+(" + popupWidth + "+10)+',height='+(" + popupHeight + "+75)+'');";
                                    html += '">';
                                    html += '<img src="'+thumbSrc+'" border="'+popupBorder+'" align="'+popupAlign+'" vspace="'+popupVspace+'" hspace="'+popupHspace+'" alt="'+popupName+'" width="'+thumbWidth+'" height="'+thumbHeight+'" /></a></div>';
                                    html += '</td></tr><tr><td><div align="center">'+popupName+'</div></td></tr></table>';
                               }else{
                                    html = '<a href="javascript:void window.open(';
                                    html += "'" + hostUrl + "/mambots/editors/tinymce_exp/jscripts/tiny_mce/popupImage.php?img=";
                                    html += "" + popupSrcShort + "";
                                    html += '&imgwidth=';
                                    html += "" + popupWidth + "";
                                    html += '&imgheight=';
                                    html += "" + popupHeight + "";
                                    html += '&alt=';
                                    html += "" + popupName + "',";
                                    html += "'Image',";
                                    html += "'menubar=no,toolbar=no,scrollbars=yes,resizable=yes, left='+(screen.availWidth/2-(" + popupWidth + "/2))+',top='+(screen.availHeight/2-(" + popupHeight + "/2))+',width='+(" + popupWidth + "+10)+',height='+(" + popupHeight + "+75)+'');";
                                    html += '">';
                                    html += '<img src="' +thumbSrc+ '" border="'+popupBorder+'" align="'+popupAlign+'" vspace="'+popupVspace+'" hspace="'+popupHspace+'" alt="'+popupName+'" width="'+thumbWidth+'" height="'+thumbHeight+'" /></a>';
                               }

                              }else{
                                var src    = document.getElementById("f_url").value;
                                var width = document.getElementById("f_width").value;
                                var height = document.getElementById("f_height").value;
                              }

                              var alt    = document.getElementById("f_alt").value;
                              var title  = document.getElementById("f_alt").value;
                              var border = document.getElementById("f_border").value;
                              var vspace = document.getElementById("f_vert").value;
                              var hspace = document.getElementById("f_horiz").value;
                              var align = document.getElementById('f_align').options[document.getElementById('f_align').selectedIndex].value;
                              var onmouseover = document.forms[0].onmouseover.value;
                              var onmouseout  = document.forms[0].onmouseout.value;

                              // supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
                              // only support the onmouse over/out if both values are given
                              if (onmouseover!='' && onmouseout!='' && document.forms[0].onmousemove.checked==true) {
                              onmouseover="this.src='" + onmouseover + "';";
                              onmouseout ="this.src='" + onmouseout + "';";
                              if (document.forms[0].onmousewidth.checked==false){
                                  width="";
                                }
                                if (document.forms[0].onmouseheight.checked==false){
                                  height="";
                                }
                              } else {
                                onmouseover="";
                                onmouseout ="";
                              }

                              if (document.getElementById("popupenable").checked == true){
                                  tinyMCE.execCommand("mceInsertContent",true,html);
                                  top.close();
                              }else{
                                    window.opener.tinyMCE.insertImage(src, alt, border, hspace, vspace, width, height, align, title, onmouseover, onmouseout);
                                    top.close();
                              }

                    }

                };
                function MM_findObj(n, d) { //v4.01
                          var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                          if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                          for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                          if(!x && d.getElementById) x=d.getElementById(n); return x;
                        }
                //similar to the Files::makeFile() in Files.php
                function makeURL(pathA, pathB)
                {
                        if(pathA.substring(pathA.length-1) != '/')
                                pathA += '/';

                        if(pathB.charAt(0) == '/');
                                pathB = pathB.substring(1);

                        return pathA+pathB;
                }
                function updateDir(selection)
                {
                        var newDir = selection.options[selection.selectedIndex].value;
                        changeDir(newDir);
                }
                function goUpDir()
                {
                        var selection = document.getElementById('dirPath');
                        var currentDir = selection.options[selection.selectedIndex].text;
                        if(currentDir.length < 2)
                                return false;
                        var dirs = currentDir.split('/');

                        var search = '';

                        for(var i = 0; i < dirs.length - 2; i++)
                        {
                                search += dirs[i]+'/';
                        }

                        for(var i = 0; i < selection.length; i++)
                        {
                                var thisDir = selection.options[i].text;
                                if(thisDir == search)
                                {
                                        selection.selectedIndex = i;
                                        var newDir = selection.options[i].value;
                                        changeDir(newDir);
                                        break;
                                }
                        }
                }
                function changeDir(newDir)
                {
                        if(typeof imgManager != 'undefined')
                                imgManager.changeDir(newDir);
                }
                function toggleConstrains(constrains)
                {
                        var lockImage = document.getElementById('imgLock');
                        var constrains = document.getElementById('constrain_prop');

                        if(constrains.checked)
                        {
                                lockImage.src = "img/locked.gif";
                                checkConstrains('width')
                        }
                        else
                        {
                                lockImage.src = "img/unlocked.gif";
                        }
                }
                function checkConstrains(changed)
                {
                        //alert(document.form1.constrain_prop);
                        var constrains = document.getElementById('constrain_prop');

                        if(constrains.checked)
                        {
                                var obj = document.getElementById('original_width');
                                var original_width = parseInt(obj.value);
                                var obj = document.getElementById('original_height');
                                var original_height = parseInt(obj.value);

                                var widthObj = document.getElementById('f_width');
                                var heightObj = document.getElementById('f_height');

                                var width = parseInt(widthObj.value);
                                var height = parseInt(heightObj.value);

                                if(original_width > 0 && original_height > 0)
                                {
                                        if(changed == 'width' && width > 0) {
                                                heightObj.value = parseInt((width/original_width)*original_height);
                                        }

                                        if(changed == 'height' && height > 0) {
                                                widthObj.value = parseInt((height/original_height)*original_width);
                                        }
                                }
                        }
                }
                function showMessage(newMessage)
                {
                        var message = document.getElementById('message');
                        var messages = document.getElementById('messages');
                        if(message.firstChild)
                                message.removeChild(message.firstChild);

                        message.appendChild(document.createTextNode(newMessage));

                        messages.style.display = "block";
                }
                function addEvent(obj, evType, fn)
                {
                        if (obj.addEventListener) { obj.addEventListener(evType, fn, true); return true; }
                        else if (obj.attachEvent) {  var r = obj.attachEvent("on"+evType, fn);  return r;  }
                        else {  return false; }
                }
                function doUpload()
                {

                        var uploadForm = document.getElementById('uploadForm');
                        if(uploadForm)
                                showMessage('Uploading');
                }
                function refresh()
                {
                        var selection = document.getElementById('dirPath');
                        updateDir(selection);
                }
                function newFolder()
                {
                        var selection = document.getElementById('dirPath');
                        var dir = selection.options[selection.selectedIndex].value;

                        Dialog("newFolder.html", function(param)
                        {
                                if (!param) // user must have pressed Cancel
                                        return false;
                                else
                                {
                                        var folder = param['f_foldername'];
                                        if(folder == thumbdir)
                                        {
                                                alert('Invalid folder name, please choose another folder name.');
                                                return false;
                                        }

                                        if (folder && folder != '' && typeof imgManager != 'undefined')
                                                imgManager.newFolder(dir, encodeURI(folder));
                                }
                        }, null);
                }
                addEvent(window, 'load', init);
     //End Javascript Functions
     </script>
     <style type="text/css">
     .option {
     background-color: #E0E0DE;
     align: middle;
     }
     .standard {
     align: middle;
     }
     </style>
</head>
<body onload="window.focus();init();">
     <form action="images.php" id="uploadForm" method="post" enctype="multipart/form-data">
          <fieldset>
               <legend><strong><?php echo _imgmanager_desc ?></strong></legend>

               <div class="dirs">
                    <label for="dirPath"><?php echo _imgmanager_dir ?></label> <select name="dir" class="dirWidth" id="dirPath" onchange="updateDir(this)">
                         <option value="/">
                              /
                         </option><?php foreach($dirs as $relative=>$fullpath) { ?>

                         <option value="<?php echo rawurlencode($relative); ?>">
                              <?php echo $relative; ?>
                         </option><?php } ?>
                    </select> <a href="#" onclick="javascript: goUpDir();" title="<?php echo _imgmanager_dirUp ?>"><img src="img/btnFolderUp.gif" height="15" width="15" alt="<?php echo _imgmanager_dirUp ?>" /></a> <!-- Added by Ryan Demmer - Dec 2004. Auth and option check -->
                     <?php if(($new_folder_auth || $isAdmin) && $editor_im_folder && $IMConfig['safe_mode'] == false){?> <a href="#" onclick="newFolder();" title="<?php echo _imgmanager_newFolder ?>"><img src="img/btnFolderNew.gif" height="15" width="15" alt="<?php echo _imgmanager_newFolder ?>" /></a> <?php }?>

                    <div id="messages" style="display: none;">
                         <span id="message"></span><img src="img/dots.gif" width="22" height="12" alt="..." />
                    </div><iframe src="images.php" name="imgManager" id="imgManager" class="imageFrame" scrolling="auto" title="<?php echo _imgmanager_imageSel ?>" frameborder="0"></iframe>
               </div>
          </fieldset><!-- image properties -->
          <fieldset>
               <legend><?php echo _imgmanager_properties ?></legend>

               <div align="center">
                    <table border="0" summary="Image Properties">
                         <tr>
                              <td align="right" nowrap="nowrap"><label for="f_url"><?php echo _imgmanager_image ?></label></td>
                              <td><input type="text" id="f_url" class="largelWidth" value="" /></td>
                              <td rowspan="3" align="right">&nbsp;</td>
                              <td align="right"><label for="f_width"><?php echo _imgmanager_width ?></label></td>
                              <td><input type="text" id="f_width" class="smallWidth" value="" onchange="javascript:checkConstrains('width');" /></td>
                              <td rowspan="2" align="right"><img src="img/locked.gif" id="imgLock" width="25" height="32" alt="<?php echo _imgmanager_constrain ?>" /></td>
                              <td rowspan="3" align="right">&nbsp;</td>
                              <td align="right"><label for="f_vert"><?php echo _imgmanager_vspace ?></label></td>
                              <td><input type="text" id="f_vert" class="smallWidth" value="" /></td>
                         </tr>
                         <tr>
                              <td align="right"><label for="f_alt"><?php echo _imgmanager_alt2 ?></label></td>
                              <td><input type="text" id="f_alt" class="largelWidth" value="" /></td>
                              <td align="right"><label for="f_height"><?php echo _imgmanager_height ?></label></td>
                              <td><input type="text" id="f_height" class="smallWidth" value="" onchange="javascript:checkConstrains('height');" /></td>
                              <td align="right"><label for="f_horiz"><?php echo _imgmanager_hspace ?></label></td>

                              <td><input type="text" id="f_horiz" class="smallWidth" value="" /></td>
                         </tr><!-- Added by Ryan Demmer - Dec 2004. Auth and option check -->
                         <?php if(($upload_auth || $isAdmin) && $editor_im_upload){?>

                         <tr>
                              <td colspan="2"><input type="file" name="upload" id="upload" size="20" /> &nbsp;<input type="submit" name="submit" value="<?php echo _imgmanager_upload ?>" onclick="doUpload();" /></td><?php } else {?>
                              <td colspan="2"></td><?php }?>
                              <td align="right"><label for="f_align"><?php echo _imgmanager_align ?></label></td>
                              <td colspan="2"><select size="1" id="f_align" title="<?php echo _imgmanager_align_desc ?>">
                                   <option value="">
                                        <?php echo _imgmanager_align_default ?>
                                   </option>

                                   <option value="baseline">
                                        <?php echo _imgmanager_align_baseline ?>
                                   </option>

                                   <option value="top">
                                        <?php echo _imgmanager_align_top ?>
                                   </option>

                                   <option value="middle">
                                        <?php echo _imgmanager_align_middle ?>
                                   </option>

                                   <option value="bottom">
                                        <?php echo _imgmanager_align_bottom ?>
                                   </option>

                                   <option value="texttop">
                                        <?php echo _imgmanager_align_texttop ?>
                                   </option>

                                   <option value="absmiddle">
                                        <?php echo _imgmanager_align_absmiddle ?>
                                   </option>

                                   <option value="absbottom">
                                        <?php echo _imgmanager_align_absbottom ?>
                                   </option>

                                   <option value="left">
                                        <?php echo _imgmanager_align_left ?>
                                   </option>

                                   <option value="right">
                                        <?php echo _imgmanager_align_right ?>
                                   </option>
                              </select></td>

                              <td align="right"><label for="f_border"><?php echo _imgmanager_border ?></label></td>
                              <td><input type="text" id="f_border" class="smallWidth" value="" /></td>
                         </tr>

                         <tr>
                              <!-- Added by Ryan Demmer - Dec 2004. Auth and option check -->
                              <?php if(($upload_auth || $isAdmin) && $editor_im_upload){?>

                              <td colspan="4"><label for="resize"><?php echo _imgmanager_resize_upload ?></label> <input type="checkbox" name="resize" id="resize" onclick="if(this.checked==true){document.getElementById('max_width').disabled=false, document.getElementById('max_height').disabled=false; }else {if(this.checked==false){document.getElementById('max_width').disabled=true, document.getElementById('max_height').disabled=true;}};" /> <label for="max_width"><?php echo _imgmanager_maxwidth ?>:</label> <input type="text" name="max_width" id="max_width" value="<?php echo $editor_im_max_width ?>" size="5" disabled="disabled" onchange="document.getElementById('max_height').value = this.value;" /> <label for="max_height"><?php echo _imgmanager_maxheight ?>:</label> <input type="text" name="max_height" id="max_height" value="<?php echo $editor_im_max_height ?>" size="5" disabled="disabled" onchange="document.getElementById('max_width').value = this.value;" /></td><?php } else {?>
                              <td colspan="3"></td><?php }?>
                              <td colspan="4" align="right"><label for="constrain_prop"><?php echo _imgmanager_constrain ?></label></td>
                              <td align="left"><input type="hidden" id="original_width" /> <input type="hidden" id="original_height" /> <input type="checkbox" id="constrain_prop" checked="checked" onclick="javascript:toggleConstrains(this);" /></td>
                         </tr>
                    </table>
               </div>
          </fieldset>
          <fieldset>
               <legend><?php echo _imgmanager_options ?></legend>
               <div align="center">
                    <input type="hidden" name="popupClose" id="popupClose" value="<?php echo $editor_im_popup_close ?>" />
                    <table border="0" summary="Image Options">
                         <tr>
                              <td colspan="2" class="option"><input type="checkbox" name="onmousemove" id="onmousemove" style="border: 1px none #000000; background-color: transparent; vertical-align: middle;" onclick="if(this.checked==true){ setOnMouseInput('enabled'); }else{ setOnMouseInput('enable'); }" /><label for="onmousemove"><b><?php echo _imgmanager_onmousemove ?></b>:</label></td>
                              <td class="option"><input type="checkbox" name="popupenable" id="popupenable" style="border: 1px none #000000; background-color: transparent; vertical-align: middle;" onclick="if(this.checked==true){ setPopupImage('enabled'); }else{ setPopupImage('enable'); }" /><label for="popenable"><b><?php echo _imgmanager_thumbPopup ?></b>:</label></td>
                         </tr>
                         <tr>
                              <td colspan="2" id="showInput2" class="option"><input type="checkbox" name="onmousewidth" id="onmousewidth" style="border: 1px none #000000; background-color: transparent; vertical-align: middle;" /><label for="onmousemove"><?php echo _imgmanager_includeWidth ?></label> <input type="checkbox" name="onmouseheight" id="onmouseheight" style="border: 1px none #000000; background-color: transparent; vertical-align: middle;" /><label for="onmousemove"><?php echo _imgmanager_includeHeight ?></label></td>
                              <td nowrap="nowrap" id="showInput3" class="option"><?php echo _imgmanager_popupThumb ?>: <input name="popupthumb" type="text" id="popupthumb" value="" style="width: 160px" /></td>
                         </tr>
                         <tr>
                              <td nowrap="nowrap" id="showInput1" class="option"><?php echo _imgmanager_mouseover ?>:</td>
                              <td class="option"><input name="onmouseover" type="text" id="onmouseover" value="" style="width: 180px" /></td>
                              <td nowrap="nowrap" id="showInput4" class="option"><?php echo _imgmanager_width ?>:<input type="text" name="thumbWidth" id="thumbWidth" value="" size="5" disabled="disabled" /> <?php echo _imgmanager_height ?>:<input type="text" name="thumbHeight" id="thumbHeight" value="" size="5" disabled="disabled" /></td>
                         </tr>
                         <tr>
                              <td nowrap="nowrap" id="showInput5" class="option"><?php echo _imgmanager_mouseout ?>:</td>
                              <td class="option"><input name="onmouseout" type="text" id="onmouseout" value="" style="width: 180px" /></td>
                              <td nowrap="nowrap" id="showInput6" class="option"><input name="thumbcaption" type="checkbox" id="thumbcaption" value="" style="border: 1px none #000000; background-color: transparent; vertical-align: middle;" /><label for="thumbcaption"><?php echo _imgmanager_thumbCaption ?></label></td>
                         </tr>
                    </table>
               </div>
          </fieldset><!--// image properties -->
          <div style="text-align: right;">
               <hr />
               <input type="button" class="buttons" value="<?php echo _imgmanager_refresh ?>" onclick="return refresh();" /> <input type="reset" class="buttons" value="<?php echo _imgmanager_reset ?>" /> <input type="button" class="buttons" value="<?php echo _imgmanager_ok ?>" onclick="return onOK();" /> <input type="button" class="buttons" value="<?php echo _imgmanager_cancel ?>" onclick="return onCancel();" />
          </div>
     </form><?php
          }else{
          die( 'You are not authorised to view this page.' );
          }
          ?>
</body>
</html>
