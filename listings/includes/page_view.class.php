<?php 
 class Page_View {
       private $_url_param_obj, $_page_tpl_id,$_url_id, $_page_base_catid,$_page_region_nameslug,$_page_region_name;
       private $_sidebar_obj;
       private $_listing_slug;
       private $_keyword;
      
       public function __construct($url_param_obj,$sidebar_obj=NULL) {
          $this->_url_param_obj = $url_param_obj;
          $this->_sidebar_obj = $sidebar_obj;
          $this->build_internal_data();
       }
     
       public function __destruct() {
           ;
       }
       
     
     public function print_script(){
          global $CONFIG;
      ?><script type="text/Javascript">
    var service_url = "<?php echo Config_Control::get_service_url();?>";
    var call_nearby_service_url = service_url+'/listingnearby/?callback=?';
    var call_service_script = service_url+ "/searchlistingsext/?callback=?";
    var catid_mapping = JSON.parse('<?php echo json_encode($this->_nearby_catid_mapping); ?>');
    var globalMapMarker  = "<?php echo $CONFIG['map_marker']; ?>";
    var globalMapShadow  = "<?php echo $CONFIG['map_shadow']; ?>";
    var num_per_page     = "<?php echo $CONFIG['search_per_page']; ?>";
    var config_index     = "<?php echo $this->_page_tpl_id; ?>";
    var base_catid       = "<?php echo $this->_page_base_catid; ?>";
    if( base_catid == 4063) { //rockies 
       base_catid += "5149,5080,5246,5071,4351,5066,4409,5097";  //need special process 
    }
    var url_region_prefix  = "<?php echo $CONFIG['base_region_root'][$this->_page_base_catid]; ?>"; 
    var searchpage_home_URL = "<?php echo LST_ROOT_URL; ?>"; 
    var listingURL = searchpage_home_URL+'/'+url_region_prefix+'/__CAT_SLUG__/__CAT_LEVEL1_SLUG__/__SLUG__/';
    
    var sort_title_arr   = JSON.parse('<?php echo json_encode($CONFIG['mapping_tpl'][$this->_page_tpl_id]['sort_title']); ?>');
    var breadcum_prefix  = "<?php echo $CONFIG['sidebar_mapping'][$this->_page_base_catid]; ?>"; 
    
    var service_points = [];
    </script>
    <link href='http://fonts.googleapis.com/css?family=Arvo&subset=latin' rel='stylesheet' type='text/css'>
    <link type="text/css" href="<?php echo CUR_URL_PATH;?>/lib/css/style.css" rel="stylesheet">
    <link type="text/css" href="<?php echo CUR_URL_PATH;?>/js/css/flick/jquery-ui-1.8.16.custom.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/jquery-1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="text/JavaScript" src="<?php echo CUR_URL_PATH;?>/js/jquery.address-1.2.2.min.js"></script>
    <script type="text/JavaScript" src="<?php echo CUR_URL_PATH;?>/js/deserialize.js"></script>
    <script type="text/JavaScript" src="<?php echo CUR_URL_PATH;?>/js/jquery.jsonp-2.1.4.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/google_map.js?ver=3.0"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/listing_search.js?ver=3.0"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/lib/js/nearby.js"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/lib/js/side_bar.js?ver=1.6"></script>
    <script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/jquery-cookie.js"></script><?php
      }
      
     
      private function build_internal_data(){
           $this->_listing_slug = $this->_url_param_obj->get_detail_listing_slug();
           $this->_page_tpl_id  = $this->_url_param_obj->get_page_tpl_indicator();
           $this->_url_id       = $this->_url_param_obj->get_page_url_indicator();
           $this->_page_base_catid = $this->_url_param_obj->get_region_catid();
           $this->_page_region_name     = $this->_page_region_nameslug = $this->_url_param_obj->get_region_catslug();
           if($this->_page_region_nameslug == 'canadianrockies'){
               $this->_page_region_name = 'canadian rockies';
           }
           $this->_nearby_catid_mapping = Config_Control::get_nearby_cat_mapping($this->_page_base_catid);
           $this->_search_url = LST_ROOT_URL.'/'.$this->_page_region_nameslug.'/';
           if(isset($_REQUEST['keyword'])) {
              $this->_keyword =  $_REQUEST['keyword'];
           }
       }
      
      public function display(){
        $this->print_script();
        if($this->_url_id == URL_SEARCH_PAGE){
           include(LST_ROOT_DIR.LST_VIEW.'/listing_search.tpl.php');  
        }else if($this->_url_id == URL_DEATIL_PAGE) {
           include(LST_ROOT_DIR.LST_VIEW.'/listing_detail.tpl.php');  
        }
      }
      
      public function show_listing_search_sidebar(){
          $sidebar_builder = $this->_sidebar_obj;
          if($sidebar_builder){
              $sidebar_builder->show_sidebar();
          }
      }
      
      public function show_listing_sidebar_widget(){
        ?><div id="search_title">
            <p class="search_title_search">Search</p>
            <p class="search_title_city"><?php echo $this->_page_region_name;?></p>
          </div>
           <div id="search_form">
                <form action="<?php echo $this->_search_url ;?>" method="post" id="sform">
                    <input type="hidden" id="page_url_id" value="<?php echo $this->_url_id; ?>" />
                    <input id="keyword" type="text" name="keyword" value="<?php echo $this->_keyword; ?>" placeholder="NAME OR KEYWORD" /><input type="button" id="search_submit" />
                    <?php if($this->_url_id == URL_DEATIL_PAGE ) { ?>
                       <p id="go_back"> 
                            <a href="#">Back to search results</a>
                       </p>
                    <?php } ?>
                </form>
               <script type="text/javascript">
            //   $(document).ready(function ($) {
                    $('#search_submit').live('click',function(e){
                           e.preventDefault();
                           if($('#page_url_id').val() == 'search' )   
                           loadListings();
                           else {  
                            $("#sform").submit();
                          }  
                      });

                     $('input[type=text]').live('keypress', function(e) {
                          if(e.which == 13) {
                           e.preventDefault();
                           if($('#page_url_id').val() == 'search' )   
                           loadListings();
                           else {  
                            $("#sform").submit();
                            }  
                          }
                       });
                       
                      $('#go_back a').click(function(e){
                           e.preventDefault();
                           var curl = $.cookie('where-url-cookie');
                           if(typeof curl != undefined){
                              window.location = curl; 
                           }
                      });

               //  })(jQuery)   
                </script>   

           </div>
          <?php if($this->_url_id != URL_DEATIL_PAGE ) { ?>
           <div class="cat-list"><?php
               $this->show_listing_search_sidebar();
           }
           ?>
           </div>
          
           <?php
      }
       
      
       
       
   } //end for class  
    
  
?>