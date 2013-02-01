var loadmap = [];
$(document).ready(function($){
  window.generate_slug = function generate_slug($str,$divider){
        var $split_str = $str.toLowerCase();

        if(typeof $divider != 'undefined'){
            $split_str = $split_str.split($divider);
        }else {
            $split_str = $split_str.split('-++');
        }

        var $return_str = '';
        for(var i=0; i< $split_str.length;i++){

            $clean = $split_str[i].replace(/[^a-zA-Z0-9\/_|+ \-&]/g, '');
            $clean = $clean.trim('-');
            $clean = $clean.replace(/[\/_|+ &]+/g, '-');
            $clean = $clean.replace(/[-]+/g, '-');

            if(i==0){
                $return_str = $clean;
            }else if(typeof $divider != 'undefined'){
                    $return_str += $divider+$clean; 
            }
        }
        return $return_str;    
    }


   window.ajax_redirect_listing = function ajax_redirect_listing(){
        get_sidebar_filter();

        var seo_friendly_url_arr =   seo_url_str.split(">");
        var seo_url = '';
        for(var i=0; i < seo_friendly_url_arr.length; i++){
            clean = seo_friendly_url_arr[i];
            clean = clean.toLowerCase().trim();
           // clean = clean.trim();
            if(clean =="canadian rockies"){
               seo_url += '/'+'canadianrockies'; 
            } else if(clean !="all"){
               slug = generate_slug(clean);
               seo_url += '/'+slug;
            }
        }

        seo_url +='/';
        /*
        var filter = build_call_filters_except_sidebar();
        var filter_obj = {};
        var pairs = filter.split('&');
        for(i in pairs){
            if (i=='0') continue; //as filter reurn as &limit=&kws=, ignore the first &
            var split = pairs[i].split('=');
            filter_obj[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
        }


        var keyword_url,sort_url,order_url,page_url;

        $.each(filter_obj, function(index, value){
           if(index=='kws'){
               keyword_url = '/keyword/'+value;
           }else if(index=='sort'){
               sort_url = '/sort/'+value;

           }else if(index=='order'){
               order_url = '/order/'+value;
           } else if(index=='limit'){
              var limit_split_arr = value.split(',');
              page_url = '/page/'+ (parseInt(limit_split_arr[0])+1);

           } 
        });

        seo_url += sort_url + order_url + keyword_url+page_url; 
        */
        window.location = searchpage_home_URL+seo_url;    
    }

    window.fuli_load_listing_on_click = function fuli_load_listing_on_click(){ //for server full 
        get_sidebar_filter();

        var seo_friendly_url_arr =   seo_url_str.split(">");
        var seo_url = '';
        for(var i=0; i < seo_friendly_url_arr.length; i++){
            clean = seo_friendly_url_arr[i];
            clean = clean.trim();
            clean = clean.toLowerCase().trim();
            if(clean !="all"){
               slug = generate_slug(clean);
               seo_url += '/'+slug;
            }
        }

        seo_url +='/';

        var filter = build_call_filters_except_sidebar();
        var filter_obj = {};
        var pairs = filter.split('&');
        for(i in pairs){
            if (i=='0') continue; //as filter reurn as &limit=&kws=, ignore the first &
            var split = pairs[i].split('=');
            filter_obj[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
        }



        $.each(filter_obj, function(index, value){
           if(index=='kws'){
               var keyword_url = '/keyword/'+value;
           }else if(index=='sort'){
               var sort_url = '/sort/'+value;

           }else if(index=='order'){
               var order_url = '/order/'+value;
           } else if(index=='limit'){
              var limit_split_arr = value.split(',');
              var page_url = '/page/'+ (parseInt(limit_split_arr[0])+1);

           } 
        });

        seo_url += sort_url + order_url + keyword_url+page_url;

        window.location = searchpage_home_URL+seo_url;

    }

    window.loadListings = function loadListings(forward){
        var filters = getFilters(); 
        update_cookie();//set the cookie first
        loadListings_contetns(filters);
    }

    /*************************************************/

    function build_sort_area(order, sortColumn){
        var sort_class="sa";
        var sort_title="ascending";

        if (order=='desc') {
           sort_class="sd";
           sort_title="descending";
        }

        if (!$.isEmptyObject(sort_title_arr)) {
        var Sort_str='<div id="sort_i">';
          for(var i=0; i<sort_title_arr.length; i++) {
            Sort_str+='<span class="st"><a class="sort_button';
            if (sortColumn==sort_title_arr[i].title) Sort_str+=' '+sort_class;
            Sort_str+='" title="sort by '+sort_title_arr[i].title+' - ';
            if (sortColumn==sort_title_arr[i].title){
                Sort_str+=sort_title;            
            } else {
                Sort_str+=sort_title_arr[i].seq;
            }

            Sort_str+='" id="sort_opt_'+i+'">'+'SORT RESULTS BY '+sort_title_arr[i].title.toUpperCase()+'</a>';
            if (i<(sort_title_arr.length-1)) Sort_str+=' |';
            Sort_str+='</span>';
          }
            Sort_str+='</div>';
          $('#sort_options').html(Sort_str);
        }
    }

    function build_call_filters_except_sidebar(){
        var filter='';

        //***** still need to do page

        var page_num = 0;
        if($('#page_num').length > 0){ 
            page_num = parseInt($('#page_num').val());
            if(page_num >=1) {
               page_num = page_num -1; 
            }
        } 

        var page_offset = parseInt(page_num) * parseInt(num_per_page);

        filter += '&limit='+page_offset+','+num_per_page;

        if ($("#listing_sort").length > 0) { //if sort item exists 
            var sort = $('#listing_sort').val();
            var sortArray = sort.split("_");
            var sortColumn =''
            var order ='';

            if(sortArray[0] != '') {
               sortColumn = sortArray[0];//notes!!! need to match the columm name        
            }

            if(sortArray[1] != null) {
                order = sortArray[1];
            }

            build_sort_area(order, sortColumn);

            switch(sortColumn){
               case 'name':
                   sortColumn = 'title';
                   break;
               case 'type':
               case 'cuisine':
                   sortColumn = 'cat1title';    
                   break;

               case 'photo':
                   sortColumn = 'image';    
                   break;
            }

            filter += '&sort='+sortColumn+"&order="+order;
        }

        filter += '&kws='+ encodeURIComponent($.trim($('#keyword').val()));

        return filter;
    }

    window.loadSort = function loadSort(sort_string, sort_id) { //this function is fired when the sort is clicked
        $('#page_num').val(1); //reset the page
        if (!sort_id) { //no sort_id passsed, use "" as default
            var sort_id = '';
        }

        var sort_list = { //build list of possible sort options
            'name_asc': 'sort by name - descending',
            'name_desc': 'sort by name - ascending',
            'type_desc': 'sort by type - ascending',  //note: cusine map to the listing cat1
            'type_asc': 'sort by type - descending'
        };

        var sort_parm = "";
        $.each(sort_list, function (key, value) { //look for selected sort option in list
            if (value == sort_string) {
                sort_parm = key;
            }
        });

        $('#listing_sort').val(sort_parm); //update form with new sort field

        var sort_list_r = { //build list of reversed sort options
            'name_desc': 'sort by name - descending',
            'name_asc': 'sort by name - ascending',
            'type_asc': 'sort by type - ascending',
            'type_desc': 'sort by type - descending'
        };

        if (sort_id != '') {
            $.each(sort_list_r, function (key, value) { //look for selected sort option in list
                if (key == sort_parm) { //update sort option with new direction
                    reversed_sort = value;
                    $('dl#sort_options dd a#' + sort_id).attr('title', reversed_sort);
                }
            });
        }
    }


    function build_call_sidebar_filters(filters){
         var url_str = '';
         var type_exist   = false; 

         var filters_object_array = JSON.parse(filters);

         for(var i=0; i< filters_object_array.length; i++){
             tag_match = true; 

         //for(var i=0; i< filters_object_array.length; i++){
             var value = filters_object_array[i];
             if (typeof value ==='object') { 
                var param = value.param;
                switch(param){
                  case 'hoodfields':
                      url_str += '&city=';
                  break;

                  case 'category':
                  case 'city':    
                     type_exist = true; 
                     url_str += '&catids=' 
                  break;

                  case 'pricefields':
                       url_str += '&price=';
                  break;    

                  case 'customfields':
                      url_str += '&custom=';
                      break;

                  case "userrating":
                     url_str += '&usr=';
                     break;

                  default: 
                     tag_match = false;
                     break;
                }

                if(tag_match == false) continue;

                var field_value = value.field_value;
                if(field_value instanceof Array){
                    for(var j=0; j<field_value.length; j++){
                        var data = field_value[j];
                        if(typeof data ==="object"){
                            var id   = field_value[j].id;
                            if(j > 0){
                                id = ','+id
                            }
                            url_str += id;

                            var value = field_value[j].value;
                            if ( typeof value != 'undefined'){
                             url_str += '|'+encodeURIComponent(value);   
                            }
                        }
                    }

                }

             }
         }

         if(type_exist == false){ //if no cuisine type selected, use the base cateogoy id 
            url_str += '&catids='+base_catid;
         }

         return url_str;
      }

   window.set_except_sidebar_status =  function set_except_sidebar_status(){
      var page = $.address.parameter('page');
      if(page){
        $('#page_num').val(page);
      } else{
        $('#page_num').val('1');
      }

      var sort =  $.address.parameter('sort');
      var order = $.address.parameter('order');
      if(sort && order){
          $('#listing_sort').val(sort+'_'+order);
      }

      var keyword = $.address.parameter('keyword');  
      if(keyword){
          keyword = decodeURIComponent(keyword);
          $('#keyword').val(keyword)
      }    
    }

    function updateFilterURL(seo_url_str, filters_except_sidebar){
       // filter_str = seo_url_str.replace(/&/g,' ');
       /*
        $.address.parameter('sort', '');
        $.address.parameter('order', '');
        $.address.parameter('keyword', '');
        $.address.parameter('page', '');
        $.address.parameter('filter', '');
       */
        var filter_arr =   seo_url_str.split(">");
        var filter_str = filter_arr[filter_arr.length-1];
        filter_str = generate_slug(filter_str,',');
        if(filter_str != 'all'){
            $.address.parameter('filter', encodeURIComponent('['+ filter_str +']'));
        } else {
            $.address.parameter('filter','');
        }


        var filter_obj = {};
        var pairs = filters_except_sidebar.split('&');
        for(i in pairs){
            if (i=='0') continue; //as filter reurn as &limit=&kws=, ignore the first &
            var split = pairs[i].split('=');
            filter_obj[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
        }

        $.each(filter_obj, function(index, value){
           if(index=='kws'){
               if(value != ''){
                $.address.parameter('keyword', encodeURIComponent(value))
               }else {
                   $.address.parameter('keyword', '')
               } 
           }else if(index=='sort'){
                if(value != ''){
                  if(value == 'title'){
                      value = 'name';
                  } else if(value == 'cat1title'){
                      value = 'type';
                  }  
                  $.address.parameter('sort', encodeURIComponent(value))
                } else {
                   $.address.parameter('sort', ''); 
                } 

           }else if(index=='order'){
               if(value != ''){
                  $.address.parameter('order', encodeURIComponent(value))
               } else {
                    $.address.parameter('order',''); 
               }
           } else if(index=='limit'){
              if(value != ''){
                    var limit_split_arr = value.split(',');
                    var page = parseInt(limit_split_arr[0]/parseInt(num_per_page))+1;
                    $.address.parameter('page', page);
               }else {
                 $.address.parameter('page', '');  
               } 
           } 
        }); 
    }


    function getFilters() { //get filter list from form
       //get the side bar filter
       var sidebar_filters =  get_sidebar_filter();
       var build_filters = build_call_sidebar_filters(sidebar_filters);
       var filters_except_sidebar = build_call_filters_except_sidebar();
       build_filters += filters_except_sidebar;

      //seo_url_str is global variable 
       updateFilterURL(seo_url_str,filters_except_sidebar);    
       return build_filters;
    }

    //For cookie maintainence 
    function update_cookie(){
       var curl=$(location).attr('href');
       $.cookie('where-url-cookie', curl, { expires : 30,path:'/'});
    }

    function loadListings_contetns(filter_string) { //call listings search and load page
        $("p.error_msg").empty().hide();
        $("#loading").show();

        var callJSON = call_service_script + filter_string;

        //sending any or all other values to the service.

        $.jsonp({
            url: callJSON,
            cache: false,
            async: true,
            dataType: "json",
            success: function (data) {
                var page_points = [];
                $("#loading").hide();
                $("#search_results").empty();

                if (data['listings'].length < 1) { //no listings
                    $("p.error_msg").empty().html("Your search returned no results.<br />Please try again.").show("fast");
                    var prev_page = "<li class='page_link no_link'></li>";
                    var next_page = "<li class='page_link no_link'></li>";
                    $("#listing_pages ul").empty().html(prev_page + next_page);
                    var current_display = "No Listings Found";
                    $("#listing_pages p").empty().html(current_display);

                    currentListsMap(page_points);

                } else { //listings found
                    var listing_cat;
                    var listing_sub_cat;


                    $.each(data['listings'], function (i, item) { //build listing summary for dispaly
                        if (item.parcat1slug != "") {
                            listing_cat = item.parcat1slug;
                        } else {
                            listing_cat = '';
                        }
                        if (item.cat1slug != "") {
                            listing_sub_cat = item.cat1slug;
                        } else {
                            listing_sub_cat = '';
                        }
                        //slugify category & sub_category name

                       var url = getListingURL(item.friendlyurl, listing_cat, listing_sub_cat); 

                       var title = "<a href='"+url+"' title='" + item.title + "' class='addr_title'>" + item.title + "</a><br />";

                        //alert(item.address2);
                        //alert(item.address2);
                       /*if (item.address=="") {
                           var address2 = item.address2;
                       } else {
                         var address2 = ", " + item.address2;
                        }

                        if (item.address2 || item.city == "") {
                            var address = "" + item.address + address2 + " " + item.city;
                        } else if (item.address == "") {
                            var address = "" + item.city;
                        } else {
                            var address = "" + item.address + address2 + " " + item.city;
                        }*/

                        var address = "";
                        address = item.address;
                        if (item.address2!='') {
                            if (item.address!='') {
                                address +=', ';
                            }
                            address +=item.address2;
                        }

                        var description = "";
                        if (item.phone != "") {
                            var phone = "<br /> <span class='phone_toggle'>" + item.phone + "</span>";
                        } else {
                            var phone = "";
                        }

                        var linfo           = address + " " + item.city + phone;

                        /*
                        var cuisine         = item.cuisine;
                        var neighbourhood   = item.neighbourhood;
                        var price           = item.price;
                        var rating          = item.rating;
                        */

                        var $stringData = '<li>'

                        $stringData += '<p class="';
                        if (item.recommended != null && item.recommended =='y') {
                           $stringData += 'wh helptip">Recommend by Where</p>';
                           $stringData +='<div class="helpDesc hdWHRecListing">Recommend by Where</div>';
                           $stringData +='<p class="wr';
                        } 
                        $stringData += 'address">';
                        $stringData +='<span class="show_cat">'+item.cat1title+'</span><br />';
                        $stringData += title + '</p>';

                        $stringData +='<p>' + linfo+'<br />';

                        if( parseFloat(item.latitude) != 0 || item.maptuning != ''){  
                           $stringData +=  '<button class="map_show" value="'+item.id+'">Map</button>';
                        }
                        $stringData += '</p>';

                        $stringData += '<div id="map_canvas_'+item.id+'" class="maplist"></div>';

                      //  if(config_index != 'cfg2') { //for rockies disable to show the nearby
                            $stringData += '<div id="map_nearby_'+item.id+'" class="mapnearby"><h3>What\'s Nearby</h3><ul>';

                            for (var key in catid_mapping) {
                                $stringData += '<li class="nearbys" tag="'+key+'"><span value="'+catid_mapping[key]['color']+'">&nbsp;</span>'+catid_mapping[key]['title']+'</li>';
                            }

                            $stringData += '<li><img src="http://'+globalMapMarker+'" alt="" /> <strong>= This Listing</strong></li>';
                            $stringData += '</ul></div>';
                      //  }
                        $stringData += '</li>';


                       $("#search_results").append($stringData);

                        var info_address = address + " " + item.city + " " + item.zipcode;
                        //var listing_slug = listing_cat + "/" + listing_sub_cat + "/" + item.friendly_url;
                        var listing_slug = item.friendlyurl;
                        var map_point = { 
                            slug: listing_slug,
                            catslug: listing_cat,
                            catlevel1slug: listing_sub_cat,
                            latitude: item.latitude,
                            longitude: item.longitude,
                            maptuning: item.maptuning,
                            zindex: i,
                            title: item.title,
                            address: info_address,
                            cattitle:item.cat1title,
                            catid:item.cat1,
                            parcatid:item.parcat1level1,
                            grandparentcatid:item.grandparcat1id
                       };

                       loadmap[item.id]=true;
                       service_points[item.id]=map_point;
                       page_points.push(map_point);

                       //showMap(service_points, item.id);
                    });
                    currentListsMap(page_points); //show the map on the right sidebar 
                    var page_range = ""; //build pagination
                    if (isNumber(data['current_page']) && isNumber(data['num_pages'])) {
                        if (data['current_page'] <= 3) {
                            //var prev_page = "<li class='page_link no_link prev_page'></li>";
                            var start_page = 1;
                            // prev_page start
                            if (data['current_page'] >= 2) {
                                var prev_page = "<li class='page_link prev_page'><a href='/page " + (data['current_page'] - 1) + "' title='Previous Page'>prev</a></li>";
                            } else {
                                var prev_page = "<li class='page_link no_link prev_page'>prev</li>";
                            } // end
                        } else {
                            var prev_page = "<li class='page_link prev_page'><a href='/page " + (data['current_page'] - 1) + "' title='Previous Page'>prev</a></li>";
                            if (data['current_page'] >= (data['num_pages'] - 2)) {
                                var start_page = data['num_pages'] - 4;
                            } else {
                                var start_page = data['current_page'] - 2;
                            }
                        }
                        if (data['current_page'] >= (data['num_pages'] - 2)) {
                            //var next_page = "<li class='page_link no_link prev_page'></li>";
                            var end_page = data['num_pages'];
                            if (data['current_page'] <= (data['num_pages'] - 1)) {
                                var next_page = "<li class='page_link next_page'><a href='/page " + (data['current_page'] + 1) + "' title='Next Page'>next</a></li>";
                            } else {
                                var next_page = "<li class='page_link no_link next_page'>next</li>";
                            }
                        } else {
                            var next_page = "<li class='page_link next_page'><a href='/page " + (data['current_page'] + 1) + "' title='Next Page'>next</a></li>";
                            if (start_page == 1 || start_page == 2) {
                                if (data['num_pages'] >= 5) {
                                    var end_page = 5;
                                } else {
                                    var end_page = data['num_pages'];
                                }
                            } else {
                                var end_page = data['current_page'] + 2;
                            }
                        }
                        for (var i = start_page; i <= end_page; i++) {
                            if(i > 0) {
                                if (data['current_page'] == i) {
                                    page_range = page_range + "<li class='page_link no_link current'>" + i + "</li>";
                                } else {
                                    page_range = page_range + "<li class='page_link no_link page_index'><a href='/page " + i + "' title='page " + i + "'>" + i + "</a></li>";
                                }
                            }
                        }
                        $("#listing_pages ul").empty().html(prev_page + page_range + next_page);
                    }
                    if (isNumber(data['current_page']) && isNumber(data['num_per_page']) && isNumber(data['total_listings'])) {
                        var num_per_page = data['num_per_page'];
                        var first_listing = ((data['current_page'] - 1) * num_per_page) + 1;
                        var last_listing = data['current_page'] * num_per_page;
                        if (last_listing > data['total_listings']) {
                            last_listing = data['total_listings'];
                        }
                        var current_display = "DISPLAYING " + first_listing + " - " + last_listing + " of " + data['total_listings'] + " LISTINGS";
                        $("p#search_results").empty().html(current_display);
                        $("#listing_pages p").empty().html(current_display);
                    }
                }
            },

            error: function (xhr, err, e) {
                $("#loading").hide();
                $("p.error_msg").empty().html("Apologies! We appear to have experienced a error connecting to our server. Please hit 'back' on your browser and try your search again!").toggle("fast");
            },

            beforeSend: function () {
                // Handle the beforeSend event
            },

            complete: function () {
                // Handle the complete event
                $('#search_return .listing_result').last().css('border-bottom', 'none');
            }
        });
    }

   
    window.check_canadian_rockie_pillar = function check_canadian_rockie_pillar(){
        var canadian_rockie_pillar;
        if($("#pillar_page_indicator").length>0){
            var pillar_page_inicator = $("#pillar_page_indicator").val();
            if($("#region_name").length>0){
             var region_name =  $("#region_name").val();
            }
        }

        if(pillar_page_inicator && region_name=='canadian rockies'){ //check on the canadian rockies pillar page
            canadian_rockie_pillar  = true; 
        } else {
            canadian_rockie_pillar = false; 
        }
        return canadian_rockie_pillar;
    }

    

    window.getListingURL = function getListingURL(slug,catslug,catlevel1slug) {
        var listingSlug = listingURL;
        if(catslug != null && catslug != "") {
            listingSlug = listingSlug.replace("__CAT_SLUG__",catslug);
        } else {
            listingSlug = listingSlug.replace("__CAT_SLUG__/","");
        }
        if(catlevel1slug != null && catlevel1slug != "") {
            listingSlug = listingSlug.replace("__CAT_LEVEL1_SLUG__",catlevel1slug);
        } else {
           listingSlug = listingSlug.replace("__CAT_LEVEL1_SLUG__/","");
        }
        return listingSlug.replace("__SLUG__",slug);
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function stripTags(html) {
        if (!html) {
            var html = '';
        }
        return html.replace(/<\/?[^>]+>/gi, '');
    };

})(jQuery)