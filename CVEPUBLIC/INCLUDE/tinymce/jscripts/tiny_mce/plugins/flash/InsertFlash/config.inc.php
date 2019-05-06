<?php
/***********************************************************************
** Title.........:    Insert File Dialog, File Manager
** Version.......:    1.1
** Authors.......:    Al Rashid <alrashid@klokan.sk>
**                    Xiang Wei ZHUO <wei@zhuo.org>
** Filename......:    config.php
** URL...........:    http://alrashid.klokan.sk/insFile/
** Last changed..:    23 July 2004
***********************************************************************/
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$base_path = "../../../../../../../../";

require_once ($base_path."configuration.php");
include_once ($base_path."mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");

/*
 MY_DOCUMENT_ROOT
 File system path to the directory you want to manage the files and folders
 NOTE: This directory requires write permission by PHP. That is,
       PHP must be able to create files in this directory.
 NOTE2: without trailing slash
*/
//$MY_DOCUMENT_ROOT = 'C:\Apache\www\gul\insFile\data';
$MY_DOCUMENT_ROOT = $mosConfig_absolute_path.$editor_swf_doc_root;

/*
 MY_BASE_URL
 Not used in htmlarea3-plugin version
*/
$MY_BASE_URL = $mosConfig_live_site.$editor_swf_base_url;

/*
 MY_URL_TO_OPEN_FILE
 The URL to the MY_DOCUMENT_ROOT path, the web browser needs to be able to see it.
 It can be protected via .htaccess on apache or directory permissions on IIS,
 check you web server documentation for futher information on directory protection
 If this directory needs to be publicly accessiable, remove scripting capabilities
 for this directory (i.e. disable PHP, Perl, CGI). We only want to store documents
 in this directory and its subdirectories.
 NOTE: without trailing slash
*/
$MY_URL_TO_OPEN_FILE         = $mosConfig_live_site.$editor_swf_base_url;
//$MY_URL_TO_OPEN_FILE         = 'http://gul.net/insFile/data';

/*
 MY_ALLOW_EXTENSIONS
 MY_DENY_EXTENSIONS
 MY_ALLOW_EXTENSIONS and MY_DENY_EXTENSIONS arrays specify which file types can be uploaded.
 Setting to null skips this check. The scheme is:
 1) If MY_DENY_EXTENSIONS is not null check if it does _not_ contain file extension of the file to be uploaded.
    If it does skip the upload procedure.
 2) If MY_ALLOW_EXTENSIONS is not null check if it _does_ contain file extension of the file to be uploaded.
    If it doesn't skip the upload procedure.
 3) Upload file.
 NOTE: File extensions arrays are case insensitive.
        You should always include server side executable file types in MY_DENY_EXTENSIONS !!!
*/

$MY_ALLOW_EXTENSIONS        = array('swf');
$MY_DENY_EXTENSIONS         = array('php', 'php3', 'php4', 'phtml', 'shtml', 'cgi', 'pl');

/*
 MY_LIST_EXTENSIONS
 This array specifies which files are listed in dialog. Setting to null causes that all files are listed.
 NOTE: File extensions arrays are case insensitive.
*/
$MY_LIST_EXTENSIONS                = array('swf');

/*
 MY_ALLOW_CREATE
 Boolean (false or true) whether creating folders is allowed or not.
*/
$MY_ALLOW_CREATE                  = $editor_swf_folder;

/*
 $MY_ALLOW_DELETE
 Boolean (false or true) whether deleting files and folders is allowed or not.
*/
$MY_ALLOW_DELETE                = $editor_swf_folder;

/*
 $MY_ALLOW_RENAME
 Boolean (false or true) whether renaming files and folders is allowed or not.
*/
$MY_ALLOW_RENAME                = $editor_swf_rename;

/*
 $MY_ALLOW_MOVE
 Boolean (false or true) whether moving files and folders is allowed or not.
*/
$MY_ALLOW_MOVE                        = $editor_swf_move;

