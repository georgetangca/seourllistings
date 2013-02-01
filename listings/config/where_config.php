<?php
global $CONFIG;
$CONFIG = array(
        'cache_enable'    => '1'
        ,'service_url' => 'http://'.$SJM_globalEnvironment.'/'.SJM_SERVICE_FOLDER  
        ,'listing_url' => 'http://'.$SJM_globalEnvironment.'/listing' 
        ,'listing_detail_url' => "/__CAT_SLUG__/__CAT_LEVEL1_SLUG__/__SLUG__/"
        ,'listing_folder' =>SEARCH_LISTING_URL_PATH
        ,'site_slug' => ENABLE_SITE_SLUG
        ,'site_name' => ENABLE_SITE_NAME
       // ,'page_index' => $cur_page_index
        ,'search_per_page' => 15
        ,'map_marker'  => $SJM_globalEnvironment.'/images/markers/where/marker.png'
        ,'map_shadow'  => $SJM_globalEnvironment.'/images/markers/shadow.png'
        ,'template_id' => '10'  //if child have template_id ,use child value
        ,'nearby_listing_limit' =>15
        ,'sidebar_item_default_show'=>'5'
    
       ,'city_id_name_mapping' =>  array(
            '3489'  => 'toronto'
            ,'3486' => 'vancouver'
            ,'3473' => 'calgary'
            ,'3492' => 'edmonton'
            ,'4630' => 'halifax'
            ,'3522' => 'muskoka'
            ,'3479' => 'ottawa'
            ,'4650' => 'victoria'
            ,'3509' => 'whistler'
            ,'3995' => 'winnipeg'
            ,'4063' => 'canadian rockies'
            ,'3634' => 'niagra' 
            ,'3472' => 'alberta'
            ,'3485' => 'british-columbia'
            ,'4497' =>'northwest-territories' 
            ,'4629' =>'nova-ccotia'           
            ,'3994' =>'manitoba'
            ,'3478' =>'ontario'
            ,'3736' =>'quebec'
            ,'3578' =>'yukon-territory'    
     )
     ,'base_region_root' => array(
            '3473'  => 'calgary'
            ,'4063' => 'canadianrockies' //the id is banf actually
            ,'5149' =>'Canadianrockies',
            '5080'  =>'Canadianrockies',
            '5246'  =>'Canadianrockies',
            '5071'  =>'Canadianrockies', 
            '4351'  =>'Canadianrockies',
            '5066'  =>'Canadianrockies',
            '4409'  =>'Canadianrockies',
            '5097'  =>'Canadianrockies'
            ,'3492' => 'edmonton'
            ,'4630' => 'halifax'
            ,'3522' => 'muskoka'
            ,'3479' => 'ottawa' 
            ,'3489'  =>'toronto'
            ,'3486' => 'vancouver'
            ,'4650' => 'victoria'
            ,'3509' => 'whistler'
            ,'3995' => 'winnipeg'
        )
    
       ,'rockies_sub_region_root' => array( //here also indicate the order
          // '4063','4409','4351','5097','5066','5080','5246' ,'5071', '5149'
           '4063' =>'banff'
           ,'4409'=>'jasper'
           ,'4351' => 'canmore-kananaskis'
           ,'5097'=>'lake-louise'
           ,'5066' => 'hinton'
           ,'5080' => 'golden-revelstoke'
           ,'5246' => 'invermere-radium-fairmont-panorama'
           ,'5071' => 'kimberley-cranbrook'
           ,'5149' =>'fernie-sparwood-elkford'  
        )
    
        ,'mapping_tpl' => array(
          TPL_SEARCH_GENERAL => array(
             'sidebar_item_default_show'=>'5' 
             ,'search_result_header' =>array() 
             ,'sort_title'=>array(
                 array(
                          'title'=>'name',
                          'seq'=>'descending'
                          ),
                     
                  array(
                      'title'=>'type',
                      'seq'=>'descending'),
                 
             )
             ,'side_bar' =>array( //city =Toronto, category ID 3489 
                             array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'cateogory'
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )   
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                  )//sidebar
               
          
       )//general
    
       ,TPL_SEARCH_ROCKIES => array( //rockies
             'sidebar_item_default_show'=>'5' 
             ,'search_result_header' =>array()
             ,'sort_title'=>array(
                 array(
                          'title'=>'name',
                          'seq'=>'descending'
                          ),
                     
                  array(
                      'title'=>'type',
                      'seq'=>'descending'),
                 )
             ,'side_bar' =>array( // '5149','5080','5246' ,'5071', '4063','4351','5066' ,'4409','5097'
                             array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Fernie, Sparwood & Elkford' // Fernie, Sparwood & Elkford  5149
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  ) 
                                  ,'base_id' =>'5149'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                 
                             , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Golden & Revelstoke' // Golden & Revelstoke  5080
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'5080'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                               
                              , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Invermere, Radium, Fairmont & Panorama'  // Invermere, Radium, Fairmont & Panorama 5246
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'5246'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                               , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Kimberley & Cranbrook'  // Kimberley & Cranbrook 5071
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'5071'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               ) 
                               , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Banff' //Banff 4063
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                   ,'base_id' =>'4063'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                              , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Canmore & Kananaskis' //Canmore & Kananaskis 4351
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'4351'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               )
                               , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Hinton' // Hinton  5066
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'5066'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               ) 
                               , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Jasper' // Jasper 4409
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'4409'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               ) 
                             , array(
                                  'build_required'=> array(
                                      'search_default' =>'0' 
                                      ,'group_name' =>'Lake Louise' // Lake Louise 5097 
                                      ,'list_type'  => BUILD_CHECK_BOX
                                      ,'default_show_num' => 5 
                                      ,'show_all' =>'1'
                                      ,'param' => 'category' //should be unqiue
                                  )
                                  ,'base_id' =>'5097'
                                  ,'slug' => 'category' //just for internal use 
                                  ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                               ) 
                            
                  )//sidebar
          )//rockies
    
         ,TPL_SEARCH_DEAULT => array(
                 'base_id' =>'3489'   //$cur_page_base_id   
                 ,'sidebar_item_default_show'=>'5'
                 ,'search_result_header' =>array()
                 ,'sort_title'=>array(
                     array(
                              'title'=>'name',
                              'seq'=>'descending'
                              ),

                      array(
                          'title'=>'type',
                          'seq'=>'descending'),

                 )
                 ,'side_bar' =>array( //city =Toronto, category ID 3489 
                                 array(
                                      'build_required'=> array(
                                          'search_default' =>'0' 
                                          ,'group_name' =>'cateogory'
                                          ,'list_type'  => BUILD_CHECK_BOX
                                          ,'default_show_num' => 5 
                                          ,'show_all' =>'1'
                                          ,'param' => 'category' //should be unqiue
                                      )   
                                      ,'slug' => 'category' //just for internal use 
                                      ,'content_type'=> BUILD_CATEGORY_GROUP                                 
                                   )
                      )//sidebar
            )//default
       )//mapping_tpl
       
        ,'category_mapping' => array( //for nearby search function
            '3489'=>array( //toronto
                 '3976' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3490' => array(  //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3516' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'3646' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'3501' => array( //Nightlife
                    'title'     => 'Nightlife'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Nightlife.png'
                 ) 
              ),
            
            '3486'=>array( //vancouver
                 '3567' => array( //Accommodations
                    'title'     => 'Hotels'  
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3512' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3535' => array(  //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'3599' => array( //Galleries & Museums
                    'title'     => 'Art & Museums'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Art-and-Museums.png'
                 )       
                 ,'3487' => array( //Nightlife
                    'title'     => 'Nightlife'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Nightlife.png'
                 ) 
              ),
            
            '3473'=>array( //calgary
                 '3541' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'5473' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3497' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'5867' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'3474' => array(  //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
            '3492'=>array( //edmonton
                 '3687' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'5497' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3533' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'4013' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'4002' => array(  //Nightlife
                    'title'     => 'Nightlife'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Nightlife.png'
                 ) 
              ),
            
            '4630'=>array( //halifax
                 '4761' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'4663' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'4639' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'4677' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'4689' => array( //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
             '3522'=>array( //muskoka
                 '4179' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3529' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3523' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'3707' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'3952' => array( //Recreation
                    'title'     => 'Recreation'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Recreation.png'
                 ) 
              ),
            
            '3479'=>array( //ottawa
                 '3677' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3472' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3482' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'3514' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'3480' => array( //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
            '4650'=>array( //victoria
                 '4655' => array(  //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'4660' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'4651' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'4674' => array( //Art, Galleries & Museums
                    'title'     => 'Art & Museums'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Art-and-Museums.png'
                 )       
                 ,'4745' => array( //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
            '3509'=>array( //whistler
                 '3569' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3624' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'3510' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'3612' => array(  //Art, Galleries & Museums
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'3757' => array( //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
            '3995'=>array( //winnipeg
                 '4306' => array( //Accommodations
                    'title'     => 'Hotels'
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'3996' => array( //Shopping
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'4244' => array( //Restaurants
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'4280' => array( //Attractions
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'4344' => array( //Entertainment
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              ),
            
             '4063'=>array( //rockies
                 /*(1)banf 4063 default, (2)Jasper 4409, (3)Canmore & Kananaskis 4351,(4)Lake Louise 5097,(5)Hinton  5066(need check)
                  *(6)Fernie, Sparwood & Elkford  5149(need check) (7) Golden & Revelstoke  5080(need check) (8)Invermere, Radium, Fairmont & Panorama 5246 (9)Kimberley & Cranbrook 5071
                  
                In British Columbia:
                    Fernie, Sparwood & Elkford  5149 X
                    Golden & Revelstoke  5080 X
                    Invermere, Radium, Fairmont & Panorama 5246 X
                    Kimberley & Cranbrook 5071

                In Alberta:
                    Banff 4063 X
                    Canmore & Kananaskis 4351 X
                    Hinton  5066 X
                    Jasper 4409 X
                    Lake Louise 5097 X
                */
                 
                 
                 '4253,5083,4352,5228,5154,5150,5152,5255,5072' => array(
                    'title'     => 'Hotels' //Accommodations
                    ,'color' => '7ebce6'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Hotels.png'
                 )
                 ,'4734,4964,4707,5098,5485,5202,5478,5880,5200' => array(
                    'title'     => 'Shops'
                    ,'color' => 'b4d14b'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Shops.png'
                 )       
                 ,'5003,5056,4889,5159,5421,5249,5230,5404' => array(
                    'title'     => 'Restaurants'
                    ,'color' => 'f5874f'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Restaurants.png'
                 )       
                 ,'4064,5454,4572,5461,5318,5240,5873,5273,5238' => array(
                    'title'     => 'Attractions'
                    ,'color' => 'f05c95'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Attractions.png'
                 )       
                 ,'4644,5086,5176,5161,5067,5290,5081,5247,5424' => array(
                    'title'     => 'Entertainment'
                    ,'color' => 'f04f50'
                    ,'icon'  => $SJM_globalEnvironment.'/images/markers/where/Entertainment.png'
                 ) 
              )
            
        )
    
        ,'sidebar_mapping'=>array(
            '3489'  => 'Toronto'
            ,'3634' => 'Niagra'
            ,'3486' => 'Vancouver'
            ,'3473' => 'Calgary'
            ,'3492' => 'Edmonton'
            ,'4630' => 'Halifax'
            ,'3522' => 'Muskoka'
            ,'3479' => 'Ottawa'
            ,'4650' => 'Victoria'
            ,'3509' => 'whistler'
            ,'3995' => 'winnipeg'
            ,'4063' => 'Canadian rockies'
            ,'5149' =>'Canadian rockies',
            '5080'=>'Canadian rockies',
            '5246'=>'Canadian rockies',
            '5071'=>'Canadian rockies', 
            '4351'=>'Canadian rockies',
            '5066'=>'Canadian rockies',
            '4409'=>'Canadian rockies',
            '5097'=>'Canadian rockies'
        )
    
       ,'listing_cat_to_event_id_mapping' => array(
        '3489'=>'51' //toronto
        ,'3486'=>'70' //vancouver
        ,'3473'=>'21' //'calgary'
        ,'3522'=>'113' //muskoka
        ,'3479'=>'122' //ottawa
        ,'4650'=>'128' //victoria
        ,'3509'=>'138' //whistler
       // ,'Winnipeg' =>'' //not defined >> need check ?
      )
    
      
     
    )  //where 
  ;  

?>
