<?php
/**
 * TinyMCE Advanced Link Dialog.
 * Adapted from TinyMCE Insert Link dialog
 *@author $Author: Ryan Demmer 27/01/2005$
 * @package advlink
 */
define( '_VALID_MOS', 1 );

$base_path = "../../../../../../../";
global $option, $mosConfig_absolute_path, $database, $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix;


//Some includes
include_once ($base_path."globals.php");
require_once ($base_path."configuration.php");
require_once ($base_path."includes/mambo.php");
include ($base_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
include ("langs/$editor_lang.php");

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );

$mainframe = new mosMainframe ($database, $option, $base_path);

//Articles
$query = "SELECT a.id AS value, CONCAT( a.title, ' /', a.title_alias, '' ) AS text, CONCAT( '$mosConfig_live_site/index.php?option=com_content&task=view&id=', a.id) AS href
         FROM #__content AS a
         WHERE a.state = '1' AND a.sectionid != '0'
         ORDER BY a.id";

        $database->setQuery( $query );
        $contents = $database->loadObjectList( );

        $javascript = "onChange=\"document.forms[0].href.value = this.value;
                       document.forms[0].static_content.value = '';
                       document.forms[0].category.value = '';
                       document.forms[0].section.value = '';
                       document.forms[0].contact.value = '';\"";

        $list['article'] = "<select name=\"articles\" $javascript style=\"width:200px\">";
        $list['article'] .= "<option value=\"\" selected>"._insert_link_article_select."</option>";

        foreach ( $contents as $article_item ) {
                 $_Itemid = $mainframe->getItemid( $article_item->value );
                 if (!$_Itemid){
                     $_Itemid = "0";
                 }
                 $itemid = "&Itemid=$_Itemid";
                 $list['article'] .= "<option value=\"".$article_item->href."$itemid\">".$article_item->text."</option>";
        }
        $list['article'] .= "</select>";

//Static Content
$query = "SELECT a.id AS value, CONCAT( a.title, ' /', a.title_alias, '' ) AS text, CONCAT( '$mosConfig_live_site/index.php?option=com_content&task=view&id=', a.id) AS href
         FROM #__content AS a
         WHERE a.state = '1' AND a.sectionid = '0'
         ORDER BY a.id";

        $database->setQuery( $query );
        $static_content = $database->loadObjectList( );

        $javascript = "onChange=\"document.forms[0].href.value = this.value;
                       document.forms[0].articles.value = '';
                       document.forms[0].category.value = '';
                       document.forms[0].section.value = '';
                       document.forms[0].contact.value = '';\"";

        $list['static'] = "<select name=\"static_content\" $javascript style=\"width:200px\">";
        $list['static'] .= "<option value=\"\" selected>"._insert_link_static_select."</option>";

        foreach ( $static_content as $static_item ) {
                 $_Itemid = $mainframe->getItemid( $static_item->value );
                 if (!$_Itemid){
                     $_Itemid = "0";
                 }
                 $itemid = "&Itemid=$_Itemid";

                 $list['static'] .= "<option value=\"".$static_item->href."$itemid\">".$static_item->text."</option>";
        }
        $list['static'] .= "</select>";

//Category
$query = "SELECT a.id AS value, CONCAT( a.title, ' /', a.name, '' ) AS text, CONCAT( '$mosConfig_live_site/index.php?option=com_content&task=category&sectionid=', a.section, '&id=', a.id) AS href
         FROM #__categories AS a
         LEFT JOIN #__sections AS s ON s.id
         WHERE a.published = '1' AND s.id = a.section
         ORDER BY a.id";

        $database->setQuery( $query );
        $category_content = $database->loadObjectList( );

        $javascript = "onChange=\"document.forms[0].href.value = this.value;
                       document.forms[0].static_content.value = '';
                       document.forms[0].articles.value = '';
                       document.forms[0].section.value = '';
                       document.forms[0].contact.value = '';\"";

        $list['category'] = "<select name=\"category\" $javascript style=\"width:200px\">";
        $list['category'] .= "<option value=\"\" selected>"._insert_link_category_select."</option>";

        foreach ( $category_content as $category_item ) {
                 $_Itemid = $mainframe->getItemid( $category_item->value );
                 if (!$_Itemid){
                     $_Itemid = "0";
                 }
                 $itemid = "&Itemid=$_Itemid";
                 $list['category'] .= "<option value=\"".$category_item->href."$itemid\">".$category_item->text."</option>";
        }
        $list['category'] .= "</select>";

//Section
$query = "SELECT a.id AS value, CONCAT( a.title, ' /', a.name, '' ) AS text, CONCAT( '$mosConfig_live_site/index.php?option=com_content&task=section&id=', a.id) AS href
         FROM #__sections AS a
         WHERE a.published = '1' AND a.scope='content'
         ORDER BY a.id";

        $database->setQuery( $query );
        $section_content = $database->loadObjectList( );

        $javascript = "onChange=\"document.forms[0].href.value = this.value;
                       document.forms[0].static_content.value = '';
                       document.forms[0].category.value = '';
                       document.forms[0].articles.value = '';
                       document.forms[0].contact.value = '';\"";

        $list['section'] = "<select name=\"section\" $javascript style=\"width:200px\">";
        $list['section'] .= "<option value=\"\" selected>"._insert_link_section_select."</option>";

        foreach ( $section_content as $section_item ) {
                 $_Itemid = $mainframe->getItemid( $section_item->value );
                 if (!$_Itemid){
                     $_Itemid = "0";
                 }
                 $itemid = "&Itemid=$_Itemid";
                 $list['section'] .= "<option value=\"".$section_item->href."$itemid\">".$section_item->text."</option>";
        }
        $list['section'] .= "</select>";

