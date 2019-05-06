<?
$PathLoadClass = $_SESSION["CONFIG"]->getSection('APPLICATION');

function __autoload($class_name) {
    global $PathLoadClass;
    if (is_array($PathLoadClass)) {
        foreach ($PathLoadClass as $key => $path) {
            if (strstr($key, 'PATH_')){            
                if (include_exists($path."{$class_name}.class.php")){ 
                    include_once($path."{$class_name}.class.php");
                }
            }
        }
    }
}

function include_exists($file) {
    static $include_dirs = null;
    static $include_path = null;

    // set include_dirs
    if (is_null($include_dirs) || get_include_path() !== $include_path) {
        $include_path = get_include_path();
        foreach (split(PATH_SEPARATOR, $include_path) as $include_dir) {
            if ($include_dir && substr($include_dir, -1) != '/') {
                $include_dir .= '/';
            }
            $include_dirs[]    = $include_dir;
        }
    }
    if (substr($file, 0, 1) == '/') { //absolute filepath - what about file:///?
        return (file_exists($file));
    }
    if ((substr($file, 0, 7) == 'http://' || substr($file, 0, 6) == 'ftp://') && ini_get('allow_url_fopen')) {
        return true;
    }
    foreach ($include_dirs as $include_dir) {
        if (file_exists($include_dir.$file)) {
            return true;
        }
    }
    return false;
}
?>
