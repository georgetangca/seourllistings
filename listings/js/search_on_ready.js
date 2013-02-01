$(document).ready(function ($) {
    //clearParms();
      //  $(this).attr("title", " Search Results | Where.ca - Canada's Travel Planner");
        //side bar click function here
        $("#current-list-map").css("display","block");
        
        set_sidebar_filter_status(); 
        set_except_sidebar_status(); 
      
        loadListings();
       
        $("div#sort_options .st a").live('click',function (e) { //Sort Options
            e.preventDefault();
            loadSort($(this).attr('title'), $(this).attr('id'));
            //$("dl#sort_options dd a").removeClass("sortby");
            //$(this).addClass("sortby");
            var csa = $(this).hasClass("sd");
            $("div#sort_options .st a").removeClass("sd");
            $("div#sort_options .st a").removeClass("sa");
            if(csa) {
                $(this).addClass("sa");
            } else {
                $(this).addClass("sd");
            }
            loadListings();
        });



        $('#listing_pages li a').live('click', function (e) { //Pagination
            e.preventDefault();
            var current_url = $(this).attr('href');
            if (($.browser.msie) & ($.browser.version.substr(0,1) == 7)) {
                current_url = current_url.replace(current_url.substring(0, current_url.lastIndexOf("/") + 1), '');
            }
            new_page = current_url.replace('/page ', '').replace('page%20', '');
            $('#page_num').val(new_page);
            loadListings();
            $('html, body').animate({
                scrollTop: $("#page").offset().top
            }, 50); //scroll to top of list
        });


        $("#reset_btn").live('click', function (e) { //Reset Form
            e.preventDefault();
            //clearParms();
            $("#keyword").val('');
            loadListings();
        });
        
        /*
        $('input[type=text]').live('keypress', function(e) {
          if(e.which == 13) {
            e.preventDefault();
            loadListings();
          }
        });
        */
        $('.map_show').live('click', function (e){
            e.preventDefault();
            var text = $(this).text();
            var show_map = text == 'Map';
            var id = $(this).attr("value");
            if(show_map&&loadmap[id]) {
                var current_point=[];
                current_point.push(service_points[id]);
                showMap(current_point, id);
                loadmap[id]=false;
            }
            $('#map_canvas_'+id).css('margin-left', show_map ? '0' : '-9999px');
            $('#map_canvas_'+id).css('position', show_map ? 'relative' : 'absolute');
            $(this).text(show_map ? 'Hide' : 'Map');
            $('#map_nearby_'+id).toggle("slow");
        });

       $('.helptip').live('mouseover', function (e){
          e.preventDefault();
            var hdDiv;
          if ($(this).next('div.helpDesc').length) {
              hdDiv=$(this).next('div.helpDesc');
          }  else {
               hdDiv=$(this).parent().next('div.helpDesc');
          }
          hdDiv.css("display","block");
      });

      $('.helptip').live('mouseout', function (e){
          e.preventDefault();
          var hdDiv;
          if ($(this).next('div.helpDesc').length) {
              hdDiv=$(this).next('div.helpDesc');
          }  else {
               hdDiv=$(this).parent().next('div.helpDesc');
          }
          hdDiv.css("display","none");
      });

})(jQuery);