

(function($){
       window.showNearby =  function showNearby(id) {
        var cid_list=new Array();
        var cids='';
        var arr_count = 0;
        $('#map_nearby_'+id+' ul li.nearbys').each(function (i) { //put any checked preferences into the
            var p = $(this); //preference_list array
            if (p.hasClass('checked')) {
                var id_valus = p.attr("tag");
                cid_list[arr_count++] = id_valus;
                var color=p.children('span').attr("value").replace("0x","");
                p.children('span').css("background","#"+color);
            } else {
                p.children('span').css("background","#fff");
            }
        });
        if (arr_count>0) {
           cids=cid_list.join(',');
               var callJSON = call_nearby_service_url+'&slug='+service_points[id]['slug']+"&catids="+cids+"&limit=500";
                $.jsonp({
                    url: callJSON,
                    cache: false,
                    async: true,
                    dataType: "json",
                    success: function (data) {
                          var nearby_points = [];
                          nearby_points.push(service_points[id]);

                          $.each(data['nearby'], function (i, item) {
                              var icon='';
                              $.each(catid_mapping, function(id_index,cat_mapping_info){
                                  if(id_index.indexOf(i) !== -1){
                                      icon=catid_mapping[id_index]['icon'];
                                      return false;
                                  }

                              })

                              /*
                               if (catid_mapping[i]['icon']!='') {
                                    var icon=catid_mapping[i]['icon'];
                               } else {
                                    var icon='';
                               }
                               */

                               for(k=0;k<item.length;k++) {
                                var point=item[k];
                                if (point.address1=="") {
                                   var address2 = point.address2;
                                } else {
                                 var address2 = ", " + point.address2;
                                }

                                var nb_address = point.address1 + address2 + " " + point.city + " " + point.zipcode;
                               // var url = 'listing_detail.php?slug='+point.friendlyurl+'&tmp='+point.listingtemplateid;

                                var map_point = {
                                    slug: point.friendlyurl,
                                    catslug: point.catpart_slug,
                                    catlevel1slug: point.cat_slug,
                                    latitude: point.latitude,
                                    longitude: point.longitude,
                                    maptuning: point.maptuning,
                                    zindex: 1,
                                    title: point.title,
                                    address: nb_address,
                                    icon: icon,
                                    cattitle:point.category,
                                    catid:point.categoryid,
                                    parcatid:point.parentid,
                                    grandparentcatid:point.grandparcat1id
                                  };
                                  nearby_points.push(map_point);
                                }
                           });
                           showMap(nearby_points,id);
                      }
                });
        } else {
                var nearby_points = [];
                nearby_points.push(service_points[id]);
                showMap(nearby_points,id);

        }

    }
    
     $('.mapnearby ul li.nearbys').live('click', function (e){ 
            e.preventDefault();
            if ($(this).hasClass("checked")) {
                $(this).removeClass("checked");
            } else {
              $(this).addClass("checked");
            }
            var id = $(this).parent().parent().attr('id').toString().replace('map_nearby_','');
            showNearby(id);
     });
    
    
   
})(jQuery);