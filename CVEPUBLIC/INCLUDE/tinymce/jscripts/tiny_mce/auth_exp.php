<?
/**
 * Authorisation script for TinyMCE.
 *@author $Author: Ryan Demmer $
 * @version $Id: auth_mce.php 26 2004-12-24 18:24:00 $
 * @package TinyMCE_exp
 * @Portions from remository.php
 */

// Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function checkType($type){
        global $mosConfig_absolute_path, $mainframe, $my, $database, $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix;

        require_once ($mosConfig_absolute_path."/includes/mambo.php");
        include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");

        //Get group id from database relative to session usertype
        $query = "SELECT lft FROM #__core_acl_aro_groups WHERE name = '".$my->usertype."' LIMIT 1";
        $database->setQuery( $query );
        $grp = $database->loadResult();

        //Check for access rights based on parameter info and session info
        switch ($type){
                case 'admin' :
                     if ((strtolower($my->usertype)=='manager') || (strtolower($my->usertype)=='administrator') || (strtolower($my->usertype)=='superadministrator')
                                || (strtolower($my->usertype)=='super administrator')){
                                                return true;
                     }
                break;
                case 'imgmanager' :
                      if ($grp >= $editor_plugin_imgmanager_acl && $editor_plugin_imgmanager_acl != 0){
                        return true;
                      }
                break;
                case 'filemanager' :
                      if ($grp >= $editor_plugin_filemanager_acl && $editor_plugin_filemanager_acl != 0){
                        return true;
                      }
                break;
                case 'font' :
                      if ($grp >= $editor_font_tools_acl && $editor_font_tools_acl != 0){
                        return true;
                      }
                break;
                case 'emotions' :
                      if ($grp >= $editor_plugin_emotions_acl && $editor_plugin_emotions_acl != 0){
                        return true;
                      }
                break;
                case 'advlink' :
                      if ($grp >= $editor_plugin_advlink_acl && $editor_plugin_advlink_acl != 0){
                        return true;
                      }
                break;
                case 'flash' :
                      if ($grp >= $editor_plugin_flash_acl && $editor_plugin_flash_acl != 0){
                        return true;
                      }
                break;
        }
}

?>
