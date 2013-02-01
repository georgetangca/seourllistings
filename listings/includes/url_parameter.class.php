<?php
       
  abstract class URL_Parameter {
       protected $_root_folder;
       protected $url_indicator = URL_SEARCH_PAGE,$url_param_str;
       protected $region_name_slug,$region_catid,$sub_region_name_slug, $sub_region_catid;
       protected $main_cat_arr,$sub_cat_arr, $keyword, $nhood,$sort,$order,$page_number;
       protected $listing_slug; //for detail page
       protected $widget_tag;
       
       abstract protected function parse_url_as_semantic_param();
       abstract protected function pase_search_page_url();
       abstract protected function pase_detail_page_url();
       abstract protected function parse_cat_infor($cat_arr);
      
       public function __construct($url_str, $widget_tag,$root_folder) {
           $this->widget_tag = $widget_tag; 
           $this->_root_folder = $root_folder;
           if($this->widget_tag == SIDEBAR_WIDGET_ONLY){
              $this->url_indicator = URL_SHOW_WIDGET;
           }
           if(!empty($url_str)){
               $this->url_param_str = $url_str;
               $this->parse_url_as_semantic_param();
               if($this->url_indicator == URL_INVALID){
                   echo("<pre>Invlaid URL</pre>");
               };             
           }
           
           
       }
       
       public function __destruct() {
           ;
       }
       
       public function get_page_tpl_indicator(){
         $region_name = $this->region_name_slug;
         $tpl_indicator = Config_Control::get_tpl_id_from_region_slug($region_name);
         return $tpl_indicator;
      }
      
      public function get_page_url_indicator(){
           return $this->url_indicator; 
      }
       
       public function get_sidebar_data_filter(){
            if($this->widget_tag == SIDEBAR_WIDGET_COMB){ //if widget only ,no need to set the filter
                  $filter_arr =  array(
                      'sub_region_cat'=>array($this->sub_region_name_slug => $this->sub_region_catid),
                      'main_cat'=> $this->main_cat_arr,
                      'sub_cat' => $this->sub_cat_arr,
                      'keyword' => $this->keyword,
                      'nhood'   => $this->nhood,
                      'sort'    => $this->sort,
                      'order'   => $this->order,
                      'page'    => $this->page_number
                  ); 
            }
            return $filter_arr;
       } 
       

       protected function set_theme_page_indicator($page_tag='page_listing'){
           global $wh_theme_2012;
           $wh_theme_2012->set_page_inicator($page_tag);
           $wh_theme_2012->set_page_region_infor_by_id($this->region_catid); 
       }
      

       public function get_url_indicator(){
          return  $this->url_indicator;
       }
       
       
       public function get_region_catslug(){
           return $this->region_name_slug; 
       }
       
       public function get_sub_region_catslug(){
           return $this->sub_region_name_slug; 
       }
       
       public function get_region_catid(){
           return $this->region_catid;
           
       }
       
       public function get_sub_region_catid(){
           return $this->sub_region_catid;
           
       }
       
       public function get_detail_listing_slug(){
           return $this->listing_slug;
       }
   

   
      public function check_valide_region($region_slug){
           global $CONFIG;
           if(in_array($region_slug,$CONFIG['base_region_root'])){
               return true;
           } else {
               return false;
           }
           
       }
       
       protected function check_valide_sub_region($sub_region_slug){
           global $CONFIG;
           if($this->region_name_slug == "canadianrockies") {
               if(in_array($sub_region_slug,$CONFIG['rockies_sub_region_root'])){
                   return true;
               } else {
                   return false;
               }
          }
       }
       
      
      
   }

?>
