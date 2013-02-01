<?php
include( '../wp-load.php' );
include ('listing_load.php');
 
$page_controler = new Listing_Controler(SIDEBAR_WIDGET_COMB,'listings'); 

//must put get_header() after the page_controller setting 
get_header();
$page_controler->dispatch();
get_sidebar();
get_footer();

?>