//Contact
$query = "SELECT a.id AS value, CONCAT( a.name, ' /', a.con_position, '' ) AS text, CONCAT( '$mosConfig_live_site/index.php?option=com_contact&task=view&contact_id=', a.id) AS href
         FROM #__contact_details AS a
         LEFT JOIN #__menu AS m ON m.componentid = a.id
         WHERE a.published = '1'
         ORDER BY a.id";

        $database->setQuery( $query );
        $contact_content = $database->loadObjectList( );

        $javascript = "onChange=\"document.forms[0].href.value = this.value;
                       document.forms[0].static_content.value = '';
                       document.forms[0].category.value = '';
                       document.forms[0].section.value = '';
                       document.forms[0].articles.value = '';\"";

        $list['contact'] = "<select name=\"contact\" $javascript style=\"width:200px\">";
        $list['contact'] .= "<option value=\"\" selected>"._insert_link_contact_select."</option>";

        foreach ( $contact_content as $contact_item ) {
                 $_Itemid = $mainframe->getItemid( $contact_item->value );
                 if (!$_Itemid){
                     $_Itemid = "0";
                 }
                 $itemid = "&Itemid=$_Itemid";
                 $list['contact'] .= "<option value=\"".$contact_item->href."$itemid\">".$contact_item->text."</option>";
        }
        $list['contact'] .= "</select>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo _insert_link_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Oct 24 1976 00:00:00 GMT" />
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="link.js"></script>
<script language="javascript" type="text/javascript">

tinyMCE.setWindowArg('mce_windowresize', false);

</script>
<style type="text/css">
<!--
   input.radio {
        border: 1px none #000000;
        background-color: transparent;
        vertical-align: middle;
   }
-->
</style>
</head>
<body onload="init();">
<form action="link.php" onsubmit="insertLink();return false;" method="post">
<fieldset><legend><strong><?php echo _insert_link_content ?></strong></legend>
<table border="0">
  <tr>
    <td class="label" valign="top" nowrap><?php echo _insert_link_article ?>:</td>
    <td><?php echo $list['article']; ?></td>
    <td rowspan="5">
         <iframe src="search.php" name="search" id="search" title="Search" frameborder="0" width="290" height="115"></iframe>
    </td>
  </tr>
  <tr>
    <td class="label" valign="top" nowrap><?php echo _insert_link_static ?>:</td>
    <td><?php echo $list['static']; ?></td>
  </tr>
  <tr>
    <td class="label" valign="top" nowrap><?php echo _insert_link_category ?>:</td>
    <td><?php echo $list['category']; ?></td>
  </tr>
  <tr>
    <td class="label" valign="top" nowrap><?php echo _insert_link_section ?>:</td>
    <td><?php echo $list['section']; ?></td>
  </tr>
  <tr>
    <td class="label" valign="top" nowrap><?php echo _insert_link_contact ?>:</td>
    <td><?php echo $list['contact']; ?></td>
  </tr>
 </table>
 </fieldset>
 <fieldset><legend><strong><?php echo _insert_link_info ?></strong></legend>
                    <table border="0">
                    <tr>
                        <td><nobr><?php echo _insert_link_url ?>:</nobr></td>
                        <td colspan="2"><input name="href" type="text" id="href" value="" style="width: 500px;" /></td>
                    </tr>
                    <tr>
                        <td><nobr><?php echo _insert_link_titlefield ?>:</nobr></td>
                        <td colspan="2"><input name="title" type="text" id="linktitle" value="" style="width: 500px;" /></td>
                    </tr>
                    <tr>
                        <td class="label" nowrap><?php echo _insert_link_protocol ?>:</td>
                        <td colspan="2">
                            <select name="formProt" id="formProt" onChange="UpdateProtocol();">
                                    <option value="http:">http</option>
                                    <option value="https:">https</option>
                                    <option value="mailto:">mailto</option>
                                    <option value="ftp:">ftp</option>
                                    <option value="" selected><?php echo _insert_link_other ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><nobr><?php echo _insert_link_target ?>:</nobr></td>
                        <td>
                            <select name="target" id="target">
                                    <option value="_blank" selected>_blank&nbsp;(<?php echo _insert_link_target_blank ?>)</option>
                                    <option value="_self">_self&nbsp;(<?php echo _insert_link_target_same ?>)</option>
                                    <option value="_parent">_parent&nbsp;(<?php echo _insert_link_target_parent ?>)</option>
                                    <option value="_top">_top&nbsp;(<?php echo _insert_link_target_top ?>)</option>
                            </select>
                        </td>
                    </tr>
                    </table>
                    </fieldset>
                    <table border="0">
                    <tr>
                        <td><input type="button" name="insert" value="{$lang_insert}" onclick="insertLink();" id="insert" /></td>
                        <td><input type="button" name="cancel" value="<?php echo _insert_link_cancel ?>" onclick="cancelAction();" id="cancel" /></td>
                        <td><input type="reset" name="reset" value="<?php echo _insert_link_reset ?>" id="reset" /></td>
                    </tr>
                    </table>
    </form>
</body>
</html>
