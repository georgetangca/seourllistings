<?php

if(!function_exists('generate_slug')) :
function generate_slug($str) {
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
            $clean = strtolower(trim($clean, '-'));
            $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
            return $clean;
}
endif;


if(!function_exists('HomePageURL')) :
function HomePageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"];
 }
 return $pageURL;
}
endif;

if(!function_exists('curPageURL')) :
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].dirname($_SERVER["SCRIPT_NAME"]);
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].dirname($_SERVER["SCRIPT_NAME"]);
 }
 return $pageURL;
}
endif;

 // Lock a file, and write if lock was successful
  if(!function_exists('lock_and_write')) :
   function lock_and_write($file, $body, $append = 0) {
        
	ignore_user_abort(1);

	$mode = ($append == 1) ? "a" : "w";

	if ($fp = fopen($file, $mode)) {
		if (flock($fp, LOCK_EX)) {
			fwrite($fp, $body);
			flock($fp, LOCK_UN);
			fclose($fp);
			ignore_user_abort(0);
                       return "";
		} else {
			fclose($fp);
			ignore_user_abort(0);
                       return "no_lock";
		}
	} else {
		ignore_user_abort(0);
                return "no_write";
	}
  }
 endif; 
  
 if(!function_exists('show_wp_post_title_link')) :
   
 //for show the wordpress category post title/link 
 function show_wp_post_title_link($cat, $tag=NULL){
   //$args = 'category_name='.$cat.'&posts_per_page=5';
   $args = array (
      'category_name' =>$cat 
      ,'orderby' => 'date'
      ,'order' => 'DESC'
      ,'posts_per_page'=>'5' 
   );
   
   $the_query = new WP_Query( $args );
  // The Loop
    while ( $the_query->have_posts() ) : $the_query->the_post();
         ?>   
            <li>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </li>
   <?php         
    endwhile;
   // Reset Post Data
    wp_reset_postdata();
  }
 endif;

if(!function_exists('getListingURL')) :
function getListingURL($slug, $catlevel1slug, $catslug) {
    global $CONFIG;
    $listingSlug = $CONFIG['listing_detail_url'];
    if($catslug != null && $catslug != "") {
        $listingSlug = str_replace("__CAT_SLUG__", $catslug, $listingSlug);
    } else {
        $listingSlug = str_replace("__CAT_SLUG__/", "", $listingSlug);
    }
    
    if($catlevel1slug != null && $catlevel1slug != "") {
        $listingSlug = str_replace("__CAT_LEVEL1_SLUG__", $catlevel1slug, $listingSlug);
    } else {
       $listingSlug = str_replace("__CAT_LEVEL1_SLUG__/","", $listingSlug);
    }
    
    $listingSlug = str_replace("__SLUG__", $slug, $listingSlug);
    
    
    
    $listingSlug = 'http://'.$_SERVER["SERVER_NAME"].'/'.NEW_LISTING_FOLDER.$listingSlug;
    
    return $listingSlug;
}  
endif;
 
