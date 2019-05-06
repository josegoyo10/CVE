<?
define( '_VALID_MOS', 1 );
include ("../../../../../configuration.php");
include ($mosConfig_absolute_path."/includes/database.php");
require_once ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
// Get the default stylesheet
$query = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
$database->setQuery($query );
$cur_template = $database->loadResult();

//Remove host url for backwards compatability
if(isset($_GET['img'])) $img_src = ereg_replace($mosConfig_live_site."/", '',($_GET['img']));
if(isset($_GET['alt'])) $img_alt = ($_GET['alt']);
if(isset($_GET['imgwidth'])) $img_width =($_GET['imgwidth']);
if(isset($_GET['imgheight'])) $img_height = ($_GET['imgheight']);

if ($editor_im_popup_bgcolor == ''){
  $editor_im_popup_body = "<body>";
}else{
  $editor_im_popup_body = "<body style=\"background-color:$editor_im_popup_bgcolor\">";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
        <title><?php if(isset($_GET['alt'])) ?></title>
        <link rel="stylesheet" href="<?php echo $mosConfig_live_site ?>/templates/<?php echo $cur_template ?>/css/template_css.css" type="text/css" />
<script type="text/javascript">
        window.focus;
</script>
</head>
<?php echo $editor_im_popup_body ?>
<div align="center">
<table border="0">
    <?php if ($editor_im_popup_title == 'true'){?>
    <tr>
		<td class="contentheading" colspan="2"><?php echo $img_alt; ?></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><img src="<?php echo $mosConfig_live_site; ?>/<?php echo $img_src; ?>" border="0" title="<?php echo $img_alt; ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>" /></td>
	</tr>
	<tr>
        <td><div align="center"><a href="#" onClick="window.close();">Close</a></div></td>
        <?php if ($editor_im_popup_print == 'true'){?>
        <td><div align="center"><a href="javascript:;" onClick="window.print(); return false">Print</a></div></td>
        <?php }?>
    </tr>
</table>
</div>
</body>
</html>
