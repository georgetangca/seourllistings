<?php
 $page_base_catid = $this->_page_base_catid;
 $page_tpl_id     = $this->_page_tpl_id; 
 $region_name     = $this->_page_region_nameslug;
 $nearby_catid_mapping     = $this->_nearby_catid_mapping;
 $keyword = $this->_keyword;
 
?>
<script type="text/javascript" src="<?php echo CUR_URL_PATH;?>/js/search_on_ready.js?ver=2.0"></script>
<input type="hidden" id="region_name" value="<?php echo $region_name; ?>" />
<div id="page_container">
	
<div  id="results_container">    
<!--- start listings results -->

  <div id="results">
      <div id="listing_title">
       <h1>Search Results</h1>
       <h2 id="listing_stitle"></h2>
      </div>
       <p id="loading" style="display: none; text-align:center;">
        <img src="<?php echo CUR_URL_PATH;?>/images/spinner.gif">
       </p>
      <div id="listing_pages">
        <p></p>
        <ul></ul>
      </div>
      <div id="top_ads">
      </div>
             <input type="hidden" id="page_num" value="" />
             <div id="sort_options">
             </div>
             <input type="hidden" id="listing_sort" value="" />
            
        <p class="error_msg" style="display: none;"></p>
       

        <div id="listing_results">
            <?php if (count($CONFIG['mapping_tpl'][$page_tpl_id]['search_result_header'])> 0) { ?>
            <div id="result_header">
               <ul>
                <li class="title">
                    <?php  foreach($CONFIG['mapping_tpl'][$page_tpl_id]['search_result_header'] as $val) { ?>
                    <p class="<?php echo $val['class']; ?>"><?php echo $val['title'];?></p>
                    <?php } ?>
                </li>
              </ul>
             </div>
            <?php } ?>

         <ul id="search_results">
             
         </ul>
        
       </div> 
 
    <div id="listing_pages">
        <p></p>
        <ul></ul>
    </div>
    </div>
    
  
 </div><!-- end results container -->   
  <div id="menu">
      <div id="menu_bar">
        <?php $this->show_listing_sidebar_widget(); ?>
      </div>
      <div id="second-bar">
         <?php  show_sidebar_recommendedlist($page_base_catid); ?>
      </div>
   </div>
  <!-- end listings -->  
    </div><!-- #page_container -->           
