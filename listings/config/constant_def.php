<?php

/**********Need to change for the server *******************************/
if(!defined('SJM_SERVICE_FOLDER')) {
   define('SJM_SERVICE_FOLDER','sjmServiceTemp'); 
}
/**********************************************************************/

$serverName = $_SERVER['SERVER_NAME'];
$serverNameArray = explode(".", $serverName);
if ($serverNameArray[0] == "stage") {
    $SJM_globalEnvironment = "stage.directory.stjosephmedia.com";   
} else if($serverNameArray[0] =="localhost"){
    //just for current testing 
     $SJM_globalEnvironment = "service.stjosephmedia.com";
} else {
    $SJM_globalEnvironment = "directory.stjosephmedia.com";    
}


/*Interface for different web site*******************/
if(!defined('ENABLE_SITE_SLUG')){
   define('ENABLE_SITE_SLUG', 'where');   //where, torontolife 
}

if(!defined('ENABLE_SITE_NAME')){
   define('ENABLE_SITE_NAME', 'where');   //where, torontolife 
}

//define the cookie name for save the listing search url
if(!defined('URL_COOKIE_NAME')){
   define('URL_COOKIE_NAME', 'where-url-cookie');   //where, torontolife 
}


/**********Not touch below if you are not familiar with here****/

if(!defined('SEARCH_LISTING_URL_PATH')){
   define('SEARCH_LISTING_URL_PATH', LST_ROOT_URL);    
}

/*ABSPATH from wordpress */
if(!defined('SEARCH_LISTING_ABS_PATH')){
   define('SEARCH_LISTING_ABS_PATH', LST_ROOT_DIR);    
}

define('CUR_URL_PATH',  LST_ROOT_URL);    


/********Define sidebar list type******************************/
if(!defined('BUILD_CHECK_BOX')){
        define('BUILD_CHECK_BOX','1');
}
    
if(!defined('BUILD_RADIO_BOX')){
  define('BUILD_RADIO_BOX','2');
}

if(!defined('BUILD_LINK')){
  define('BUILD_LINK','3');
}

/********Define sidebar content type******************************/
if(!defined('BUILD_HOOD')){
        define('BUILD_HOOD','hood');
}
    
if(!defined('BUILD_CATEGORY')){
  define('BUILD_CATEGORY','cat');
}

if(!defined('BUILD_LIST_CATEGORY')){
  define('BUILD_LINK_CATEGORY','lcat');
}

if(!defined('BUILD_CATEGORY_GROUP')){
  define('BUILD_CATEGORY_GROUP','catg');
}


if(!defined('BUILD_SINGLE_CUSTOM_FIELD')){
  define('BUILD_SINGLE_CUSTOM_FIELD','cuss');
}

if(!defined('BUILD_ALL_CUSTOM_FIELD')){
  define('BUILD_ALL_CUSTOM_FIELD','cusa');
}
/***************************************************************/

if(!defined('BUILD_USER_RATING')){
  define('BUILD_USER_RATING','usr');
}

if(!defined('BUILD_DATA_DONE')){
  define('BUILD_DATA_DONE','dd');
}

if(!defined('BUILD_SIDEBAR_DEFAULT_LIST_NUMBER')){
  define('BUILD_SIDEBAR_DEFAULT_LIST_NUMBER','5');
}


if(!defined('BUILD_WHERE_TORONTO')){
  define('BUILD_WHERE_TORONTO','3489');
}


//define sidebar character 
if(!defined('SIDEBAR_WIDGET_ONLY')){
   define('SIDEBAR_WIDGET_ONLY', 'widget');   //to show sidebar widget
}
if(!defined('SIDEBAR_WIDGET_COMB')){
   define('SIDEBAR_WIDGET_COMB', 'comb');   //to show sidebar widget and set the check filter
}

//define tpl search indicator
if(!defined('TPL_SEARCH_GENERAL')){
  define('TPL_SEARCH_GENERAL','tpl_gl');
}
if(!defined('TPL_SEARCH_ROCKIES')){
  define('TPL_SEARCH_ROCKIES','tpl_rk');
}

if(!defined('TPL_SEARCH_DEAULT')){
  define('TPL_SEARCH_DEAULT','tpl_df');
}


//define URL indicator
if(!defined('URL_SEARCH_PAGE')){
  define('URL_SEARCH_PAGE','search');
}

if(!defined('URL_DEATIL_PAGE')){
  define('URL_DEATIL_PAGE','detail');
}

if(!defined('URL_SHOW_WIDGET')){
  define('URL_SHOW_WIDGET','widget');
}

if(!defined('URL_INVALID')){
  define('URL_INVALID','invalid');
}

 
?>

