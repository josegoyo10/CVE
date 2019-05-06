<?php
/**
 * Show a list of images in a long horizontal table.
 * Modified for TinyMCE - Ryan Demmer Dec 2004
 * Portions from remository.php
 * @author $Author: Wei Zhuo $
 * @version $Id: images.php 27 2004-04-01 08:31:57Z Wei Zhuo $
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
$upload_auth=False;
$new_folder_auth=False;

// Check for access rights

// Check for Admin rights
$isAdmin=checkType('admin');

// Check for User rights
if (!$isAdmin) {
     $isUser=checkType('user');
     $image_delete_auth=checkType('IM_image_delete');
     $image_edit_auth=checkType('IM_image_edit');
     $folder_delete_auth=checkType('IM_folder_delete');
   }

if ($isAdmin || $isUser) {

//End Authorisation

require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/config.inc.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/ImageManager.php');
require_once($mosConfig_absolute_path.'/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/Functions.php');

//default path is /
$relative = '/';
$manager = new ImageManager($IMConfig);

//process any file uploads
$manager->processUploads();

$manager->deleteFiles();

$refreshDir = false;
//process any directory functions
if($manager->deleteDirs() || $manager->processNewDir())
        $refreshDir = true;

//check for any sub-directory request
//check that the requested sub-directory exists
//and valid
if(isset($_REQUEST['dir']))
{
        $path = rawurldecode($_REQUEST['dir']);
        if($manager->validRelativePath($path))
                $relative = $path;
}

//get the list of files and directories
$list = $manager->getFiles($relative);

//Define some variables - Ryan Demmer. Added for TinyMCE

$imagepath = $IMConfig['img_url'];

/* ================= OUTPUT/DRAW FUNCTIONS ======================= */

/**
 * Draw the files in an table.
 */
//Added modifications for TinyMCE - Ryan Demmer
function drawFiles($list, &$manager)
{
        global $relative, $imagepath, $image_delete_auth, $image_edit_auth, $isAdmin, $editor_im_image, $editor_im_image_edit, $editor_im_thumbs;

        foreach($list as $entry => $file)
        {
                if ($file['image'][1] > 96){
                    $thumb_height = "height=\"96\"";
                }else{
                    $thumb_height = "";
                }
                if ($file['image'][0] > 96){
                    $thumb_width = "width=\"96\"";
                }else{
                    $thumb_width = "";
                }
                if ($file['image'][0] > $file['image'][1]){
                    $thumb_width = "width=\"96\"";
                }else{
                    $thumb_width = "";
                }
                if ($file['image'][1] > $file['image'][0]){
                    $thumb_height = "height=\"96\"";
                }else{
                    $thumb_height = "";
                }
                $thumbInfo = $manager->getImageInfo($manager->getThumbnail($file['relative']));
                $thumbnail = $manager->getThumbnail($file['relative']);
                if ($thumbnail == 'img/default.gif'){
                  $thumbnail = "";
                  $thumbInfo[0] = "";
                  $thumbInfo[1] = "";
                }
        ?>
                <td><table width="100" cellpadding="0" cellspacing="0"><tr><td class="block">
                <?php if ($editor_im_thumbs == 'true'){?>
                    <a href="javascript:;"onclick="selectImage('<?php echo "$imagepath".$file['relative'];?>', '<?php echo $entry; ?>', <?php echo $file['image'][0];?>, <?php echo $file['image'][1]; ?>, '<?php echo $thumbnail; ?>', '<?php echo $thumbInfo[0]; ?>', '<?php echo $thumbInfo[1]; ?>');"title="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>"><img src="<?php echo $manager->getThumbnail($file['relative']); ?>" alt="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>" <?php echo $thumb_height; ?> <?php echo $thumb_width; ?>/></a>
                <?php }else{?>
                    <a href="javascript:;"onclick="selectImage('<?php echo "$imagepath".$file['relative'];?>', '<?php echo $entry; ?>', <?php echo $file['image'][0];?>, <?php echo $file['image'][1]; ?>, '', '', '');"title="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>"><img src="<?php echo "$imagepath".$file['relative']; ?>" alt="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>" <?php echo $thumb_height; ?> <?php echo $thumb_width; ?>/></a>
                <?php }?>
                </td></tr>
                <tr>
                <td class="edit" align="center">
                <?php if(($image_delete_auth || $isAdmin) && $editor_im_image){?>
                            <a href="images.php?dir=<?php echo $relative; ?>&amp;delf=<?php echo rawurlencode($file['relative']);?>" title="<?php echo _imgmanager_del ?>" onclick="return confirmDeleteFile('<?php echo $entry; ?>');"><img src="img/edit_trash.gif" height="15" width="15" alt="<?php echo _imgmanager_del ?>"/></a>
                <?php } ?>
                <?php if ($manager->validImageType($imagepath.$file['relative']) && ($image_edit_auth || $isAdmin) && $editor_im_image_edit){ ?>
                        <a href="javascript:;" title="<?php echo _imgmanager_edit ?>" onclick="editImage('<?php echo rawurlencode($file['relative']);?>');"><img src="img/edit_pencil.gif" height="15" width="15" alt="<?php echo _imgmanager_edit ?>"/></a>
                <?php } ?>
                        <a href="javascript:;" title="<?php echo _imgmanager_view ?>" onclick="viewImage('<?php echo "$imagepath".$file['relative'];?>', '<?php echo $entry; ?>', <?php echo $file['image'][0];?>, <?php echo $file['image'][1]; ?>, '<?php echo Files::formatSize($file['stat']['size']); ?>');"><img src="img/view_image.gif" height="15" width="15" alt="<?php echo _imgmanager_view ?>"/></a>
                <?php if($file['image']){ echo $file['image'][0].'x'.$file['image'][1]; } else echo $entry;?>
                </td>
                </tr></table></td>
          <?php
        }//foreach
}//function drawFiles

