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
        global $mosConfig_absolute_path, $database, $option, $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix;

        require_once ($mosConfig_absolute_path."/includes/mambo.php");
        include ($mosConfig_absolute_path."/mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");
        
global $mosConfig_absolute_path, $database, $option, $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix, $mainframe;


        // initialise mainframe for session functions
        $mainframe = new mosMainFrame( $database, $option, $mosConfig_absolute_path);

        // initialise session. We have to do this cos session
        // variables can't be carried through to popups in frontend!
        $mainframe->initSession();
        // get usertype from the session
        $my = $mainframe->GetUser();

        //Get the usertpe from session file for admin
        if (!$my->usertype){
            require ($mosConfig_absolute_path."/administrator/includes/auth.php");
        }

        //Get group id from database relative to session usertype
        $database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
        $query = "SELECT lft FROM #__core_acl_aro_groups WHERE name = '".$my->usertype."' LIMIT 1";
        $database->setQuery( $query );
        $grp = $database->loadResult();

        //Check for access rights based on parameter info and session info
        //[08/01/2005]Added Disabled option for frontend users. See tinymce_exp.xml.
        //[02/02/2005]Added 'Manager' admin level, missing from previous packages.
        switch ($type){
                case 'admin' :
                     if ((strtolower($my->usertype)=='manager') || (strtolower($my->usertype)=='administrator') || (strtolower($my->usertype)=='superadministrator')
                                || (strtolower($my->usertype)=='super administrator')){
                                                return true;
                     }
                break;
                case 'user' :
                     if ((strtolower($my->usertype)=='author') || (strtolower($my->usertype)=='editor')
                                || (strtolower($my->usertype)=='publisher')){
                        return true;
                     }
                break;
                case 'IM_upload' :
                      if ($grp >= $editor_im_upload_acl && $editor_im_upload_acl != 0){
                        return true;
                      }
                break;
                case 'IM_new_folder' :
                      if ($grp >= $editor_im_folder_acl && $editor_im_folder_acl != 0){
                        return true;
                      }
                break;
                case 'IM_image_edit' :
                      if ($grp >= $editor_im_image_edit_acl && $editor_im_image_edit_acl != 0){
                        return true;
                      }
                break;
                case 'IM_image_delete' :
                      if ($grp >= $editor_im_image_acl && $editor_im_image_acl != 0){
                        return true;
                      }
                break;
                case 'IM_folder_delete' :
                      if ($grp >= $editor_im_folder_acl && $editor_im_folder_acl != 0){
                        return true;
                      }
                break;
                case 'FM_upload' :
                      if ($grp >= $editor_fm_upload_acl && $editor_fm_upload_acl != 0){
                        return true;
                      }
                break;
                case 'FM_new_folder' :
                      if ($grp >= $editor_fm_folder_acl && $editor_fm_folder_acl != 0){
                        return true;
                      }
                break;
                case 'FM_rename' :
                      if ($grp >= $editor_fm_rename_acl && $editor_fm_rename_acl != 0){
                        return true;
                      }
                break;
                case 'FM_delete' :
                      if ($grp >= $editor_fm_delete_acl && $editor_fm_delete_acl != 0){
                        return true;
                      }
                break;
                case 'FM_move' :
                      if ($grp >= $editor_fm_move_acl && $editor_fm_move_acl != 0){
                        return true;
                      }
                break;
                case 'SWF_upload' :
                      if ($grp >= $editor_swf_upload_acl && $editor_swf_upload_acl != 0){
                        return true;
                      }
                break;
                case 'SWF_new_folder' :
                      if ($grp >= $editor_swf_folder_acl && $editor_swf_folder_acl != 0){
                        return true;
                      }
                break;
                case 'SWF_rename' :
                      if ($grp >= $editor_swf_rename_acl && $editor_swf_rename_acl != 0){
                        return true;
                      }
                break;
                case 'SWF_delete' :
                      if ($grp >= $editor_swf_delete_acl && $editor_swf_delete_acl != 0){
                        return true;
                      }
                break;
                case 'SWF_move' :
                      if ($grp >= $editor_swf_move_acl && $editor_swf_move_acl != 0){
                        return true;
                      }
                break;
        }
}

?>