if(!function_exists('show_nearby_listing_base_cat')) :
//define for TOL show "Nearby"
function show_nearby_listing_base_cat($listing_slug, $catid){
    global $CONFIG;
    $nearby_service_url = $CONFIG['service_url']."/".$CONFIG['site_slug']."/listingnearby/?slug=".$listing_slug."&catids=".$catid."&limit=5";
    $neaby_tmp  =  file_get_contents($nearby_service_url);
    $neaby_list_arr = json_decode($neaby_tmp, true);
    
    if(empty($neaby_list_arr['nearby'][$catid]))return;
    
    $title = (isset($neaby_list_arr['nearby'][$catid][0]['catpartitle'])? $neaby_list_arr['nearby'][$catid][0]['catpartitle']: RESTAURANTS); //show parent title 
    //var_dump($neaby_list_arr['nearby'][$catid]);
  ?>  
     <div class="stitle"><h1>NEARBY <?php echo $title; ?></h1></div>
            <div id="nearby" class="items">
                  <ul>
                   <?php    
                   $i=0;
                   foreach($neaby_list_arr['nearby'][$catid] as $val) {
                    
                   $listing_detail_url =  getListingURL($val['friendlyurl'], $val['cat_slug'], $val['catpart_slug']); 
                   ?>
                     <tt><a class="nearby_title" href="<?php echo $listing_detail_url; ?>"  target= "_parent" > <?php echo $val['title']; ?></a>
                         <img src="<?php echo CUR_URL_PATH;?>/images/star<?php echo str_replace('.','_',$val['rating']);?>.gif" alt="rating <?php echo $val['rating'];?>" />
                     </tt>
                   <?php    
                     }
                  ?>   
                  </ul>    
            </div>
 <?php    
 }
 endif;
 
 
 if(!function_exists('show_other_nearby_dest_title_link')) :
 function show_other_nearby_dest_title_link($listing_slug, $catids){
    //show other local dest for TL detail page on sidebar 
    global $CONFIG;
    if(empty($catids)) return;
    $local_des_service_url = $CONFIG['service_url']."/".$CONFIG['site_slug']."/listingnearby/?&r=runion&slug=".$listing_slug."&catids=".$catids;
    $local_des_tmp  =  file_get_contents($local_des_service_url);
    $local_des_tmp_list_arr = json_decode($local_des_tmp, true);
    if(empty($local_des_tmp_list_arr['nearby'])) return;
  ?>  
   <div class="stitle"> <h1>OTHER LOCAL DESTINATIONS</h1></div>
   <div id="other_dest" class="items" >
     <?php    
     foreach($local_des_tmp_list_arr['nearby'] as $val) {
         $listing_detail_url =  getListingURL($val['friendlyurl'], $val['cat_slug'], $val['catpart_slug']); 
 
     ?>
     <tt><a class="other_des_title" href="<?php echo $listing_detail_url; ?>"  target= "_parent" ><?php echo format_cut_title($val['title'],10); ?></a>
     </tt>
    <?php    
     }
    ?>
   </div>
  <?php 
  }
 endif;
 
 if(!function_exists('show_other_nearby_listing_base_cat')) :
 //define for where show "what's nearby"
 function show_other_nearby_listing_base_cat($listing_slug, $catids, $limit=10){
    global $CONFIG;
    $nearby_service_url = $CONFIG['service_url']."/".$CONFIG['site_slug']."/listingnearby/?r=runion&slug=".$listing_slug."&catids=".$catids."&limit=".$limit;
    $neaby_tmp  =  file_get_contents($nearby_service_url);
    $neaby_list_arr = json_decode($neaby_tmp, true);
    
    if(empty($neaby_list_arr['nearby']))return;
    
  ?>  
     <div class="stitle"><h1>What's NEARBY</h1></div>
     <div id="nearby" class="items">
          <ul>
           <?php    
           
           foreach($neaby_list_arr['nearby'] as $val) {
             if($val['friendlyurl']==$listing_slug) continue;
             
             $listing_detail_url =  getListingURL($val['friendlyurl'], $val['cat_slug'], $val['catpart_slug']); 
           ?>
              <p class="cat_title"><?php echo $val['category']; ?></p>
              <p class="summary">
               <a class="nearby_title" href="<?php echo $listing_detail_url ;?>"  target= "_parent" > <?php echo $val['title']; ?></a>
              </p>
              <p class="address"><?php echo $val['address1'].'&nbsp;'.$val['address2'].'<br>'.$val['phone'];?></p></br>
           <?php    
             }
          ?>   
          </ul>    
    </div>
 <?php    
 }
 endif;
 