/*
 $MY_ALLOW_UPLOAD
 Boolean (false or true) whether uploading files is allowed or not.
*/
$MY_ALLOW_UPLOAD                = $editor_swf_upload;

/*
 $MY_ALLOW_UPLOAD
 Maximum allowed size for uploaded files (in bytes).
 NOTE2: see also upload_max_filesize setting in your php.ini file
 NOTE: 2*1024*1024 means 2 MB (megabytes) which is the default php.ini setting
*/
$MY_MAX_FILE_SIZE                 = $editor_swf_max_size*1024*1024;

/*
 $MY_LANG
 Interface language. See the lang directory for translation files.
 NOTE: You should set appropriately MY_CHARSET and $MY_DATETIME_FORMAT variables
*/
$MY_LANG                                 = $editor_lang;

/*
 $MY_CHARSET
 Character encoding for all Insert File dialogs.
 WARNING: For non english and non iso-8859-1 / utf8 users mostly !!!
                 This setting affect also how the name of folder you create via Insert File Dialog
                 and the name of file uploaded via Insert File Dialog will be encoded on your remote
                 server filesystem. Note also the difference between how file names in multipart/data
                 form are encoded by Internet Explorer (plain text depending on the webpage charset)
                and Mozilla (encoded according to RFC 1738).
                This should be fixed in next versions. Any help is VERY appreciated.
*/
$MY_CHARSET             = 'iso-8859-1';

/*
 MY_DATETIME_FORMAT
 Datetime format for displaying file modification time in Insert File Dialog
 and in inserted link, see MY_LINK_FORMAT
*/
$MY_DATETIME_FORMAT                = "d.m.Y H:i";

/*
 MY_LINK_FORMAT
 The string to be inserted into textarea.
 This is the most crucial setting. I apologize for not using the DOM functions any more,
 but inserting raw string allow more customization for everyone.
 The following strings are replaced by corresponding values of selected files/folders:
 _editor_url
        the url of htmlarea root folder - you should set it in your document (see htmlarea help)
 IF_ICON
         file type icon filename (see plugins/InsertFile/images/ext directory)
 IF_URL
         relative path to file relative to $MY_DOCUMENT_ROOT
 IF_CAPTION
        file/folder name
 IF_SIZE
    file size in (B, kB, or MB)
 IF_DATE
    last modification time acording to $MY_DATETIME_FORMAT format
*/
$MY_LINK_FORMAT         = '<span class="filelink"><img src="editor_url/plugins/filemanager/InsertFile/IF_ICON" alt="IF_URL" border="0">&nbsp;<a href="IF_URL">IF_CAPTION</a> &nbsp;<span style="font-size:70%">IF_SIZE &nbsp;IF_DATE</span></span>&nbsp;';


/*
 parse_icon function
 please insert additional file types (extensions) and theis corresponding icons in switch statement
*/

function parse_icon($ext) {
        switch (strtolower($ext)) {
                case 'swf': return 'swf_small.gif';
        default:
                return 'def_small.gif';
        }
}

/*

 !!!!!!!!!!!!! DO NOT EDIT BELLOW !!!!!!!!!!!!!!!!!!111

*/

