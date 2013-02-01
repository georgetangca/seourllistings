$(document).ready(function ($) {
    
     if (!($.isEmptyObject(service_points))) {
      showCurrentMap();
       var stringData = '<h3>What\'s Nearby</h3><ul>';
       for (var key in catid_mapping) {
             stringData += '<li class="nearbys" tag="'+key+'"><span value="'+catid_mapping[key]['color']+'">&nbsp;</span>'+catid_mapping[key]['title']+'</li>';
       }
       stringData += '<li><img src="http://'+globalMapMarker+'" alt="" /> <strong>= This Listing</strong></li>';
       stringData += '</ul>';
       $('.mapnearby').html(stringData);
       
       $('.maplist').css('margin-left', '0');
       $('.maplist').css('position', 'relative');
       $('.mapnearby').css("display","block");

     }
  
      $('.helptip').mouseover(function(){
          $(this).next('div.helpDesc').css("display","block");
      });

      $('.helptip').mouseout(function(){
          $(this).next('div.helpDesc').css("display","none");
      });

        var region_cat = $('#region_event_cat').val();
        $( "#sdate" ).datepicker({showOn: "button",buttonImage: "/images/calendar.gif", buttonImageOnly: true,dateFormat: 'mm/dd/yy',
                    onSelect: function(selectedDate) {
                    var instance = $(this).data("datepicker");
                    var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    $("#edate").val('');
                    $("#date2").val('');
                    $("#date1").val(selectedDate);
                    $("#edate").datepicker("option", "minDate", date);
                    return false;
                    }
                });
        $( "#edate" ).datepicker({showOn: "button",buttonImage: "/images/calendar.gif", buttonImageOnly: true,dateFormat: 'mm/dd/yy',
                   onSelect: function(selectedDate) {
                    $("#date2").val(selectedDate);
                    return false;
                    }
                });

        $("#events-calendar" ).datepicker({
           dateFormat: 'mm/dd/yy',
           inline: true,
           showOtherMonths: true,
	   selectOtherMonths: true,
           onSelect: function(date) {
                   $("#events-calendar #ui-datepicker-div td").removeClass("highlight");
                   $(this).prevAll("td:not(.ui-datepicker-unselectable)").addClass("highlight");
                   $('#sdate').val('');
                   $('#edate').val('');
                   $("#date1").val(date);
                   $("#date2").val(date);
                   window.location.href = '/events/#/?sdate='+encodeURIComponent(date)+'&edate='+encodeURIComponent(date)+'&category='+region_cat;
           }
         });

         $("#date_event_range").live('click', function (e) { //Pagination
             e.preventDefault();
             window.location.href = '/events/#/?sdate='+encodeURIComponent($("#date1").val())+'&edate='+encodeURIComponent($("#date2").val())+'&category='+region_cat;
         });

  })(jQuery)