
$(document).ready(function($){
    
  window.showMap = function showMap(locations, index) {
        var map_zoom;
        var latlng;

        if (locations.length == 1) {
            map_zoom = 14
            var beach = locations[0];
            if (beach.maptuning && beach.maptuning != '') {
                var x = beach.maptuning.indexOf(',');
                var str_lat = parseFloat(beach.maptuning.substr(0, x));
                var str_lng = parseFloat(beach.maptuning.substr(x + 1));
                latlng = new google.maps.LatLng(str_lat, str_lng);
            } else {
                latlng = new google.maps.LatLng(beach.latitude, beach.longitude);
            }
       } else {
            map_zoom = 11;
            latlng = new google.maps.LatLng(43.67, -79.40);
       }

       /* If it is canaidian rockie pillar page ,overwrite the zoom */
       var canadian_rockie_pillar = check_canadian_rockie_pillar();
       if(canadian_rockie_pillar){
           map_zoom = 8;
       }

       var mapoptions = {
            zoom: map_zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
       };

       var map = new google.maps.Map(document.getElementById("map_canvas_"+index), mapoptions);
       setMarkers(map, locations);      
    }

    function setMarkers(map, locations) {
        // Add markers to the map
        var image = new google.maps.MarkerImage('http://' + globalMapMarker,
                                                new google.maps.Size(24, 43),
                                                new google.maps.Point(0, 0),
                                                new google.maps.Point(0, 43)
                                            );
        var shadow = new google.maps.MarkerImage('http://' + globalMapShadow,
                                                new google.maps.Size(39, 29),
                                                new google.maps.Point(0, 0),
                                                new google.maps.Point(0, 29)
                                            );
        var shape = {
            coord: [1, 1, 1, 29, 24, 29, 24, 1],
            type: 'poly'
        };

        var bounds = new google.maps.LatLngBounds();
        var beach;
        var str_lat;
        var str_lng;
        var myLatLng;
        var x;
        var infowindow = new google.maps.InfoWindow();

        // create the markers
        for (var i = 0; i < locations.length; i++) {

            if($("#pillar_page_indicator").length > 0 && i ==0 ) {
               continue; //no need to set the marker for the central point on the pillar page
            }


            beach = locations[i];
            if (beach.maptuning && beach.maptuning != '' && beach.maptuning != '0') {
                x = beach.maptuning.indexOf(',');
                str_lat = parseFloat(beach.maptuning.substr(0, x));
                str_lng = parseFloat(beach.maptuning.substr(x + 1));
                myLatLng = new google.maps.LatLng(str_lat, str_lng);
            } else {
                myLatLng = new google.maps.LatLng(beach.latitude, beach.longitude);
            }
                    //alert(beach[1] + "/" + beach[2] + "/" + beach[3] + "/" + beach[4] + "/" + beach[5] + "/" + beach[6]);
            if (beach.icon&&beach.icon!='') {
                image = new google.maps.MarkerImage('http://' + beach.icon,
                                                new google.maps.Size(24, 43),
                                                new google.maps.Point(0, 0),
                                                new google.maps.Point(0, 43)
                                            );
            }
            if (beach.maptuning || (beach.latitude && beach.longitude && beach.latitude != 0 && beach.longitude != 0 )) {
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    shadow: shadow,
                    icon: image,
                    shape: shape,
                    title: beach.title,
                    zIndex: beach.zindex
                });
                // Extend the LatLngBound object
                bounds.extend(myLatLng);
                // do this to force "function closure" on the event listner
                var markerHTML = "<p><span class='map_cat'>" + beach.cattitle + "</span>"+"<br />";
                markerHTML += "<strong>" + beach.title + "</strong><br />" + beach.address;
                if (!beach.detailpage) { 
                    markerHTML+= "<br /><a href=\""+getListingURL( beach.slug,beach.catslug,beach.catlevel1slug)+"\"><strong>Click here for more information.</strong></a>";
                }
                markerHTML+="</p>";
                urlMarker(marker, getListingURL( beach.slug,beach.catslug,beach.catlevel1slug), markerHTML, map, infowindow);

            }
        }
        // Extend map to fit markers if we have map markers
        if (locations.length > 1) {
            map.fitBounds(bounds);
        }
    }

    function urlMarker(marker, url, html, map,infowindow) {
        /*google.maps.event.addListener(marker, 'click', function () {
            //map.setZoom(1);
            //window.location.href = url;
        });*/
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });
       /* google.maps.event.addListener(marker, "close", function () {
            infowindow.close();
        });*/
    }
    
    window.currentListsMap = function currentListsMap(locations) {
        if (locations.length == 1) {
            var map_zoom = 14
            var beach = locations[0];
            if (beach[3] && beach[3] != '') {
                x = beach[3].indexOf(',');
                str_lat = parseFloat(beach[3].substr(0, x));
                str_lng = parseFloat(beach[3].substr(x + 1));
                var latlng = new google.maps.LatLng(str_lat, str_lng);
            } else {
                var latlng = new google.maps.LatLng(beach[1], beach[2]);
            }
        } else {
            var map_zoom = 11
            var latlng = new google.maps.LatLng(43.67, -79.40);
        }
        var mapoptions = {
            zoom: map_zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("cl-map"), mapoptions);
        setMarkers(map, locations);
    }

})(jQuery)