if(!function_exists('show_randlisting_base_cat')) : 
 function show_randlisting_base_cat($listing_slug,$catid){
    global $CONFIG;
    //show other 
    //Notes: need to change here only for TL resturant !!!!!!
    $other_service_url = $CONFIG['service_url']."/".$CONFIG['site_slug']."/randlistings/?exclude=".$listing_slug."&limit=5&catids=".$catid;
    $other_tmp  =  file_get_contents($other_service_url);
    $other_list_arr = json_decode($other_tmp, true);
    if(empty($other_list_arr))return;
    $title = (isset($other_list_arr[0]['cat1_title'])? $other_list_arr[0]['cat1_title']: ""); //show parent title 
    $par_title = (isset($other_list_arr[0]['parcat1_title'])? $other_list_arr[0]['parcat1_title']: ""); //show parent title 
     
    ?>
    <div class="stitle">
        <h1>OTHER <?php echo $title;?> </h1>
    </div>
    <div id="other" class="items">
           <?php 
             foreach($other_list_arr as $val) {
                $listing_detail_url =  getListingURL($val['friendly_url'], $val['cat1_slug'], $val['parcat1_slug']); 
           ?>
             <tt><a class="nearby_title" href="<?php echo $listing_detail_url; ?>" target= "_parent" ><?php echo $val['title']; ?></a>
                 <img src="<?php echo CUR_URL_PATH;?>/images/star<?php echo str_replace('.','_',$val['editorsstarrating']);?>.gif" alt="rating <?php echo $val['editorsstarrating'];?>" />
             </tt>
           <?php    
             }
          ?>   

        
     </div>  
 <?php
    } 
endif;


 if(!function_exists('show_newreview_title_link')) :
   
 //for show the latest review 
 function show_newreview_title_link($site_slug, $catid, $cur_slug){
    //show the latest review link 
    global $CONFIG;
    $newreviews_service_url = $CONFIG['service_url']."/".$site_slug."/toplistings/?catids=".$catid."&sort=lrv&rcmd=1&limit=10&exclude=".$cur_slug;
    $newreviews_tmp  =  file_get_contents($newreviews_service_url);
    $newreviews = json_decode($newreviews_tmp, true);
    
    if(is_array($newreviews)and count($newreviews) > 0 ) {
  ?>  
    <h1> NEW RESTAURANT REVIEWS</h1>
     <?php    
     foreach($newreviews as $val) {
         $listing_detail_url =  getListingURL($val['friendly_url'], $val['cat1_slug'], $val['parcat1_slug']); 
          
     ?>
     <li><a class="newreview_title" href="<?php echo $listing_detail_url; ?>"  target= "_parent" ><?php echo format_cut_title($val['title'],10); ?></a>
     </li>
    <?php    
     }
  }
  }
 endif;
 
    
 if(!function_exists('show_sidebar_recommendedlist')) : 
 function show_sidebar_recommendedlist($catid=''){
     
    global $CONFIG;
    
    $recd_service_url = $CONFIG['service_url']."/".$CONFIG['site_slug']."/randlistings/?rcmd=1&limit=10&catids=".$catid;
    $tmp  =  file_get_contents($recd_service_url);
    $recd_list_arr = json_decode($tmp, true);
    if(empty($recd_list_arr)) return;
  ?>  
   <div class="stitle helptip"> <h1><?php echo $CONFIG['site_name'] ?> recommends</h1></div>
   <div class="helpDesc hdWHRecListing" style="display: none;">Recommend by Where</div>
   <div id="recommended" class="items" >
     <?php    
     foreach($recd_list_arr as $val) {
          $listing_detail_url =  getListingURL($val['friendly_url'], $val['cat1_slug'], $val['parcat1_slug']); 
      
     ?>
     <div class="recom_item">
         <p class="cat_title"><?php echo $val['cat1_title']; ?> </p>
         <p class="recom_url">
          <a class="other_des_title" href="<?php echo $listing_detail_url; ?>"  target= "_parent" ><?php echo $val['title']; ?></a>
         </p>
         <p class="address">
            <?php echo $val['address'].'&nbsp;'.$val['address2'].'</br>'.$val['phone']; ?> 
         </p>
     </div>
    <?php    
     }
    ?>
   </div>
  <?php  
 }
 endif;
 
 
 if(!function_exists('show_best_items')) :
 function show_best_items($show_arr){
    if(empty($show_arr)) return;
    
    foreach($show_arr as $title=>$item_arr) {
    ?>    
        <h1><?php echo $title;?></h1>
        
    <?php
        foreach($item_arr as $key=>$val){
      ?>    
            <tt>
                <a href="<?php echo $val; ?>" title="<?php echo $key ; ?>"><?php echo $key; ?></a>
            </tt> 
      <?php     
       }
     ?>  
     
     <?php
    }
  }
 endif;  
 
