<?php
/*Define system file path */
define("LST_ROOT_DIR",  dirname(__FILE__)."/");
define("LST_FOLDER_NAME", trim(substr(LST_ROOT_DIR, strlen(dirname(LST_ROOT_DIR))+1),'/'));
define('WHERE_HOME_URL', home_url());   
define('LST_ROOT_URL', WHERE_HOME_URL.'/'.LST_FOLDER_NAME);   


define("LST_INCLUDE", 'includes');
define("LST_CONFIG", 'config');
define("LST_LIB",  'lib');
define("LST_VIEW", 'views');
define("LST_CACHE", 'cache');

/* end */
include (LST_ROOT_DIR.LST_INCLUDE.'/functions.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/config_control.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/page_view.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/url_parameter.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/url_parameter.ajax.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/url_parameter.fuls.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/build_sidebar.class.php');
include (LST_ROOT_DIR.LST_INCLUDE.'/listing_controller.class.php');
 
?>


