<?php

class Listing_Controler {
       public $url_param_obj = NULL;
       
       private $defult_region_root = "toronto";
       private $root_folder = "listings";
       private $widget_tag = SIDEBAR_WIDGET_COMB;
      
       public function __construct($widget_only = SIDEBAR_WIDGET_COMB ,$root='listings') {
           if(empty($root)){
             $root = 'root';  
           }
           $this->root_folder = $root;
           $this->widget_tag = $widget_only;
           $this->redirect_check();
           
           if(isset($this->url_parse)){ //url_parse is the string after the /listings/
              $seo_url_cells = explode('/',$this->url_parse);
              if(isset($seo_url_cells[0]) and URL_Parameter::check_valide_region($seo_url_cells[0]) === true){
                  $region_cat_id =  Config_Control::get_region_catid($seo_url_cells[0]);
                  $this->side_bar_obj = new Build_Sidebar($region_cat_id);
                  
              }  
              $this->url_param_obj = new URL_Parameter_Ajax($this->url_parse, $this->widget_tag,$this->root_folder);
              
              $tpl_indicator = $this->url_param_obj->get_page_tpl_indicator();
              if(!isset($CONFIG['page_index'])){ //assign the value
                 $CONFIG['page_index'] = $tpl_indicator; 
              }
              $filter_arr = $this->url_param_obj->get_sidebar_data_filter();
              if($filter_arr && $this->side_bar_obj){
                 $this->side_bar_obj->set_sidebar_checked_status($filter_arr); 
              }
              
           }
                    
       }
       
       
      public function __destruct() {
           ;
       }
      
      public function dispatch(){
           $this->view = new Page_View($this->url_param_obj,$this->side_bar_obj);
           $this->view->display();
      }
      
     
     public function show_listing_search_sidebar(){
          if($this->side_bar_obj){
              $this->view = new Page_View($this->url_param_obj,$this->side_bar_obj);
              $this->view->print_script();
              $this->view->show_listing_search_sidebar();
          }
     }
     
     public function show_listing_sidebar_widget(){
       if($this->side_bar_obj){
              $this->view = new Page_View($this->url_param_obj,$this->side_bar_obj);
              $this->view->print_script();
              $this->view->show_listing_sidebar_widget();
          }
         
     }
     /*****************BELOW INTERNAL*******************************************/
 
      
       private function redirect_check(){
          $var_uri_str = trim($_SERVER['REQUEST_URI'],'/');
          $url_split = explode($this->root_folder, $var_uri_str);
          
          if(isset($url_split[1]) and empty($url_split[1])){ // listing root folder
              //redirect to default listing url
              $this->redirect_search_default_url();
              exit();              
          } elseif(isset($url_split[1])) {
            $url_parse = trim($url_split[1],'/'); 
             /*check whether it is old listing url like  http://www.where.ca/listings/activities-tours/historic-sites/upper-fort-garry-gate-wh/ 
              * $url_parse = 'activities-tours/historic-sites/upper-fort-garry-gate-wh'
              */ 
            $seo_url_cells = explode('/',$url_parse);
            // For compatiable with old detail listing url
            //check if belong to old listing url, if yes, redirect to new detail listings url 
            if(count($seo_url_cells)==3){
                 $listing_slug_maybe =  $seo_url_cells[2];
                 $ret_cat_arr = $this->check_valid_listing($listing_slug_maybe);
                 if($ret_cat_arr !== false){
                      $this->redirect_old_detail_listing_url($ret_cat_arr,$listing_slug_maybe);
                  }
             }else if(count($seo_url_cells)==1){
                  if(isset($_REQUEST['category'])) {
                     $region_id   = $_REQUEST['category'];
                     $catid = $_REQUEST['type'];
                  } else if(isset($_REQUEST['type'])) {
                     $region_id   = $_REQUEST['type'];
                     $catid = $_REQUEST['catids'];
                  }
                 
                 if($region_id){
                    $this->redirect_old_search_url($region_id,$catid); 
                }
             }
            
          } 
          if($this->root_folder == 'root'){
              $this->url_parse = trim($url_split[0],'/');
          } else if(isset($url_split[1])){ //only $url_split[0]
             $this->url_parse = trim($url_split[1],'/'); 
          } 
          
       }
       
       private function redirect_url($url){
           if(!empty($url)){
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$url);
           } else {
               $this->redirect_default_url();
           } 
       }
     
       
       private function redirect_old_search_url($region_id,$catid){
         //like old url http://www.where.ca/listings/?type=3492&catids=3687&limit=0,15&kws=  
         $region_name_slug  = Config_Control::get_sidebar_region_slug($region_id);
         if($catid){
            if($region_name_slug =='canadianrockies'){
               $sub_region_slug = Config_Control::get_sidebar_sub_region_slug($catid);
            } else {
               $main_cat_slug = $this->get_sidebar_cat_slug_by_id($catid);
            }
         }
         $url_redirect =  "/".$this->root_folder."/".$region_name_slug."/";
         if($sub_region_slug){
           $url_redirect .= $sub_region_slug."/";
         } 
         if($main_cat_slug){
           $url_redirect .= $main_cat_slug."/";
         }
         $this->redirect_url($url_redirect);
       }
       
       
       private function redirect_search_default_url(){
           $url_redirect =  "/".$this->root_folder."/".$this->defult_region_root."/";
           $this->redirect_url($url_redirect);
       }
       
       
       private function get_sidebar_cat_slug_by_id($catid){
          $cat_search_url  = Config_Control::get_service_url()."/listingcategory/?o=json&catids=".$catid;  
          $return_json =  file_get_contents($cat_search_url);
          $cat_info_arr  =  json_decode($return_json, true);
          $cat_title = $cat_info_arr[0]['current']['title'];
          if($cat_title){
             $cat_slug = generate_slug($cat_title);
             return $cat_slug;
          }
       }
       
       private function check_valid_listing($listing_slug){ //need to be put URL_Parameter ?? ?????
          $listing_search_url  = Config_Control::get_service_url()."/listingbc/?o=json&slug=".$listing_slug;  
          $return_json =  file_get_contents($listing_search_url);
          $listing_info_arr  =  json_decode($return_json, true);
          if(count($listing_info_arr)>0)
              return $listing_info_arr[0];
          else return false;
       }
       
       
       private function redirect_old_detail_listing_url($listing_info_arr,$listing_slug){
           global $CONFIG;
           $redirect_url = "/".$this->root_folder;
           foreach($listing_info_arr as $level=>$v){
              if($level==0)continue; //as where total have 5 level category, need last 4 level to build detail listing url
              else if($level==1){
                $v['friendlyurl'] = $CONFIG['base_region_root'][$v['id']];  
              }
              $redirect_url .="/".$v['friendlyurl']; 
           }
           $redirect_url.='/'.$listing_slug.'/';
           $this->redirect_url($redirect_url);
       }
       
   }

?>
