<?php
/**
* This file is an independent controller, used to query the WordPress database
* and provide search results for Ajax requests.
*
* @return string Either return nothing (i.e. no results) or return some formatted results.
*/
if (!defined('WP_PLUGIN_URL')) {
require_once( realpath('../../../../').'/wp-config.php' );
}

/* EOF *///get your custom posts ids as an array
$posts = get_posts(array(
    'post_type'   => 'spots',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids'
    )
);
$spots=array();
//loop over each post
foreach($posts as $p){
    //get the meta you need form each post
    $lng = get_post_meta($p,"lng",true);
    $lat = get_post_meta($p,"lat",true);
    $other= get_post($p);
	

	$spots[] = array(
         'id' => $p,
         'lng' => $lng,
         'lat' => $lat,
		 'title' => $other->post_title,
		 'category' => $other->post_category[0]
		 
		 );
	
    
}

echo json_encode($spots);