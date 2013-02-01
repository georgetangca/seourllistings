   var seo_url_str = '';   
   $(document).ready(function($){
    
      var sf=($('#sbc_forward').val()=='1')?true:false;
      $("div.moreitems").draggable();
      
   
      
   function switch_item_chk(mdiv,gname) {
       var mn_arr=mdiv.attr('id').split('_');
       var mname=mn_arr[0]+'_'+mn_arr[1];
       $('.items[id^='+gname+']').not('.items[id^='+mname+']').find('.sitemchk').attr('checked',false);
       $('.items[id^='+gname+']').not('.items[id^='+mname+']').find('.sitemchk[name*=_more]').parent().remove();
       $('.items[id^='+gname+']').not('.items[id^='+mname+']').next('.moreshow').find('.sitemchk').attr('checked',false);
       $('.items[id^='+gname+']').not('.items[id^='+mname+']').prev(".stitle").not(".amen_filter").not(":contains('[+]')").click();
   }

   function item_chkall(mdiv) {
     if (mdiv.find('input.sitemchk:checked').length==0) {
         mdiv.find('.allitemchk').attr('checked',true);
     }
   }
   
   window.get_sidebar_filter = function get_sidebar_filter() { //get filter list from form
        var preference_list = new Array();
        var preference_string = "";
        var title_list = new Array();
        var ptitle_list = new Array();
        var city_list = new Array();
        var title_string = "";
        var arr_count = 0;
        var param_val="";
        var find_one
        $('.items .sitemchk').each(function (i) { //put any checked preferences into the
            var p = $(this); //preference_list array
            if (p.attr('checked')) {
                title_list[arr_count] = p.next('label').find('span').text();
                ptitle_list[arr_count] = p.attr('name').split('||');
                if (p.parent().parent().parent('div.items').length>0) {
                    find_one = p.parent().parent().parent('div.items').find('.allitemchk:eq(0)').attr('name');
                    city_list[arr_count] = p.parent().parent().parent('div.items').find('.allitemchk:eq(0)').attr('name').split('||');
                }
                preference_list[arr_count++] = p.val().split("||");
            }
        });

        var f_cnt=0;
        var fv_cnt=0;
        if (preference_list.length > 0) { //build preference list
           for (var k=0; k<preference_list.length;k++) {
             if (param_val!=preference_list[k][0]) {
              if (f_cnt>0) {
                  preference_string+=']},';
                  title_string+='; ';
              }
              if (city_list.length>0) title_string+=city_list[k][0]+' > ';
              title_string+=ptitle_list[k][0]+' > ';

              preference_string+='{"param":'+'"'+preference_list[k][0]+'",';
              preference_string+='"field_value":[';
              fv_cnt=0;
              f_cnt++;
              param_val=preference_list[k][0];
             }
              if (fv_cnt>0) {
                  preference_string+=',';
                  title_string+=', ';
              }
              title_string+=title_list[k];
              preference_string+='{"id":'+'"'+preference_list[k][1]+'"';
              if (preference_list[k][2]) preference_string+=',"value":'+'"'+preference_list[k][2]+'"';
              preference_string+='}';
              fv_cnt++;
           }
           preference_string+=']}';
    }

    arr_count = 0;

    var kw_string='';
    if ($('#keyword').val()!='') {
       kw_string=$('#keyword').val() + '<img src="'+searchpage_home_URL+'/images/red_close_button.png" alt="reset" id="reset_btn" /> ';
    }
    sep='';
    if('' != kw_string){    
        sep=' ; ';
    }
    if (title_string != ''){
        title_string= breadcum_prefix+' > '+title_string;
    } else {
        title_string= breadcum_prefix+' > '+'ALL';
    }
    
    seo_url_str = kw_string+sep+title_string;
    
   // $('#listing_stitle').html('Now Showing: '+kw_string+sep+title_string);
   
    $('#listing_stitle').html('Now Showing: '+seo_url_str);
    
    return '['+preference_string+']';
   }
      
     window.set_sidebar_filter_status = function set_sidebar_filter_status(){
      if ($.address.parameter('filter')) {
       var filter_str = decodeURIComponent($.address.parameter('filter'));
       filter_str = filter_str.replace(/[\[]/,'');
       filter_str = filter_str.replace(/[\]]/,'');
       
       var filter_split =   filter_str.split(',');
       $selected_obj = $('tt input:checkbox.sitemchk:checked').first().parent().parent();
       $selected_more_obj = $selected_obj.next('div.moreshow');
       $('tt input:checkbox.sitemchk:checked').attr('checked',false);
       $.each(filter_split, function(index,value){
          $selected_obj.find('input.sitemchk[slug="'+value+'"]').attr('checked',true); 
          if($selected_more_obj){
            p = $selected_more_obj.find('input.sitemchk[slug="'+value+'"]')
            p.attr('checked',true); 
            var content=p.parent().clone();
            $(content).appendTo($selected_obj).find('.sitemchk').attr("checked","checked");
          }
       });
       
    } 
  }
      
      $('#menu_bar .stitle').click(function (){
          $(this).next('.items').toggle("slow");
          //loadListings(sf);
          //ajax_redirect_listing();
          var folder_tag = $(this).find('h1 span').text();
          if(folder_tag.indexOf('+')>0){
             folder_tag = 'need_to_open'; 
          }else {
             folder_tag = 'need_to_close'; 
          }
          
          url_p =  $(this).next('div.items').attr('id').trim().toLowerCase();
          url_p =  url_p.replace(/cateogory/g,'').replace(/cities/g,'').replace(/[0-9]/g,'').replace(/_/g,'');
          url_arr = url_p.split('|');
          
          var region_slug = breadcum_prefix.toLowerCase();
          if (region_slug == 'canadian rockies'){
              seo_url = '/canadianrockies';
          } else {
              seo_url = '/'+ region_slug;
          }
          
          if(region_slug == 'canadian rockies' && url_arr[0] && url_arr[1]=='' ) {
               if(folder_tag == 'need_to_open'){
                  seo_url += '/'+generate_slug(url_arr[0]); 
               }
          } else if(url_arr[0]){
            seo_url += '/'+generate_slug(url_arr[0]);
          }
          
          if(folder_tag == 'need_to_open' && url_arr[1]){
             seo_url += '/'+generate_slug(url_arr[1]);
          }
          seo_url += '/';
          window.location = searchpage_home_URL+seo_url;    
      });

      $('.sitemchk').click(function (){ //Pagination
          var p = $(this); //preference_list array
          var ivalue=p.val();
          var pDiv= p.parent().parent();
          var mitemDiv =pDiv;
          if (p.attr('name').indexOf('more')>0){ //click item belong to show-more
             if (pDiv.hasClass('moreitems')) {
              var itemDiv=p.parent().parent().parent().prev('div.items');    
              if (!p.attr('checked')) {
                itemDiv.find(".sitemchk[value='"+ivalue+"']").parent().remove();
              } else {
                    var content=p.parent().clone();
                    $(content).appendTo(itemDiv).find('.sitemchk').attr("checked","checked").click(function(){
                        p.attr('checked', false);
                        $(this).parent().remove();
                      
                    });
              }
              mitemDiv=itemDiv;
             } else {
                 if (!p.attr('checked')) {
                  var moreDiv=p.parent().parent().next('div.moreshow');
                  moreDiv.find(".sitemchk[value='"+ivalue+"']").attr('checked',false);
                  p.parent().remove();
                 } 
             }
            }

            if (p.attr('checked')) {
                if (p.hasClass('allitemchk')) {
                   mitemDiv.find('.sitemchk').not(p).attr('checked',false);
                   mitemDiv.next('.moreshow').find('.sitemchk').attr('checked',false);
                } else {
                   mitemDiv.find('.allitemchk').attr('checked',false);
                }
                if (p.parent().parent().parent('div.items').length>0) {
                    p.parent().parent().parent('div.items').find(".allitemchk:eq(0)").attr('checked',false);
                }
               /* var gname='';
                if (mitemDiv.attr('id')) {
                    var gn_arr=mitemDiv.attr('id').split('_');
                    gname=gn_arr[0];
                }
                if (gname!='') {
                  switch_item_chk(mitemDiv,gname);
                }*/
            } else {
                if (p.parent().parent('div.items').length>0) {
                    if(p.parent().parent().parent('div.items').find("input.sitemchk:checked").length==0)
                    p.parent().parent().parent('div.items').find(".allitemchk:eq(0)").attr('checked',true);
                }

            }

            $("#page_num").val('1');
            loadListings(sf);
            
     });
     
     $(".morebutton").click(function() {
        var moretext=$(this).text();
        $(".moreitems").css('display','none');
        $(".morebutton").text('+ SHOW MORE');
        if (moretext=='+ SHOW MORE') {
         $(this).next(".moreitems").css('display','block');
         $(this).text("- SHOW LESS");
        }
        
     });

     $(".moreclose").click(function() {
          $(this).parent().css('display','none');
          $(this).parent().prev('a.morebutton').text('+ SHOW MORE');
     });

     $('#menu_bar tt label').live('click', function (e) { //Pagination
            //e.preventDefault();
          if ($(this).prev('.sitemchk').length) {
              if($(this).prev('.sitemchk').is(':checked')) {
                  $(this).prev('.sitemchk').attr('checked',false);
              }else {
                  $(this).prev('.sitemchk').attr('checked',true);
              }

              $(this).prev('.sitemchk').triggerHandler('click');
           }
      });
      
      
  
   })(jQuery);
