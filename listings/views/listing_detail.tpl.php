<?php
$listing_slug   =  $this->_listing_slug; 
$page_base_catid = $this->_page_base_catid;
global $CONFIG;
if(!empty($listing_slug)) {
    //show breadcrum on the top of the page 
    $breadcrumb_url  = Config_Control::get_service_url()."/listingBC/?slug=".$listing_slug;
    $breadcrumb_json =  file_get_contents($breadcrumb_url);
    $breadcrumb_arr  =  json_decode($breadcrumb_json, true);
    $breadcrumbString=  build_breadcrum_string($breadcrumb_arr);
    
    $listing_cat        = (isset($breadcrumb_arr[0][3]['id'])? $breadcrumb_arr[0][3]['id']: NULL); //where have 4 level category 
    $listing_cat_title  = (isset($breadcrumb_arr[0][3]['title'])? $breadcrumb_arr[0][3]['title']: NULL );
    
    
    $listing_par_cat        = (isset($breadcrumb_arr[0][1]['id'])? $breadcrumb_arr[0][1]['id']:NULL);
    $listing_par_cat_title  = (isset($breadcrumb_arr[0][1]['title'])? $breadcrumb_arr[0][1]['title']:NULL);
    
    
    //show the detail page 
    $template_url = $CONFIG['listing_url']."/".$listing_slug.".html?w2";
    $rendered_template =  file_get_contents($template_url);
  
}

?>
<script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/detail_on_ready.js?ver=2.0"></script>
<input type="hidden" id="region_name" value="<?php echo $CONFIG['sidebar_mapping'][$listing_par_cat]; ?>" />
<input type="hidden" id="region_event_cat" value="<?php echo $CONFIG['listing_cat_to_event_id_mapping'][$listing_par_cat] ;?>" />
<div id="page_container">
	
    <div id="results_container">    
    <!--- start listings detail results -->
      <div id="results">
            <p id="listing_bread-crumbs">
            <?php echo($breadcrumbString);?>
            </p>
            
            
            <div id="details">
            <?php 
             if($rendered_template){
              echo($rendered_template);
            }
            ?>
           </div> 
        </div>
    </div><!-- end results container -->
     <div id="menu">
      <div id="menu_bar">
        <?php $this->show_listing_sidebar_widget(); ?>
      </div>
      <div id="second-menu">
              <?php
               show_other_nearby_listing_base_cat($listing_slug, $listing_par_cat,10);
             ?>
      </div>
    </div>
  <!-- end listings -->  

<!--</div> strange thing for listing detail  -->  <!-- #page_container -->           

<script type="text/javascript">
  $(document).ready(function($){
     $("#rsb-events-calendar h1").text('<?php echo $CONFIG_LOCAL['sidebar_mapping'][$cur_page_base_id]; ?> Events Calendar');
     $("#rsb-events-calendar").css({"display":"block", "margin-top":"30px"});
     
  })(jQuery);     

</script>

