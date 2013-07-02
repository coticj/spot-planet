<?php

	//menus
    function register_theme_menus() {
      register_nav_menus(
          array( 'main-menu' => __( 'Main Menu' ) )
      );
    }
    add_action( 'init', 'register_theme_menus' );
	
	//scripts
	
function wpbootstrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	wp_register_script( 'gmapsjs-script', get_template_directory_uri() . '/js/gmaps.js', array( 'jquery' ) );
	wp_register_script( 'gmaps-script', 'http://maps.google.com/maps/api/js?sensor=true', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'bootstrap-script' );
	wp_enqueue_script( 'gmaps-script' );
	wp_enqueue_script( 'gmapsjs-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );


	//sidebar
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

/* Disable WordPress Admin Bar for all users but admins. */
  show_admin_bar(false);	
  //CUSTOM BOXES
  /* Define the custom box */

add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'myplugin_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function myplugin_add_custom_box() {
    $screens = array( 'post' );
    foreach ($screens as $screen) {
        add_meta_box(
            'coordinates',
            __( 'Coordinates', 'myplugin_textdomain' ),
            'myplugin_inner_custom_box',
            $screen
        );
    }
}

/* Prints the box content */
function myplugin_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $lat = get_post_meta( $post->ID, 'lat', true );
  echo '<label for="lat">';
       _e("Lat", 'myplugin_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="lat" name="lat" value="'.esc_attr($lat).'" size="25" />';
  
  $lng = get_post_meta( $post->ID, 'lng', true );
  echo '<label for="lng">';
       _e("Lng", 'myplugin_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="lng" name="lng" value="'.esc_attr($lng).'" size="25" />';
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['myplugin_noncename'] ) || ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $datalat = sanitize_text_field( $_POST['lat'] );
  $datalng = sanitize_text_field( $_POST['lng'] );

  // Do something with $mydata 
  // either using 
  add_post_meta($post_ID, 'lat', $datalat, true) or
    update_post_meta($post_ID, 'lat', $datalat);
 add_post_meta($post_ID, 'lng', $datalng, true) or
    update_post_meta($post_ID, 'lng', $datalng);
  
}

require_once('updater.php');