/**
 * Set the check status, search_default status for the sidebar array
 * Example
 * $build_sidebar_array =array (
  'Accommodations' => 
  array (
    'title_name' => 'Accommodations',
    'list_type' => '1',
    'default_show_num' => 5,
    'param' => 'category',
    'group_name' => 'cateogory|3489',
    'search_default' => 1,
    'show_all' => '1',
    'category_id' => 3976,
    'list_data' => 
    array (
      0 => 
      array (
        'id' => 5619,
        'name' => 'Extended Stay',
        'count' => '19',
        'checked' => 1,
      ),
      1 => 
      array (
        'id' => 3977,
        'name' => 'Hotel',
        'count' => '76',
        'checked' => 0,
      ),
      2 => 
      array (
        'id' => 5621,
        'name' => 'Motel',
        'count' => '2',
        'checked' => 0,
      ),
    ),
  )  
 )
 * 
 * 
 */ 

if(!function_exists('tune_result')) :
  /*****************Clean the array for sidebar before to showing ********************************/
  function tune_result(&$result_arry, $param_type=BUILD_CATEGORY){
     global $catid_filter,$nhood, $custom_fields,$CONFIG; 
     switch($param_type){
         case BUILD_DATA_DONE: //data ready from config file directly
             foreach($result_arry as $val){
               // $val['checked'] = check_custom_fields_checked($val['id']);
               $return_arr[] = $val;
            }
             break;
         
         case BUILD_SINGLE_CUSTOM_FIELD:
         case BUILD_ALL_CUSTOM_FIELD:
             foreach($result_arry as $val){
               $tmp_arr = array(); 
               $tmp_arr['id'] = $val['id_alt'];
               
               if(strpos($val['id'],'checkbox') !== false){ //check box 
                    $tmp_arr['name'] = $val['name'];
               } else { //drop down //list box 
                   $tmp_arr['name'] = $val['value'];
               }
               
               $tmp_arr['value'] = $val['value'];
               $tmp_arr['count'] = $val['count'];

              // $tmp_arr['checked'] = check_custom_fields_checked($tmp_arr['name'],$tmp_arr['id']);
            
               $return_arr[] = $tmp_arr;
            }
          break;
          
          case BUILD_HOOD:
            foreach($result_arry as $val){
               $tmp_arr = array();
               $tmp_arr['id'] = $val['id'];
               $tmp_arr['name'] = $val['name'];
               $tmp_arr['count'] = $val['count'];
               if(strpos(strtolower($val['name']),'out of town') !==false){
                  $tmp_arr['name'] = preg_replace('/- Out of Town/i', '', $val['name']);
                  $tmp_arr['out_of_town'] = 1; 
               }
              // $tmp_arr['checked'] = check_hood_fields_checked($tmp_arr['id']);  
               $return_arr[] = $tmp_arr;
            }
           break;
           
         case BUILD_LINK_CATEGORY:
              $url_link = dirname($_SERVER['PHP_SELF']);
              foreach($result_arry as $val){
                   $tmp_arr = array();
                   $tmp_arr['id'] = $val['id'];
                   $tmp_arr['name']  = $val['name'];
                   $tmp_arr['count'] = $val['count'];
                   $url_addix= "";
                   
                   if(array_key_exists($val['id'], $CONFIG['sidebar_mapping'])){
                       $mapping_str =  $CONFIG['sidebar_mapping'][$val['id']];
                       $url_addix = implode("-", explode(" ", strtolower($mapping_str))); 
                   }
                   
                   if(!empty($url_addix)){
                      $tmp_arr['url']   = $url_link.'/'.$url_addix.'/';
                   } else {
                   $tmp_arr['url']   = $url_link.'/?category='.$val['id'];
                   }
                   
                   $return_arr[] = $tmp_arr;
              }
             break;
             
          
          case BUILD_CATEGORY: 
              foreach($result_arry as $val){
                   $tmp_arr = array();
                   $tmp_arr['id'] = $val['id'];
                   $tmp_arr['name']  = $val['name'];
                   $tmp_arr['count'] = $val['count'];
             //      $tmp_arr['checked'] = check_cats_fields_checked($tmp_arr['id']);  
                   $return_arr[] = $tmp_arr;
              }
              break;
            
            default:
                $return_arr  = $result_arry;
               break; 
                
              
      }
     
      return $return_arr;
  }
  endif;
  
  if(!function_exists('format_rating_class')) :
  function format_rating_class($rating) {
        $sortArray = explode(".", $rating);
        $star_class_name = "star rating";
        if(isset($sortArray[0])){
          $star_class_name .= $sortArray[0];  
        }
        if (isset($sortArray[1])){
           $star_class_name .= "_".$sortArray[1]; 
        }
        
        return $star_class_name;
}
endif;
 

