<?php
/*
Plugin Name: Redirect Main Site To User 1 Site
Description: Redirect 'main-site' to 'main-site/sub-site/' for user 1, based on original work of WPSE
Version: 0.1
Author: RCAAP
Author URI: http://www.rcaap.pt
License: GPL2
*/
add_action('parse_request', 'redirect_to_user1_blog');
function redirect_to_user1_blog(){
    if ( ! is_multisite() ) {
		exit;
	}
	
    #Sniff requests for a specific slug
    if(is_main_site()){
		# the default website by the user Webmaster
		$user_info = get_userdata(1);
        if ($user_info->primary_blog) {
			$url = get_blogaddress_by_id($user_info->primary_blog);	
        } else {
			#The URL to redirect TO
			$url = network_site_url();			
		}

        #Let WordPress handle the redirect - the second parameter is obviously the status
		if (get_site_url() != network_site_url()) {
            wp_redirect($url, 301);
	    }
        #It's important to exit, otherwise wp_redirect won't work properly
        exit;
    }
}
