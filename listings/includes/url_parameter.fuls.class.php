<?php
 class URL_Parameter_Fuls extends URL_Parameter {
      
       public function __construct($url_str,$widget_tag,$root_folder) {
           parent::__construct($url_str,$widget_tag,$root_folder);           
       }
       
       public function __destruct() {
           ;
       }
       
       
       /***********************************************************************
        *   Function parse_url_as_semantic_param
        *   As the search page url  /listings/region-slug[/sub-region-slug][/category-slug][/sub-cat-1-slug_sub-cat-2-slug...] 
        *   Detail page url  /listings/par-cat-slug/cat-slug/listing-slug/
        ***********************************************************************/
       protected function parse_url_as_semantic_param(){
          /* canadianrockies/sub_region_slug/category_slug/subcat1slug_subcat2slug_subcat3slug_.../sort/A/order/B/keyword/C/page/D
           * toronto/category_slug/subcat1slug_subcat2slug_subcat3slug_..../sort/A/order/B/keyword/C/page/D
           */
           $seo_url_cells = explode('/',$this->url_param_str);
           if(isset($seo_url_cells[0]) and $this->check_valide_region($seo_url_cells[0]) === true){
               if (true){ //check correct search page url   where.ca/listings/toronto/#/?category=accomodation&sub=
                //need to figure out how to check for the search url (1)check the final string, if it is valide listing slug  (2) ??  
                  $this->pase_search_page_url();
               } else { //maybe the listing detail page url
                  $this->pase_detail_page_url(); 
               }
           }  else {   
              $this->url_indicator = URL_INVALID;
           }
       }
       
       /***********************************************************
     *  Function : pase_detail_page_url()
     *  As Detail page: old url  /listings/city-slug/par-cat-slug/cat-slug/listing-slug/
     *                 
     */
      protected function pase_detail_page_url(){
           $seo_url_cells = explode('/',$this->url_param_str);
        
           if(count($seo_url_cells)==4){ //here should have 3 elements
              $this->url_indicator = URL_DEATIL_PAGE;
              $this->region_name_slug = $seo_url_cells[0];
              $this->region_catid = Config_Control::get_region_catid($seo_url_cells[0]);
              $this->set_theme_page_indicator('page_listing_detail');
              //???????here can assign the related initial parameter for the detail listings 
              //???????????????????????????????  
              $this->listing_slug = $seo_url_cells[3];
               
           } else {
               $this->url_indicator = URL_INVALID;
           }
       }
      
       protected function pase_search_page_url(){
            /**************************page******************************************/
          $page_split_arr =  explode('page/',$this->url_param_str);
          /*
           * $page_split_arr[0]= toronto/category_slug/subcat1slug_subcat2slug_subcat3slug_..../sort/A/order/B/keyword/C/
           * $page_split_arr[1] = D
           */
          if(isset($page_split_arr[1]) and intval($page_split_arr[1])){
              $this->page_number = intval($page_split_arr[1]);
          }
          /*******************************************************************/
          
         
          /**************************keyword******************************************/
          $keyword_split_arr =  explode('keyword/',$page_split_arr[0]);
          /*
           * $keyword_split_arr[0]= toronto/category_slug/subcat1slug_subcat2slug_subcat3slug_..../sort/A/order/B/
           * $keyword_split_arr[1] = C/ or C
           */
          if(isset($keyword_split_arr[1]) and !empty($keyword_split_arr[1])){
              $this->keyword = trim($keyword_split_arr[1], '/');
              
          }
          /**************************************************************************/ 
          
          
          /**************************order******************************************/
          $order_split_arr =  explode('order/',$keyword_split_arr[0]);
          /*
           * $order_split_arr[0]= toronto/category_slug/subcat1slug_subcat2slug_subcat3slug_..../sort/A/
           * $order_split_arr[1] = B/ or B
           */
          if(isset($order_split_arr[1]) and !empty($order_split_arr[1])){
              $this->order = trim($order_split_arr[1], '/');
          }
          /**************************************************************************/ 
          
          
          /**************************sort******************************************/
          $sort_split_arr =  explode('sort/',$order_split_arr[0]);
          /*
           * $sort_split_arr[0]= toronto/category_slug/subcat1slug_subcat2slug_subcat3slug_..../
           * $sort_split_arr[1] = A/ or A
           */
          if(isset($sort_split_arr[1]) and !empty($sort_split_arr[1])){
              $this->sort = trim($sort_split_arr[1] , '/');
          }
          /**************************************************************************/ 
          
           $seo_url_cells = explode('/',$sort_split_arr[0]);
           $cur_arr_head_value = array_shift($seo_url_cells);
           $this->region_name_slug = $cur_arr_head_value;
           $this->region_catid = Config_Control::get_region_catid($cur_arr_head_value);
           
           //continue parse
           if(isset($seo_url_cells[0])){
                if($this->check_valide_sub_region($seo_url_cells[0])){ 
                    $cur_arr_head_value = array_shift($seo_url_cells);
                    $this->sub_region_name_slug = $cur_arr_head_value; //candianrockies
                    $this->sub_region_catid = Config_Control::get_sub_region_catid($cur_arr_head_value);
                } 
           }
           
           $this->parse_cat_infor($seo_url_cells);
           
       }
       
        /***********************************************************************
      * Function: get the main_cat_id, sub_cat_id_arr assigned
      * url like category_slug/subcat1slug_subcat2slug_subcat3slug_..../
      * Parameter:  $cat_arr like array['category_slug','subcat1slug_subcat2slug_subcat3slug_....'] 
      * for both ajax url and server full url  
      */
      
      protected function parse_cat_infor($cat_arr){ 
          //base cat_id get direct sub category, check the correct sub category
          if(count($cat_arr)>0){ //having cat parameter
               $main_cat_slug = $cat_arr[0];
               if(isset($cat_arr[1])){
                   $sub_cats_slug_str = $cat_arr[1];
                   $sub_cats_slug_split_arr = explode('_',$sub_cats_slug_str);
               }
               $file_name  = Config_Control::get_cache_file_name($this->region_catid);
               if(file_exists($file_name)){
                  include($file_name);
                  $search_in_arr = $build_sidebar_array;
                  if(isset($this->sub_region_catid)){ //like canadianrockies
                    foreach($build_sidebar_array as $sub_region_index =>$sub_region_cat_contents){
                        if(strpos($sub_region_index,  strval($this->sub_region_catid))!==false){
                           $search_in_arr =  $sub_region_cat_contents;
                           break; 
                        }
                    }
                  }
                  
                  if(count($search_in_arr)>0){
                     foreach($search_in_arr as $main_cat_index =>$contents){ //main category
                         $slug = generate_slug($main_cat_index);
                         if($main_cat_slug == $slug){
                            $search_in_arr_detail  = $contents;
                            break;
                         }
                     } 
                  }
                  
                  if(count($search_in_arr_detail)>0){
                      if(isset($search_in_arr_detail['category_id'])){
                         $this->main_cat_arr[$main_cat_slug] =  $search_in_arr_detail['category_id'];
                      }
                      
                      if(isset($search_in_arr_detail['list_data']) and count($sub_cats_slug_split_arr)>0 ){
                         $sub_cat_in_arr = $search_in_arr_detail['list_data'];
                         
                         foreach($sub_cats_slug_split_arr as $need_search_slug) {
                             foreach($sub_cat_in_arr as $sub_cat_contents){
                                 $sub_cat_slug =  generate_slug($sub_cat_contents['name']);
                                 if($need_search_slug == $sub_cat_slug){
                                     $this->sub_cat_arr[$need_search_slug] = $sub_cat_contents['id'];
                                     break;
                                 }
                             }
                         }
                      }
                  }
               }
          } 
       }
       
       
       
       
 }
?>