/*
This was meant  for standalone InsertFile Dialog version
*/
/*
session_start();
if (empty($_REQUEST['dialogname'])) die('Dialog Name missing!');
$MY_NAME = $_REQUEST['dialogname'];
if (!(isset($_SESSION[$MY_NAME])) || !(is_array($_SESSION[$MY_NAME]))) die ('Session not set!');
if (!isset($_SESSION[$MY_NAME])) die ('Document Root not set!');

$MY_DOCUMENT_ROOT = $_SESSION[$MY_NAME]['DocumentRoot'];
(isset($_SESSION[$MY_NAME]['BaseUrl']))                 ? $MY_BASE_URL                         = $_SESSION[$MY_NAME]['BaseUrl']                         : $MY_BASE_URL                         = '';
(isset($_SESSION[$MY_NAME]['UrlToOpenFile']))         ? $MY_URL_TO_OPEN_FILE        = $_SESSION[$MY_NAME]['UrlToOpenFile']                 : $MY_URL_TO_OPEN_FILE         = '';
(isset($_SESSION[$MY_NAME]['AllowExtensions'])) ? $MY_ALLOW_EXTENSIONS        = $_SESSION[$MY_NAME]['AllowExtensions']         : $MY_ALLOW_EXTENSIONS         = null;
(isset($_SESSION[$MY_NAME]['DenyExtensions']))         ? $MY_DENY_EXTENSIONS        = $_SESSION[$MY_NAME]['DenyExtensions']          : $MY_DENY_EXTENSIONS        = array('php', 'php3', 'php4', 'phtml', 'shtml', 'cgi');
(isset($_SESSION[$MY_NAME]['ListExtensions']))         ? $MY_LIST_EXTENSIONS        = $_SESSION[$MY_NAME]['ListExtensions']          : $MY_LIST_EXTENSIONS        = null;

(isset($_SESSION[$MY_NAME]['AllowCreate'])) ? $MY_ALLOW_CREATE                         = $_SESSION[$MY_NAME]['AllowCreate'] : $MY_ALLOW_CREATE = true;
(isset($_SESSION[$MY_NAME]['AllowDelete'])) ? $MY_ALLOW_DELETE                        = $_SESSION[$MY_NAME]['AllowDelete'] : $MY_ALLOW_DELETE = true;
(isset($_SESSION[$MY_NAME]['AllowRename'])) ? $MY_ALLOW_RENAME                        = $_SESSION[$MY_NAME]['AllowRename'] : $MY_ALLOW_RENAME = true;
(isset($_SESSION[$MY_NAME]['AllowMove'])) ? $MY_ALLOW_MOVE                                = $_SESSION[$MY_NAME]['AllowMove'] : $MY_ALLOW_MOVE = true;
(isset($_SESSION[$MY_NAME]['AllowUpload'])) ? $MY_ALLOW_UPLOAD                         = $_SESSION[$MY_NAME]['AllowUpload'] : $MY_ALLOW_UPLOAD = true;

(isset($_SESSION[$MY_NAME]['MaxFileSize'])) ? $MY_MAX_FILE_SIZE                 = $_SESSION[$MY_NAME]['MaxFileSize'] : $MY_MAX_FILE_SIZE = 2*1024*1024;
(isset($_SESSION[$MY_NAME]['Lang'])) ? $MY_LANG                                                 = $_SESSION[$MY_NAME]['Lang'] : $MY_LANG = 'en';
(isset($_SESSION[$MY_NAME]['Charset'])) ? $MY_CHARSET                                         = $_SESSION[$MY_NAME]['Charset'] : $MY_CHARSET = 'iso-8859-1';
(isset($_SESSION[$MY_NAME]['DateTimeFormat'])) ? $MY_DATETIME_FORMAT        = $_SESSION[$MY_NAME]['DateTimeFormat']        : $MY_DATETIME_FORMAT        = "d.m.Y H:i";
(isset($_SESSION[$MY_NAME]['LinkFormat'])) ? $MY_LINK_FORMAT                        = $_SESSION[$MY_NAME]['LinkFormat'] : $MY_LINK_FORMAT = '<span class="filelink"><img src="_editor_urlplugins/InsertFile/IF_ICON" alt="IF_URL" border="0">&nbsp;<a href="IF_URL">IF_CAPTION</a> &nbsp;<span style="font-size:70%">IF_SIZE &nbsp;IF_DATE</span></span>&nbsp;';
*/


// DO NOT EDIT BELOW
$MY_NAME = 'insertfiledialog';
$MY_PATH = '/';
$MY_UP_PATH = '/';
