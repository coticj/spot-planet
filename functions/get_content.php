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
require_once("../Tax-meta-class/Tax-meta-class.php");


    $spot= get_post(intval($_GET["sid"]));
	
	 
  ?>
  <div class="modal-header">
            <button class="close" data-dismiss="modal" type="button">×</button>

            <h3 id="infoModalLabel"><a href="<?php echo get_post_permalink($spot->ID); ?>"><?php echo ($spot->post_title); ?></a></h3>
        </div>

        <div class="modal-body">
			<?php echo get_the_post_thumbnail($spot->ID, 'thumbnail'); ?>
            <p id="pLabel"><?php echo ($spot->post_content); ?></p>
        </div>

        <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Close</button>
        </div>
		