/**
 * Draw the directory.
 */
function drawDirs($list, &$manager)
{
        global $relative, $folder_delete_auth, $isAdmin, $editor_im_folder;

        foreach($list as $path => $dir)
        {
          ?>
                <td><table width="100" cellpadding="0" cellspacing="0"><tr><td class="block">
                <a href="images.php?dir=<?php echo rawurlencode($path); ?>" onclick="updateDir('<?php echo $path; ?>')" title="<?php echo $dir['entry']; ?>"><img src="img/folder.gif" height="80" width="80" alt="<?php echo $dir['entry']; ?>" /></a>
                </td></tr><tr>
                <td class="edit">
                <?php if (($folder_delete_auth || $isAdmin) && $editor_im_folder){ ?>
                        <a href="images.php?dir=<?php echo $relative; ?>&amp;deld=<?php echo rawurlencode($path); ?>" title="<?php echo _imgmanager_del ?>" onclick="return confirmDeleteDir('<?php echo $dir['entry']; ?>', <?php echo $dir['count']; ?>);"><img src="img/edit_trash.gif" height="15" width="15" alt="<?php echo _imgmanager_del ?>"/></a>
                        <?php } ?>
                        <?php echo $dir['entry']; ?>
                </td>
                </tr></table></td>
          <?php
        } //foreach
}//function drawDirs

/**
 * No directories and no files.
 */
function drawNoResults()
{
?>
<table width="100%">
  <tr>
    <td class="noResult"><?php echo _imgmanager_noImages ?></td>
  </tr>
</table>
<?php
}

/**
 * No directories and no files.
 */
function drawErrorBase(&$manager)
{
?>
<table width="100%">
  <tr>
    <td class="error"><?php echo _imgmanager_invalidDir ?>: <?php echo $manager->config['base_dir']; ?></td>
  </tr>
</table>
<?php
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title>Image List</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="assets/imagelist.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/dialog.js"></script>
<script type="text/javascript">
/*<![CDATA[*/

        if(window.top)
                I18N = window.top.I18N;

        function hideMessage()
        {
                var topDoc = window.top.document;
                var messages = topDoc.getElementById('messages');
                if(messages)
                        messages.style.display = "none";
        }

        init = function()
        {
                hideMessage();
                var topDoc = window.top.document;

<?php
        //we need to refesh the drop directory list
        //save the current dir, delete all select options
        //add the new list, re-select the saved dir.
        if($refreshDir)
        {
                $dirs = $manager->getDirs();
?>
                var selection = topDoc.getElementById('dirPath');
                var currentDir = selection.options[selection.selectedIndex].text;

                while(selection.length > 0)
                {        selection.remove(0); }

                selection.options[selection.length] = new Option("/","<?php echo rawurlencode('/'); ?>");
                <?php foreach($dirs as $relative=>$fullpath) { ?>
                selection.options[selection.length] = new Option("<?php echo $relative; ?>","<?php echo rawurlencode($relative); ?>");
                <?php } ?>

                for(var i = 0; i < selection.length; i++)
                {
                        var thisDir = selection.options[i].text;
                        if(thisDir == currentDir)
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }
<?php } ?>
        }

        function editImage(image)
        {
                var url = "editor.php?img="+image;
                Dialog(url, function(param)
                {
                        if (!param) // user must have pressed Cancel
                                return false;
                        else
                        {
                                return true;
                        }
                }, null);
        }

        //Added option to view full image in popup - Ryan Demmer Feb 2005
        function viewImage(image, alt, imgwidth, imgheight, imgsize)
        {
               if (imgwidth >= screen.availWidth){
                   imgwidth = screen.availWidth-(screen.availWidth*0.2);
               }
               if (imgheight >= screen.availHeight){
                   imgheight = screen.availHeight-(screen.availHeight*0.2);
               }
               var url = "preview.php?img="+image+"&alt="+alt+"&imgwidth="+imgwidth+"&imgheight="+imgheight+"&imgsize="+imgsize;
               window.open(url,'','menubar=no,toolbar=no,scrollbars=yes,resizable=yes, left='+(screen.availWidth/2-(imgwidth/2))+',top='+(screen.availHeight/2-(imgheight/2))+',width='+(imgwidth+30)+',height='+(imgheight+130)+'');
        }

/*]]>*/
</script>
<script type="text/javascript" src="assets/images.js"></script>
</head>

<body style="background-color:#FFFFFF">
<?php if ($manager->isValidBase() == false) { drawErrorBase($manager); }
        elseif(count($list[0]) > 0 || count($list[1]) > 0) { ?>
<table>
        <tr>
        <?php drawDirs($list[0], $manager); ?>
        <?php drawFiles($list[1], $manager); ?>
        </tr>
</table>
<?php } else { drawNoResults(); } ?>
</body>
</html>
<?php
}else{
die( 'You are not authorised to view this page.' );
}
?>
