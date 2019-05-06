<?php
/**
* @version $Id: preview.php,v 1.0 2005/03/21 10:32:00 Ryan Demmer$
* @package TinyMCE-EXP
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
/** Set flag that this is a parent file */
define( '_VALID_MOS', 1 );

include ("../../../../../../../configuration.php");
include ($mosConfig_absolute_path."/includes/database.php");
require_once ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
if ($editor_preview_bgcolor == ''){
  $editor_preview_body = "<body>";
}else{
  $editor_preview_body = "<body style=\"background-color:$editor_preview_bgcolor\">";
}
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
// Get the default stylesheet
        $query = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
        $database->setQuery($query );
        $cur_template = $database->loadResult();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Content Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $cur_template;?>/css/template_css.css" type="text/css" />
<script language="javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript">
    window.focus;
    window.resizeTo(600,400);
    var form = window.opener.document.adminForm
    var title = form.title.value;
    
    var alltext = tinyMCE.getContent();
		
		// do the images
		var temp = new Array();
		for (var i=0, n=form.imagelist.options.length; i < n; i++) {
			value = form.imagelist.options[i].value;
			parts = value.split( '|' );

			temp[i] = '<img src="<?php echo $mosConfig_live_site; ?>/images/stories/' + parts[0] + '" align="' + parts[1] + '" border="' + parts[3] + '" alt="' + parts[2] + '" hspace="6" />';
		}

		var temp2 = alltext.split( '{mosimage}' );

		var alltext = temp2[0];

		for (var i=0, n=temp2.length-1; i < n; i++) {
			alltext += temp[i] + temp2[i+1];
		}
</script>
</head>
<?php echo $editor_preview_body?>
<table align="center" width="90%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td class="contentheading" colspan="2"><script>document.write(title);</script></td>
	</tr>
	<tr>
		<script>document.write("<td valign=\"top\" height=\"90%\" colspan=\"2\">" + alltext + "</td>");</script>
	</tr>
	<tr>
		<td align="right"><a href="#" onClick="window.close()">Close</a></td>
		<td align="left"><a href="javascript:;" onClick="window.print(); return false">Print</a></td>
	</tr>
</table>
</body>
</html>

