<?php 
  // error_reporting(E_ALL);
  // ini_set('display_errors', '1');
   class Build_Sidebar {
       public $filter_arr = NULL;
       
       public function __construct($page_base_catid) {
          $this->tpl_indicator  = Config_Control::get_tpl_id_from_region_catid($page_base_catid);
          $this->page_base_catid = $page_base_catid;
          $this->build_sidebar_data();
       }
       
       public function __destruct() {
           ;
       }
       
       
       public function show_sidebar($t_icon=true,$forward=false){
           $this->build_side_bar($this->build_sidebar_array,$t_icon,$forward);
       }
       
       
      public function build_side_bar($sidebars=array(),$t_icon=true,$forward=false) {
        $sb_keys=array_keys($sidebars);
           if (is_array($sidebars[$sb_keys[0]]) && array_key_exists('list_data', $sidebars[$sb_keys[0]])) {
                echo '<div class="divline"> </div>';
                $sb_arr = $this->build_city_side_bar($sidebars,$t_icon,$forward);
                echo $sb_arr[0];
           } else {
                foreach($sidebars as $key=>$value) {
                   $sb_arr=array();
                   $sb_arr=$this->build_city_side_bar($value,$t_icon,$forward);
                   $cities=explode('|',$key);
                   
                   $sub_region_show = false;
                   $region_only_show = false;
                   if(isset($cities[2]) and $cities[2]=='s'){
                       $sub_region_show = true;
                       $region_only_show = true;
                   }
                   
                   if(!$sub_region_show and $sb_arr[1]=='e'){
                      $sub_region_show = true;
                   }
                 
                   echo '<div class="divline"> </div>';
                   echo '<div class="stitle"><h1>';
                   //if ($t_icon) echo '<span>['.(($sb_arr[1]=='e')?'&ndash;':'+').']</span> ';
                   if ($t_icon) echo '<span>['.(($sub_region_show ===true)?'&ndash;':'+').']</span> ';
                   
                   echo $cities[0].'</h1></div>';
                   echo '<div class="items" style="padding-left:10px;';
                   //echo ($sb_arr[1]=='c')?'display:none;':'';
                   echo ($sub_region_show===false)?'display:none;':'';
                   
                   echo '" id="cities_'.trim(str_replace(',','-',str_replace(' ','-',str_replace('_','-',$key)))).'">';
                   echo '<tt style="display:none;"><input '.(($region_only_show===true)?'checked="true"':'') .'type="checkbox" name="'.$cities[0].'||all" class="sitemchk allitemchk" value="city||'.$cities[1].'"';
                 //  if($sb_arr[2]==0) echo ' checked';
                   echo ' /><label><span>All</span></label></tt>';
                   echo $sb_arr[0];
                   echo '</div>';
               }
           }
        }
        
       private function build_city_side_bar($sidebars=array(),$t_icon=true,$forward=false) {
            //print_r($sidebars);
            $sidebar_str='';
            $ce='c';
            $ci_checked=0;
            foreach ($sidebars as $sidebar) {
                $ldcnt=sizeof($sidebar['list_data']);
                if ($ldcnt>$sidebar['default_show_num']&&$sidebar['default_show_num']>0) {
                   $lcnt=$sidebar['default_show_num'];
                   $showmore=true;
                } else {
                   $lcnt=$ldcnt;
                   $showmore=false;
                }
                switch($sidebar['list_type']) {
                    case 1:
                        $itype='checkbox';
                        break;
                    case 2:
                        $itype='radio';
                        $iname='';
                        break;
                    case 3:
                        $itype='link';
                        $iname='';
                        break;
                    default:
                        $itype='checkbox';
                        $iname='[]';
                        break;

                    }
                if (!$sidebar['parent_title']) {
                    $extend=true;
                    if ($sidebar['group_name']&&$sidebar['group_name']!='')
                      $extend=($sidebar['search_default']&&$sidebar['search_default']==1)?true:false;
                }

                if(!$sidebar['group_name']) $sidebar['group_name']='';
                if ($group_name!=$sidebar['group_name']&&$group_name!='') {
                    $sidebar_str.='<div class="divline"> </div>';
                }
                $group_name=$sidebar['group_name'];

                $sidebar_str.='<div class="stitle';
                if ($sidebar['parent_title']&&$sidebar['parent_title']!='') {
                    $sidebar_str.=' amen_filter';
                    if(!$extend) $sidebar_str.='" style="display:none;';

                }
                if ($extend) $ce='e';
                $sidebar_str.='"><h1>';
                if ($t_icon) $sidebar_str.='<span>['.($extend?'&ndash;':'+').']</span> ';
                $sidebar_str.=$sidebar['title_name'].'</h1></div>';
                $sidebar_str.='<div class="items';
                if ($sidebar['parent_title']&&$sidebar['parent_title']!='') $sidebar_str.=' amen_filter';
                $sidebar_str.='"';
                if(!$extend) $sidebar_str.=' style="display:none;"';
                if ($sidebar['group_name']&&$sidebar['group_name']!='') {
                    $sidebar_str.=' id="'.trim(str_replace(',','-',str_replace(' ','-',str_replace('_','-',$sidebar['group_name']))));
                    if ($sidebar['parent_title']&&$sidebar['parent_title']!='') 
                        $sidebar_str.='_'.trim(str_replace(',','-',str_replace(' ','-',str_replace('_','-',$sidebar['parent_title']))));
                    $sidebar_str.='_'.trim(str_replace(',','-',str_replace(' ','-',str_replace('_','-',$sidebar['title_name'])))).'"';
                }
                $sidebar_str.='>';

                if ($sidebar['show_all']&&$sidebar['show_all']=='1') {
                    if ($itype=='link') {
                        $sidebar_str.='<tt><label><span><a href="'.$sidebar['url'].'">All</a></span></label></tt>';
                    } else {
                       // $sidebar_str.='<tt><input type="'.$itype.'" name="'.$sidebar['title_name'].'||all" class="sitemchk allitemchk" value="'.$sidebar['param'].'||'.$sidebar['category_id'].'"'.(($sidebar['search_default']&&$sidebar['search_default']==1)?' thisallchecked':'').' /><label><span>All</span></label></tt>';
                        //George change here for category friendly_url
                        //generat url base $sidebar['title_name'];
                        
                        $friendly_slug = generate_slug($sidebar['title_name']);
                        $slug_value_init = 'slug="'.$friendly_slug.'"';
                        $sidebar_str.='<tt><input '.$slug_value_init.' type="'.$itype.'" name="'.$sidebar['title_name'].'||all" class="sitemchk allitemchk" value="'.$sidebar['param'].'||'.$sidebar['category_id'].'"'.(($sidebar['search_default']&&$sidebar['search_default']==1)?' thisallchecked':'').' /><label><span>All</span></label></tt>';
                    }
                }

                $i=0;
                $oot_str='';
                $more_str='';
                $si_checked=0;
                if (is_array($sidebar['list_data'])) {
                foreach ($sidebar['list_data'] as $ldata) {
                   if ($showmore&&$i==$lcnt&&$more_str=='') {
                    $more_str.='</div><div class="moreshow"'.((!$extend)?' style="display:none;"':'').'><a class="morebutton">+ SHOW MORE</a>';
                    $more_str.='<div class="moreitems"><h6>more '.$sidebar['title_name'].((strtolower(substr($sidebar['title_name'],strlen($sidebar['title_name'])-1))!='s')?'s':'').'</h6><a class="moreclose">CLOSE</a>';
                   }
                   
                   if ($itype=='link') {
                    if ($more_str!='') {
                      $more_str.='<tt><label><span><a href="'.$ldata['url'].'">'.$ldata['name'].'</a></span>';
                    }  else {
                      $sidebar_str.='<tt><label><span><a href="'.$ldata['url'].'">'.$ldata['name'].'</a></span>';
                    }
                   } else {
                        /*
                        if ($more_str!='') {
                            $more_str.='<tt><input type="'.$itype.'" name="'.$sidebar['param'].(($i>=$lcnt)?'_more':'').'" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk"'.((isset($ldata['checked'])&&$ldata['checked']==1)?' checked':'').' /><label><span>'.$ldata['name'].'</span>';
                            if (isset($ldata['checked'])&&$ldata['checked']==1) {
                                $sidebar_str.='<tt><input type="'.$itype.'" name="'.$sidebar['title_name'].'||'.$sidebar['param'].'_more" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk" checked /><label><span>'.$ldata['name'].'</span>';
                            }
                        } else {
                            $sidebar_str.='<tt><input type="'.$itype.'" name="'.$sidebar['title_name'].'||'.$sidebar['param'].(($i>=$lcnt)?'_more':'').'" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk"'.((isset($ldata['checked'])&&$ldata['checked']==1)?' checked':'').' /><label><span>'.$ldata['name'].'</span>';
                        }
                         */
                        //george change here for friendly_slug

                        $friendly_slug = generate_slug($ldata['name']);
                        $slug_value_init = 'slug="'.$friendly_slug.'"';
                        if ($more_str!='') {
                            $more_str.='<tt><input '.$slug_value_init.' type="'.$itype.'" name="'.$sidebar['param'].(($i>=$lcnt)?'_more':'').'" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk"'.((isset($ldata['checked'])&&$ldata['checked']==1)?' checked':'').' /><label><span>'.$ldata['name'].'</span>';
                            if (isset($ldata['checked'])&&$ldata['checked']==1) {
                                $sidebar_str.='<tt><input '.$slug_value_init.' type="'.$itype.'" name="'.$sidebar['title_name'].'||'.$sidebar['param'].'_more" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk" checked /><label><span>'.$ldata['name'].'</span>';
                            }
                        } else {
                            $sidebar_str.='<tt><input '.$slug_value_init.' type="'.$itype.'" name="'.$sidebar['title_name'].'||'.$sidebar['param'].(($i>=$lcnt)?'_more':'').'" value="'.$sidebar['param'].'||'.((isset($ldata['id'])&&$ldata['id']!='')?$ldata['id']:'0').((isset($ldata['value']))?'||'.$ldata['value']:'').'" class="sitemchk"'.((isset($ldata['checked'])&&$ldata['checked']==1)?' checked':'').' /><label><span>'.$ldata['name'].'</span>';
                        }
                     }
                     if ($more_str!='') {
                       if (isset($ldata['count'])) $more_str.=' ('.$ldata['count'].')';
                       $more_str.='</label></tt>';
                        if (isset($ldata['checked'])&&$ldata['checked']==1) {
                            if (isset($ldata['count'])) $sidebar_str.=' ('.$ldata['count'].')';
                            $sidebar_str.='</label></tt>';
                        }
                     } else {
                       if (isset($ldata['count'])) $sidebar_str.=' ('.$ldata['count'].')';
                       $sidebar_str.='</label></tt>';
                     }
                     $i++;
                     if (isset($ldata['checked'])&&$ldata['checked']==1) {$si_checked++;}
                   }
                }
                if ($si_checked>0) {
                    $sidebar_str=str_replace('thisallchecked','',$sidebar_str);
                } else {
                    $sidebar_str=str_replace('thisallchecked','checked',$sidebar_str);
                }
                $sidebar_str.=$more_str;
                if ($oot_str!='') {
                    if ($showmore&&$i<=$lcnt) {
                        $sidebar_str.='</div><div class="moreshow"><a class="morebutton">+ SHOW MORE</a>';
                        $sidebar_str.='<div class="moreitems"><h6>more '.$sidebar['title_name'].((strtolower(substr($sidebar['title_name'],strlen($sidebar['title_name'])-1))!='s')?'s':'').'</h6><a class="moreclose">CLOSE</a>';
                    }
                    $sidebar_str.='<br /><h6 style="padding-top:5px;">Out of Town</h6>'.$oot_str;
                }
                if ($showmore&&($i>$lcnt||$oot_str!='')) $sidebar_str.='</div>';
                $sidebar_str.='</div>';
                if($extend||$si_checked>0) $ci_checked++;
            }
            if ($forward==true) {
                $sidebar_str.='<input id="sbc_forward" type="hidden" value="1">';
            }
            return array($sidebar_str,$ce,$ci_checked);
        }
       
       
       private function build_sidebar_data(){
           $build_sidebar_array = array();
           $file_name  = Config_Control::get_cache_file_name($this->page_base_catid); // == region_id
                   
          if(Config_Control::check_cache_enable() and file_exists($file_name)){
               include_once($file_name);
           } else { 
          //build from scrach 
           $this->serviceURL =  $serviceURL   =  Config_Control::get_service_url()."/listingscount/?o=json";
    
          
           $sidebar_cfg = Config_Control::get_sidebar_cfg($this->tpl_indicator);
           if(!isset($sidebar_cfg['side_bar'])) exit;
           
           $sidebar_arr      = $sidebar_cfg['side_bar'];
           $base_template_id = $sidebar_cfg['template_id'];
           //$base_cat_id      = $sidebar_cfg['base_id'];
           
           $base_cat_id      = $this->page_base_catid;
          
           foreach($sidebar_arr as $val_arr) {
                $content_typ = $val_arr['content_type'];
                if($content_typ == BUILD_CATEGORY_GROUP){
                    $catid       = (isset($val_arr['base_id'])? $val_arr['base_id']: $base_cat_id);
                    $group_name  = $val_arr['build_required']['group_name'].'|'.$catid;
                    $this->process_cat_group($catid, &$build_sidebar_array, $catid_filter,$group_name);
                } else { //for canadianrockies
                    $this->process_side_bar_array($val_arr, &$build_sidebar_array, $base_cat_id, $base_template_id);
                }
           }

           if(count($build_sidebar_array)==1) {
               $build_sidebar_array = array_pop($build_sidebar_array);
           } else if($this->tpl_indicator == TPL_SEARCH_ROCKIES) { //canadianrockies , order the sequency
              $build_sidebar_tmp_array  = array();
              $rockie_sub_region_cat_mapping = Config_Control::get_rockies_sub_region_cat_mapping();
              foreach($rockie_sub_region_cat_mapping as $val => $region_slug) {
                  $val = strval($val);
                  foreach($build_sidebar_array as $key=>$element) {
                      if(strpos($key,$val) !==false){
                         $build_sidebar_tmp_array[$key] = $element;
                         break;
                      }
                  }          
               }
               unset($build_sidebar_array);
               $build_sidebar_array = $build_sidebar_tmp_array;
           }

           //cache the file 
         //  if(Config_Control::check_cache_enable()){
                if(file_exists($file_name)){
                        unlink("$file_name");
                }        
                $output_data = "";

                $output_data = "\n\$build_sidebar_array =".var_export($build_sidebar_array,true).";\n";
                lock_and_write("$file_name", "<?php\n".$output_data."\n?>");   
         //  }
         }//end for build sidebar raw data 
         
         $this->build_sidebar_array = $build_sidebar_array;
      }
      
      
      public function set_sidebar_checked_status($filter_arr){
        $this->filter_arr = $filter_arr;  
        $sidebar_arr = $this->build_sidebar_array;  
        $sidebar_filted = array();
        global $CONFIG;
        $cat_checked = false;
        foreach($sidebar_arr as $key_level1 => $val_array_level1){
            if(is_array($val_array_level1) and isset($val_array_level1['list_data'])){
                foreach($val_array_level1['list_data'] as $key_level_2 => $list_item){
                   if($this->check_sub_cats_fields_checked($list_item['id'])){
                       $sidebar_arr[$key_level1]['list_data'][$key_level_2]['checked'] = 1;
                       $sidebar_arr[$key_level1]['search_default'] = 1;
                       $cat_checked = true;
                   }
                }
                
                if($cat_checked === false){
                    if($this->check_main_cat_fields_checked($val_array_level1['category_id'])){
                        $sidebar_arr[$key_level1]['search_default'] = 1;
                        $cat_checked = true;
                    }
                } 
                if($cat_checked){
                    break;
                }
            } elseif(is_array($val_array_level1) and !isset($val_array_level1['list_data'])){ //for canadian rockies, 
                  //check it is has sub region listing sidebar
                 foreach($val_array_level1 as $key_level2 => $val_array_level2){
                       if(is_array($val_array_level2) and isset($val_array_level2['list_data'])){
                            if($this->check_main_cat_fields_checked($val_array_level2['category_id'])){
                                $sidebar_arr[$key_level1][$key_level2]['search_default'] = 1;
                                $cat_checked = true;
                            }
                            foreach($val_array_level2['list_data'] as $key_level_3 => $list_item){
                              if($this->check_sub_cats_fields_checked($list_item['id'])){  
                                $sidebar_arr[$key_level1][$key_level2]['list_data'][$key_level_3]['checked'] = 1;
                                $sidebar_arr[$key_level1][$key_level2]['search_default'] = 1;
                                $cat_checked = true;
                              }
                            }//end foreach
                        } //endif is_array 
                 } //end foreach
                 
                 //if the category/sub category not check , need check if the sub region is checked or not ?
                 if($cat_checked === false) {
                     $split_region_name =  explode('|',$key_level1);
                     if(isset($split_region_name[1])){
                         $region_id = $split_region_name[1]; 
                         $sub_region_checked = $this->check_sub_region_cats_fields_checked($region_id);
                         if($sub_region_checked){ //whole region checked
                            $sidebar_filted = $this->set_sidebar_sub_region_check_status($key_level1,$sidebar_arr);
                            $cat_checked = true;
                         }
                     }
                 } 
                 
                 if($cat_checked){break;}
            }
        }

        
        if(empty($sidebar_filted)){
            $this->build_sidebar_array =  $sidebar_arr;
             //if still not been filted, assing the current arr directly
         } else {
              $this->build_sidebar_array = $sidebar_filted;
         }        
    }
 
    
     private function set_sidebar_sub_region_check_status($key,$sidebar_arr){
          $sidebar_values   = array_values($sidebar_arr);
          $sidebar_keys     = array_keys($sidebar_arr);
          foreach($sidebar_keys as $index=>$key_level1){
              if($key_level1==$key){
                 $key_level1 .= "|s";
                 $sidebar_keys[$index] = $key_level1;
                 foreach($sidebar_keys as $key=>$value){
                     $sidebar_arr_tmp[$value] = $sidebar_values[$key];
                 }
                 break;
              }
          }
          return $sidebar_arr_tmp;
    }    

    
    
      private function check_main_cat_fields_checked($cat_id){
            $maincat_filter_arr = $this->filter_arr['main_cat'] ;
            if(empty($maincat_filter_arr) or empty($cat_id)) return 0;

            if(in_array($cat_id,$maincat_filter_arr) !==false){
                return 1;
            } else return 0;
      }
      
      private function check_sub_cats_fields_checked($cat_id){
           $subcat_filter_arr = $this->filter_arr['sub_cat'] ;
            if(empty($subcat_filter_arr) or empty($cat_id)) return 0;

            if(in_array($cat_id,$subcat_filter_arr) !==false){
                return 1;
            } else return 0;
          
      }

       private function check_sub_region_cats_fields_checked($cat_id){
            $subregioncat_filter_arr = $this->filter_arr['sub_region_cat'] ;
            if(empty($subregioncat_filter_arr) or empty($cat_id)) return 0;

            if(in_array($cat_id,$subregioncat_filter_arr) !==false){
                return 1;
            } else return 0;
       }    




      protected function process_side_bar_array($val, &$build_sidebar_array, $base_cat_id=NULL, $base_template_id=NULL){
         $serviceURL = $this->serviceURL;

         if(!is_array($val) or count($val) == 0 ) return;
            $sidebar_item = array();
            $content_typ = $val['content_type'];

            if(isset($val['rebuild']) and $val['rebuild']===false) { 
                ////directly get the data from config file, no need to get from service 
                $build_data_array = $val['list_data'];
                $return_array = tune_result($build_data_array, $content_typ);

            }else {
                $catid       = (isset($val['base_id'])? $val['base_id']: $base_cat_id);
                $site_template_id = (isset($val['template_id'])? $val['template_id']: $base_template_id);

                switch($content_typ){
                  case BUILD_HOOD:
                      $urlparam = "&r=nhood&curcatids=".$catid;
                      break;

                  case BUILD_CATEGORY:
                  case BUILD_LINK_CATEGORY:
                       $urlparam = "&r=subcats&pcatids=".$catid;
                      break;

                  case BUILD_SINGLE_CUSTOM_FIELD:
                     $cusom_field = $val['cusom_field'];
                     $urlparam = "&r=rcol&curcatids=".$catid."&sort=name&custom=".$cusom_field;
                     break;

                  case BUILD_ALL_CUSTOM_FIELD:
                     $urlparam = "&r=rcust&sort=showorder&order=DESC&curcatids=".$catid; 
                     break;

                  default:
                     break;

                }

                $service_url_tmp = $serviceURL.$urlparam;
                if(!empty($site_template_id)){
                    $service_url_tmp.="&tplid=".$site_template_id;
                }
                $buf = file_get_contents($service_url_tmp);
                $result_tmp_arr = json_decode($buf, true);
                $result_arr = $result_tmp_arr[$catid];

                $return_array = tune_result($result_arr, $content_typ);
            }

            if(count($return_array)== 0) return;

            $sidebar_item['title_name']  = $val['build_required']['title_name'];
            $sidebar_item['list_type']  = $val['build_required']['list_type'];
            $sidebar_item['default_show_num']  = $val['build_required']['default_show_num'];
            $sidebar_item['param']  = $val['build_required']['param'];
            if(isset($val['build_required']['group_name'])){
                 $sidebar_item['group_name'] = $val['build_required']['group_name'];

            }

            /* search default
            if(isset($val['build_required']['search_default'])){
                 $sidebar_item['search_default'] = $val['build_required']['search_default'];
            } 
             */
            /* Final check search_default set for each cateory, if data checked in the $return_array,
               but not set on the $val['build_required'], also need to set as search_default 
            */

            /* search default
            foreach($return_array as $val_arr){
               if(isset($val_arr['checked']) and $val_arr['checked']==1 ) {
                    $sidebar_item['search_default'] = 1;
                    break;
               } 
            }
            */

            if(isset($val['build_required']['show_all'])){
                 $sidebar_item['show_all'] = $val['build_required']['show_all'];
                 $sidebar_item['category_id'] = $val['build_required']['category_id'];
            }

            if(isset($val['build_required']['parent_title'])){
                 $sidebar_item['parent_title'] = $val['build_required']['parent_title'];
            }

            if(isset($val['sort_order'])){
              array_multisort($return_array);  
            }

            $sidebar_item['list_data'] = $return_array;
            $item_slug = $val['slug'];

            if(isset($val['build_required']['group_name'])) {
               $build_sidebar_array[$val['build_required']['group_name']][$item_slug] = $sidebar_item;   
            } else {
                $build_sidebar_array[$item_slug] = $sidebar_item;   
            }
       }


      protected function process_cat_group($cat_base, $build_sidebar_array, $catid_need_set = NULL, $group_name=NULL){
             $serviceURL = $this->serviceURL;
             $urlparam = "&r=subcats&pcatids=".$cat_base;
             $service_url_tmp = $serviceURL.$urlparam;

             $buf = file_get_contents($service_url_tmp);
             $result_tmp_arr = json_decode($buf, true);
             $result_arr = $result_tmp_arr[$cat_base];

             $index = 0;

             foreach($result_arr as $val){
                 $defult_set = 0; 
                 if(isset($catid_need_set)){
                      if($catid_need_set == $val['id']){
                        $defult_set = 1;
                      }
                  } elseif($index == 0){
                    // $defult_set = 1;
                  }

                  //build category area
                  $tmp_cfg_item =   array(
                              'build_required'=> array(
                                  'search_default' =>$defult_set 
                                  ,'group_name' => $group_name
                                  ,'title_name' => $val['name'] 
                                  ,'list_type'  => BUILD_CHECK_BOX
                                  ,'default_show_num' => 5 
                                  ,'show_all' =>'1'
                                  ,'category_id' =>$val['id']
                                  ,'param' => 'category' //should be unqiue
                              )   
                              ,'base_id' => $val['id']     //parent_id = 3489 ,toronto
                              ,'slug' => $val['name'] //just for internal use 
                              ,'content_type'=> BUILD_CATEGORY
                              ,'template_id' => NULL
                           ); 
                  $this->process_side_bar_array($tmp_cfg_item, &$build_sidebar_array);

                  //build custome area
                  if(isset($val['temlpate_id'])){ 
                      $tmp_cfg_custm_item =   array(
                              'build_required'=> array(
                                  'group_name' => $group_name
                                  ,'parent_title' => $val['name'] 
                                  ,'title_name' => "Features" 
                                  ,'list_type'  => BUILD_CHECK_BOX
                                  ,'default_show_num' => 0 
                                  ,'param' => 'customfields' //should be unqiue
                              ) 
                             ,'template_id' => $val['temlpate_id']
                             ,'base_id' => $val['id']     //parent_id = 3489 ,toronto
                             ,'slug' => 'feature' //just for internal use 
                             ,'content_type'=> BUILD_ALL_CUSTOM_FIELD

                           ); 

                        $this->process_side_bar_array($tmp_cfg_custm_item, &$build_sidebar_array);
                  }

                  $index++;
             }
        }

       
       
   } //end for class  



  
    
  
?>