if(!function_exists('format_cut_title')) : 
function format_cut_title($title, $title_keep_len){
     if ($title_keep_len < 3 ) return;

     if (strlen($val['title'])> $title_keep_len) {
         $display = substr($title, 0, $title_keep_len-3);
         $display .= "...";  
     } else {
        $display = $title;
     }

     return $display;
}
endif;

if(!function_exists('build_breadcrum_string')) : 
function build_breadcrum_string($json_arr){
     global $CONFIG;
     if(!is_array($json_arr) or empty($json_arr)) return;
     $breadcrumbString = "";
     $SJM_searchTypeFolder = $CONFIG['listing_folder'];
    
    $arr = $json_arr[0]; //always get the first one
    //here need to take care of mutliple group category 
    $len_cnt = count($arr);
    $url_str = $SJM_searchTypeFolder.'/';
    foreach($arr as  $index =>$cat) {
        if($breadcrumbString != "") {
            $breadcrumbString .= "&nbsp;&#62;&nbsp;";
        }

        if($index == 0) {
            continue;
        }
        
        $internal_slug = generate_slug($cat['title']);
        
        if (in_array( $internal_slug, $CONFIG['rockies_sub_region_root'])){
            $url_str .='canadianrockies/';
        } 
        
        if($index==3) {
          $url_str .= '#/?filter=['.$internal_slug.']';  
        } else {
           $url_str .= $internal_slug.'/';
        } 
        
        $breadcrumbString .= "<a href='".$url_str."'\">".$cat['title']."</a>";
    }
     
     return $breadcrumbString;
}
endif;

if(!defined('get_page_index')):
function get_page_index($index){
    global $mapping_config;
    $cur_page_index = false;
    foreach($mapping_config as $key=>$val_arr) {
        if(in_array($index,$val_arr)){
            $cur_page_index = $key;
            break;
        }        
    }    
    return $cur_page_index;    
}
endif;


if(!function_exists('get_url_param_value')) : 
function get_url_param_value($param){
     $value = NULL;
     if(isset($_POST[$param]) && !empty($_POST[$param])) {
         $value = stripslashes($_POST[$param]);
     } elseif (isset($_GET[$param]) && !empty($_GET[$param])){
         $value = stripslashes($_GET[$param]);
     }     
     return $value;
}
endif;

 
 ?>
