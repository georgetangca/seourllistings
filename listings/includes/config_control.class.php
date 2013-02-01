<?php
include (LST_ROOT_DIR.LST_CONFIG.'/constant_def.php');
include (LST_ROOT_DIR.LST_CONFIG.'/where_config.php');

/**  CLASS: Config_Control
 *   For future extension , provide the semantical function to get the related config value  
 *   from the config file "where_config.php"
 * 
 * 
 */

class Config_Control { 
      public function __construct() {
          // global $CONFIG;
          // $this->config_info = $CONFIG;
       }
       
       public function __destruct() {
           ;
       }
       
       public static function get_tpl_id_from_region_slug($region_name_slug){
           global $CONFIG;
           if($region_name_slug == "canadianrockies"){
               return TPL_SEARCH_ROCKIES;  
           } else if(in_array($region_name_slug,$CONFIG['base_region_root'])){
               return TPL_SEARCH_GENERAL;
           } else {
              return TPL_SEARCH_DEAULT; 
           } 
       }
       
       public static function get_tpl_id_from_region_catid($region_catid){
           global $CONFIG;
           
           if($region_catid == "4063"){//candian rockies
               return TPL_SEARCH_ROCKIES;  
           } else if(array_key_exists($region_catid,$CONFIG['base_region_root'])){
               return TPL_SEARCH_GENERAL;
           } else {
              return TPL_SEARCH_DEAULT; 
           } 
           
       }
       
       
       public static  function get_region_catid($region_name_slug){
            global $CONFIG;
            if(false !== ($catid = array_search($region_name_slug,$CONFIG['base_region_root']))){
                return $catid; 
            }
       }
       
       public static function get_sub_region_catid($sub_region_name_slug){
            global $CONFIG;
            if(false !== ($catid = array_search($sub_region_name_slug,$CONFIG['rockies_sub_region_root']))){
                return $catid; 
            }
       }
       
       public static function check_cache_enable(){
           global $CONFIG;
           if($CONFIG['cache_enable']){
               return true;
           } else return false;
           
       }
       
       public static function get_cache_file_name($region_catid){
           $region_name_slug = self::get_sidebar_region_name($region_catid);
           $tmp_name =  implode("_" ,explode(" " ,$region_name_slug));
           $file_name  =  LST_ROOT_DIR.LST_CACHE.'/'.$tmp_name.'_'.'config_cache.php';
           return $file_name;
       }
       
       
       public static function get_service_url(){
           global $CONFIG;
           return $CONFIG['service_url'].'/'.$CONFIG['site_slug'];
       }
       
       public static function get_sidebar_cfg($tpl_indicator){
           global $CONFIG;
           if(!isset($CONFIG['mapping_tpl'][$tpl_indicator])){
              exit(); 
           } else return $CONFIG['mapping_tpl'][$tpl_indicator];
       }
       
       
       public static function get_sidebar_region_name($region_catid){
           global $CONFIG;
           return $CONFIG['sidebar_mapping'][$region_catid];
       }
       
       public static function get_sidebar_region_slug($region_catid){
           global $CONFIG;
           return $CONFIG['base_region_root'][$region_catid];
       }
       
       public static function get_nearby_cat_mapping($region_catid){
          global $CONFIG;  
          return $CONFIG['category_mapping'][$region_catid];
       }
       
       
       public static function get_rockies_sub_region_cat_mapping(){
          global $CONFIG;  
          return $CONFIG['rockies_sub_region_root'];
       }
       
       public static function get_sidebar_sub_region_slug($sub_region_catid){
           global $CONFIG;
           return $CONFIG['rockies_sub_region_root'][$sub_region_catid];
       }
       
       
       
       
       
   }
   
?>
