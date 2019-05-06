<?php
/***********************************************************************
** Title.........:    Insert File Dialog, File Manager
** Version.......:    1.1
** Authors.......:    Al Rashid <alrashid@klokan.sk>
**                    Xiang Wei ZHUO <wei@zhuo.org>
** Filename......:    insert_file.php
** URL...........:    http://alrashid.klokan.sk/insFile/
** Last changed..:    23 July 2004
***********************************************************************/
define( '_VALID_MOS', 1 );

$base_path = "../../../../../../../../";

//Start Authorisation
//Some includes
require_once ($base_path."configuration.php");
require_once($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/auth_plugin.php");
require($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/flash/InsertFlash/config.inc.php');
include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/flash/langs/$editor_lang.php");
require($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/flash/InsertFlash/functions.php');

//Reset auth variables
$isAdmin=False;
$isUser=False;
$swf_upload_auth=False;
$swf_new_folder_auth=False;
$swf_move_auth=False;
$swf_delete_auth=False;
$swf_rename_auth=False;

// Check for access rights

// Check for Admin rights
$isAdmin=checkType('admin');

// Check for User rights
if (!$isAdmin) {
     $isUser=checkType('user');
     $swf_upload_auth=checkType('SWF_upload');
     $swf_new_folder_auth=checkType('SWF_new_folder');
     $swf_move_auth=checkType('SWF_move');
     $swf_delete_auth=checkType('SWF_delete');
     $swf_rename_auth=checkType('SWF_rename');
   }


if ($isAdmin || $isUser) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
        <head>
        <title><?php echo _swf_insertfile ?></title>
        <?php
                echo '<META HTTP-EQUIV="Pragma" CONTENT="no-cache">'."\n";
                echo '<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">'."\n";
                echo '<META HTTP-EQUIV="Expires" CONTENT="Fri, Oct 24 1976 00:00:00 GMT">'."\n";
                echo '<meta http-equiv="content-language" content="'.$MY_LANG.'" />'."\n";
                echo '<meta http-equiv="Content-Type" content="text/html; charset='.$MY_CHARSET.'" />'."\n";
                echo '<meta name="author" content="AlRashid, www: http://alrashid.klokan.sk; mailto:alrashid@klokan.sk" />'."\n";
//        <script type="text/javascript" src="../../popups/popup.js"></script>
//        <script type="text/javascript" src="../../dialog.js"></script>
        ?>
        <script type="text/javascript" src="js/popup.js"></script>
        <script type="text/javascript" src="js/dialog.js"></script>
        <script language="javascript" src="../../../tiny_mce_popup.js"></script>
        <style type="text/css">

                .title { background: #ddf; color: #000; font-weight: bold; font-size: 120%; padding: 3px 10px; margin-bottom: 10px;
                border-bottom: 1px solid black; letter-spacing: 2px;
                }
        </style>

        <script language="JavaScript" type="text/JavaScript">
        /*<![CDATA[*/
                var preview_window = null;
                var resize_iframe_constant = 150;
                <?php
                if (is_array($MY_DENY_EXTENSIONS)) {
                        echo 'var DenyExtensions = [';
                        foreach($MY_DENY_EXTENSIONS as $value) echo '"'.$value.'", ';
                        echo '""];
                        ';
                }
                if (is_array($MY_ALLOW_EXTENSIONS)) {
                        echo 'var AllowExtensions = [';
                        foreach($MY_ALLOW_EXTENSIONS as $value) echo '"'.$value.'", ';
                        echo '""];
                        ';
                }
                ?>

function init() {
    // modified 2004-11-10 by Michael Keck (me@michaelkeck.de)
    // supporting onclick event to open pop windows
        var formObj = document.forms[0];

        var swffile   = tinyMCE.getWindowArg('swffile');
        var swfwidth  = '' + tinyMCE.getWindowArg('swfwidth');
        var swfheight = '' + tinyMCE.getWindowArg('swfheight');
        var swfalign =  '' + tinyMCE.getWindowArg('swfalign');

        document.getElementById('original_width').value = tinyMCE.getWindowArg('width');
        document.getElementById('original_height').value = tinyMCE.getWindowArg('height');

        formObj.file.value = swffile;
        formObj.swf_width.value  = swfwidth;
        formObj.swf_height.value  = swfheight;
        formObj.align.value = swfalign;

        var selection = document.getElementById('align');
                for(var i = 0; i < selection.length; i++)
                {
                        if(selection.options[i].value == tinyMCE.getWindowArg('swfalign'))
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }

        //formObj.insert.value = tinyMCE.getLang('lang_' + tinyMCE.getWindowArg('mceDo'));
        window.focus();
    }

    function insertFlash() {
        if (window.opener) {
            var formObj = document.forms[0];
            var required = {
                         "file": "You must enter the URL"
                         };
                        for (var i in required) {
                              var el = MM_findObj(i);
                              if (!el.value) {
                              alert(required[i]);
                              el.focus();
                              return false;
                        }
        if (formObj.swf_width.value == "" || formObj.swf_height.value == ""){
                if (!confirm('Accept default height and width (100px X 100px)?')) return false;
                }
       }

        var myPath = fileManager.document.getElementById('form2').elements["path"].value;
                        var fileItems = fileManager.stb.getSelectedItems();
                        var fileItemsLength = fileItems.length;
                        var returnFiles = new Array();

                        for (var i=0; i<fileItemsLength; i++) {
                                        var strId = fileItems[i].getAttribute("id").toString();
                                        var trId = parseInt(strId.substring(1, strId.length));
                                        returnFiles[i] = new Array();
                                        returnFiles[i][0] = fileManager.fileJSArray[trId][0];
                        }

            var html      = '';
            var file      = formObj.file.value;
            var width     = formObj.swf_width.value;
            var height    = formObj.swf_height.value;
            var align     = formObj.align.value;

            if (align == "")
                      align == "";

                        if (width == "")
                                width = 100;

                        if (height == "")
                                height = 100;

            html += ''
                + '<img src="' + (tinyMCE.getParam("theme_href") + "/images/spacer.gif") + '" '
                + 'width="' + width + '" height="' + height + '" align="' + align + '"'
                + 'border="0" alt="' + file + '" title="' + file + '" class="mce_plugin_flash" name="mce_plugin_flash" />';
            tinyMCE.execCommand("mceInsertContent",true,html);
            top.close();
        }
    }

    function onCancel() {
        top.close();
    }

                function changeDir(selection) {
                        changeLoadingStatus('load');
                        var newDir = selection.options[selection.selectedIndex].value;
                        var postForm2 = fileManager.document.getElementById('form2');
                        postForm2.elements["action"].value="changeDir";
                        postForm2.elements["path"].value=newDir;
                        postForm2.submit();
                }

                function goUpDir() {
                        var selection = document.forms[0].path;
                        var dir = selection.options[selection.selectedIndex].value;
                        if(dir != '/'){
                            changeLoadingStatus('load');
                                var postForm2 = fileManager.document.getElementById('form2');
                                postForm2.elements["action"].value="changeDir";
                                postForm2.elements["path"].value=postForm2.elements["uppath"].value;
                                postForm2.submit();
                        }
                }

                function newFolder() {
                        var selection = document.forms[0].path;
                        var path = selection.options[selection.selectedIndex].value;
                        var folder = prompt('<?php echo _swf_newfolder ?>','');
                        if (folder) {
                            changeLoadingStatus('load');
                                var postForm2 = fileManager.document.getElementById('form2');
                                postForm2.elements["action"].value="createFolder";
                                postForm2.elements["file"].value=folder;
                                postForm2.submit();
                        }
                        return false
                }

                function deleteFile() {
                        var folderItems = fileManager.sta.getSelectedItems();
                        var folderItemsLength = folderItems.length;
                        var fileItems = fileManager.stb.getSelectedItems();
                        var fileItemsLength = fileItems.length;
                        var message = "<?php echo _swf_delete ?>";
            if ((folderItemsLength == 0) && (fileItemsLength == 0)) return false;
                        if (folderItemsLength > 0) {
                                message = message + " " + folderItemsLength + " " + "<?php echo _swf_folders ?>";
                        }
                        if (fileItemsLength > 0) {
                                message = message + " " + fileItemsLength + " " + "<?php echo _swf_files ?>";
                        }
                        if (confirm(message+" ?")) {
                                var postForm2 = fileManager.document.getElementById('form2');
                                for (var i=0; i<folderItemsLength; i++) {
                                        var strId = folderItems[i].getAttribute("id").toString();
                                        var trId = parseInt(strId.substring(1, strId.length));
                                           var i_field = fileManager.document.createElement('INPUT');
                                        i_field.type = 'hidden';
                                        i_field.name = 'folders[' + i.toString() + ']';
                                          i_field.value = fileManager.folderJSArray[trId][1];
                                        postForm2.appendChild(i_field);
                                }
                                for (var i=0; i<fileItemsLength; i++) {
                                        var strId = fileItems[i].getAttribute("id").toString();
                                        var trId = parseInt(strId.substring(1, strId.length));
                                           var i_field = fileManager.document.createElement('INPUT');
                                        i_field.type = 'hidden';
                                        i_field.name = 'files[' + i.toString() + ']';
                                          i_field.value = fileManager.fileJSArray[trId][1];
                                        postForm2.appendChild(i_field);
                                }
                                changeLoadingStatus('load');
                                postForm2.elements["action"].value="delete";
                                postForm2.submit();
                        }
                }

                function renameFile() {
                        var folderItems = fileManager.sta.getSelectedItems();
                        var folderItemsLength = folderItems.length;
                        var fileItems = fileManager.stb.getSelectedItems();
                        var fileItemsLength = fileItems.length;
                        var postForm2 = fileManager.document.getElementById('form2');
                        if ((folderItemsLength == 0) && (fileItemsLength == 0)) return false;
                        if (!confirm('<?php echo _swf_renamewarning ?>')) return false;
                        for (var i=0; i<folderItemsLength; i++) {
                                var strId = folderItems[i].getAttribute("id").toString();
                                var trId = parseInt(strId.substring(1, strId.length));
                var newname = prompt('<?php echo _swf_renamefolder ?>', fileManager.folderJSArray[trId][1]);
                                if (!newname) continue;
                                if (!newname == fileManager.folderJSArray[trId][1]) continue;
                                var i_field = fileManager.document.createElement('INPUT');
                                i_field.type = 'hidden';
                                i_field.name = 'folders[' + i.toString() + '][oldname]';
                                  i_field.value = fileManager.folderJSArray[trId][1];
                                postForm2.appendChild(i_field);
                                var ii_field = fileManager.document.createElement('INPUT');
                                ii_field.type = 'hidden';
                                ii_field.name = 'folders[' + i.toString() + '][newname]';
                                  ii_field.value = newname;
                                postForm2.appendChild(ii_field);
                        }
                        for (var i=0; i<fileItemsLength; i++) {
                                var strId = fileItems[i].getAttribute("id").toString();
                                var trId = parseInt(strId.substring(1, strId.length));
                                var        newname = getNewFileName(fileManager.fileJSArray[trId][1]);
                                if (!newname) continue;
                                if (newname == fileManager.fileJSArray[trId][1]) continue;
                                   var i_field = fileManager.document.createElement('INPUT');
                                i_field.type = 'hidden';
                                i_field.name = 'files[' + i.toString() + '][oldname]';
                                  i_field.value = fileManager.fileJSArray[trId][1];
                                postForm2.appendChild(i_field);
                                var ii_field = fileManager.document.createElement('INPUT');
                                ii_field.type = 'hidden';
                                ii_field.name = 'files[' + i.toString() + '][newname]';
                                  ii_field.value = newname;
                                postForm2.appendChild(ii_field);
                        }
                        changeLoadingStatus('load');
                        postForm2.elements["action"].value="rename";
                        postForm2.submit();
                   }

                function moveFile() {
                        var folderItems = fileManager.sta.getSelectedItems();
                        var folderItemsLength = folderItems.length;
                        var fileItems = fileManager.stb.getSelectedItems();
                        var fileItemsLength = fileItems.length;
                        var postForm2 = fileManager.document.getElementById('form2');
                        if ((folderItemsLength == 0) && (fileItemsLength == 0)) return false;
                        if (!confirm('<?php echo _swf_renamewarning ?>')) return false;
                        var postForm2 = fileManager.document.getElementById('form2');
                        Dialog("move.php", function(param) {
                                if (!param) // user must have pressed Cancel
                                        return false;
                                else {
                                    postForm2.elements["newpath"].value=param['newpath'];
                                    moveFiles();
                                }
                        }, null);
                }

        function moveFiles() {
                        var folderItems = fileManager.sta.getSelectedItems();
                        var folderItemsLength = folderItems.length;
                        var fileItems = fileManager.stb.getSelectedItems();
                        var fileItemsLength = fileItems.length;
                        var postForm2 = fileManager.document.getElementById('form2');
                        for (var i=0; i<folderItemsLength; i++) {
                                var strId = folderItems[i].getAttribute("id").toString();
                                var trId = parseInt(strId.substring(1, strId.length));
                                   var i_field = fileManager.document.createElement('INPUT');
                                i_field.type = 'hidden';
                                i_field.name = 'folders[' + i.toString() + ']';
                                  i_field.value = fileManager.folderJSArray[trId][1];
                                postForm2.appendChild(i_field);
                        }
                        for (var i=0; i<fileItemsLength; i++) {
                                var strId = fileItems[i].getAttribute("id").toString();
                                var trId = parseInt(strId.substring(1, strId.length));
                                var i_field = fileManager.document.createElement('INPUT');
                                i_field.type = 'hidden';
                                i_field.name = 'files[' + i.toString() + ']';
                                  i_field.value = fileManager.fileJSArray[trId][1];
                                postForm2.appendChild(i_field);
                        }
                        changeLoadingStatus('load');
                        postForm2.elements["action"].value="move";
                        postForm2.submit();
                }

                function doUpload() {
                        var isOK = 1;
                        var fileObj = document.forms[0].uploadFile;
                        if (fileObj == null) return false;

                        newname = fileObj.value;
                        isOK = checkExtension(newname);
                        if (isOK == -2) {
                                 alert('<?php echo _swf_extnotallowed ?>');
                                 return false;
                        }
                        if (isOK == -1) {
                                alert('<?php echo _swf_extmissing ?>');
                                return false;
                        }
                        changeLoadingStatus('upload');
                }

                function checkExtension(name) {
                        var regexp = /\/|\\/;
                        var parts = name.split(regexp);
                        var filename = parts[parts.length-1].split(".");
                        if (filename.length <= 1) {
                                return(-1);
                        }
                        var ext = filename[filename.length-1].toLowerCase();

                        for (i=0; i<DenyExtensions.length; i++) {
                                if (ext == DenyExtensions[i]) return(-2);
                        }
                        for (i=0; i<AllowExtensions.length; i++) {
                                if (ext == AllowExtensions[i]) return(1);
                        }
                        return(-2);
                }

                function getNewFileName(name) {
                        var isOK = 1;
                        var newname='';
                        do {
                                newname = prompt('<?php echo _swf_renamefile ?>', name);
                                if (!newname) return false;
                                isOK = checkExtension(newname);
                                if (isOK == -2) alert('<?php echo _swf_extnotallowed ?>');
                                if (isOK == -1) alert('<?php echo _swf_extmissing ?>');
                        } while (isOK != 1);
                          return(newname);
                }

                function selectFolder() {
                        Dialog("move.php", function(param) {
                                if (!param) // user must have pressed Cancel
                                        return false;
                                else {
                                        var postForm2 = fileManager.document.getElementById('form2');
                                        postForm2.elements["newpath"].value=param['newpath'];
                                }
                        }, null);

                }

                function refreshPath(){
                        var selection = document.forms[0].path;
                        changeDir(selection);
                }

                function winH() {
                   if (window.innerHeight)
                      return window.innerHeight;
                   else if
                   (document.documentElement &&
                   document.documentElement.clientHeight)
                      return document.documentElement.clientHeight;
                   else if
                   (document.body && document.body.clientHeight)
                      return document.body.clientHeight;
                   else
                      return null;
                }

                function resize_iframe() {
                        document.getElementById("fileManager").height=winH()-resize_iframe_constant;//resize the iframe according to the size of the window
                }

                function MM_findObj(n, d) { //v4.01
                  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                  if(!x && d.getElementById) x=d.getElementById(n); return x;
                }

                function MM_showHideLayers() { //v6.0
                  var i,p,v,obj,args=MM_showHideLayers.arguments;
                  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
                    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
                    obj.visibility=v; }
                }

                function changeLoadingStatus(state) {
                        var statusText = null;
                        if(state == 'load') {
                                statusText = '<?php echo _swf_loading ?> ';
                        }
                        else if(state == 'upload') {
                                statusText = '<?php echo _swf_uploading ?>';
                        }
                        if(statusText != null) {
                                var obj = MM_findObj('loadingStatus');
                                if (obj != null && obj.innerHTML != null)
                                        obj.innerHTML = statusText;
                                MM_showHideLayers('loading','','show')
                        }
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

                                var widthObj = document.getElementById('swf_width');
                                var heightObj = document.getElementById('swf_height');

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
        </script>
</head>
<body onload="init();">
                <form action="files.php?dialogname=<?php echo $MY_NAME; ?>" name="form1" method="post" target="fileManager" enctype="multipart/form-data">
                        <div id="loading" style="position:absolute; left:200px; top:130px; width:184px; height:48px; z-index:1" class="statusLayer">
                                <div id= "loadingStatus" align="center" style="font-size:large;font-weight:bold;color:#CCCCCC;font-family: Helvetica, sans-serif; z-index:2;  ">
                                <?php echo _swf_loading ?>
                                </div>
                        </div>
                          <fieldset>
                                <legend>
                                        <?php
                                        echo _swf_filemanager;
                                        echo '<span style="font-size:x-small; "> - '._swf_ctrlshift.'</span>';
                                        ?>
                                </legend>
                                <div style="margin:5px;">
                                        <label for="path">
                                                <?php echo _swf_directory ?>
                                        </label>
                                          <select name="path" id="path" style="width:35em" onChange="changeDir(this)">
                                                  <option value="/">/</option>
                                        </select>

                                        <?php
                                                echo '<a href="#" onClick="javascript:goUpDir();"><img src="img/btn_up.gif" width="18" height="18" border="0" title="'._swf_up.'" /></a>';
                                                if (($swf_new_folder_auth || $isAdmin) && $MY_ALLOW_CREATE) {
                                                        echo '<a href="#" onClick="javascript:newFolder();"><img src="img/btn_create.gif"  width="18" height="18" border="0" title="'._swf_newfolder.'" /></a>';
                                                }
                                                if (($swf_delete_auth || $isAdmin) && $MY_ALLOW_DELETE) {
                                                        echo '<a href="#" onClick="javascript:deleteFile();"><img src="img/btn_delete.gif" width="18" height="18" border="0" title="'._swf_delete.'" /></a>';
                                                }
                                                if (($swf_rename_auth || $isAdmin) && $MY_ALLOW_RENAME) {
                                                        echo '<a href="#" onClick="javascript:renameFile();"><img src="img/btn_rename.gif" width="18" height="18" border="0" title="'._swf_rename.'" /></a>';
                                                }
                                                if (($swf_move_auth || $isAdmin) && $MY_ALLOW_MOVE) {
                                                        echo '<a href="#" onClick="javascript:moveFile();"><img src="img/btn_move.gif" width="18" height="18" border="0" title="'._swf_move.'" /></a>';
                                                }

                                     ?>

                                                        <input id="sortby" type="hidden" value="0" />
                                </div>

                                <div style="margin:5px;">
                                <!--
                                        <iframe src="files.php?dialogname=<?php echo $MY_NAME; ?>&amp;refresh=1" name="fileManager" id="fileManager" background: Window;" marginwidth="0" marginheight="0" align="top" scrolling="no" frameborder="0" hspace="0" vspace="0" width="100%"></iframe>
                                        -->
                                   <iframe src="files.php?dialogname=<?php echo $MY_NAME; ?>&amp;refresh=1" name="fileManager" id="fileManager" align="center" background="Window" marginwidth="0" marginheight="0" valign:"top" scrolling="no" frameborder="0" hspace="0" vspace="0" width="550px" height="200px" style="background-color: Window; margin:0px; padding:0px; border:0px; vertical-align:top;"></iframe>
                                </div>
                                <table border="0">
                                       <tr>
                                           <td align="left"><label for="filename"><?php echo _swf_filename ?></label></td>
                                           <td align="left"><input name="file" type="text" id="file" size="60" /></td>
                                           <td align="right"><label for="width"><?php echo _swf_width ?></label></td>
                                           <td align="right"><input type="text" id="swf_width" value="" size="5" onchange="javascript:checkConstrains('width');"/></td>
                                           <td rowspan="2" align="right"><img src="img/locked.gif" id="imgLock" width="25" height="32" alt="Constrained Proportions" /></td>
                                       </tr>
                                       <tr>
                                       <?php if (($swf_upload_auth || $isAdmin) && $MY_ALLOW_UPLOAD) { ?>
                                         <td><label for="uploadFile">
                                        <?php echo _swf_upload ?>
                                        </label></td>
                                        <td><input name="uploadFile" type="file" id="uploadFile" size="30" />
                                        <input type="submit" value="<?php echo _swf_upload ?>" onClick="javascript:return doUpload();" /></td>
                                       <?php
                                       }
                                       ?>
                                           <td align="right"><label for="height"><?php echo _swf_height ?></label></td>
                                           <td align="right"><input type="text" id="swf_height" value="" size="5" onchange="javascript:checkConstrains('height');"/></td>
                                       </tr>
                                       <tr>
                                       <td align="left"><label for="align"><?php echo _swf_align ?></label></td>
                                       <td>
                                       <select size="1" id="align"  title="<?php echo _swf_position ?>">
                                       <option value="" selected="selected"         ><?php echo _swf_align_default ?></option>
                                       <option value="left"                         ><?php echo _swf_align_left ?></option>
                                       <option value="right"                        ><?php echo _swf_align_right ?></option>
                                       <option value="texttop"                      ><?php echo _swf_align_texttop ?></option>
                                       <option value="absmiddle"                    ><?php echo _swf_align_absmiddle ?></option>
                                       <option value="baseline"                     ><?php echo _swf_align_baseline ?></option>
                                       <option value="absbottom"                    ><?php echo _swf_align_absbottom ?></option>
                                       <option value="bottom"                       ><?php echo _swf_align_bottom ?></option>
                                       <option value="middle"                       ><?php echo _swf_align_middle ?></option>
                                       <option value="top"                          ><?php echo _swf_align_top ?></option>
                                       </td>

                                           <td align="right">
                                               <input type="hidden" id="original_width" />
                                               <input type="hidden" id="original_height" />
                                               <input type="checkbox" id="constrain_prop" checked="checked" onclick="javascript:toggleConstrains(this);" />
                                           </td>
                                       <td colspan="2" align="left"><label for="constrain_prop"><?php echo _swf_constrain ?></label></td>
                                       </tr>
                                </table>

                    </fieldset>

                         <div style="text-align: right; margin-top:5px;">
                                  <input type="button" class="buttons" value="<?php echo _swf_refresh ?>" onclick="return refreshPath();">
                                  <input type="button" class="buttons" value="<?php echo _swf_ok ?>" onclick="return insertFlash();">
                                  <input type="button" class="buttons" value="<?php echo _swf_cancel ?>" onclick="return onCancel();">

                     </div>
                     <div style="position:absolute; bottom:-5px; right:-3px;">
                                 <img src="img/btn_Corner.gif" width="14" height="14" border="0" alt="" />
                           </div>
                </form>
        </body>
</html>
<?php
}else{
die( 'You are not authorised to view this page.' );
}
?>
