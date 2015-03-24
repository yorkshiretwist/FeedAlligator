<?php

/**
 * Provides methods to help manage the Feed_Alligator_Alligator_Feed_CPT Custom Post Type
 * 
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * Provides methods to help manage the Feed_Alligator_Alligator_Feed_CPT Custom Post Type
 *
 * @since      1.0.0
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 * @author:       admin <mrwiblog@gmail.com>
 */
class Feed_Alligator_Alligator_Feed_CPT_Manager {

	/**
	 * Gets all the plugins stored as a Feed_Alligator_Alligator_Feed_CPT Custom Post Type.
	 *
	 * @since    1.0.0
	 */
	public function get_all() {

		$args = array (
			'post_type'              => 'alligator-feed',
			'post_status'            => 'publish',
			'pagination'             => false,
			'order'                  => 'DESC',
			'orderby'                => 'title',
			'cache_results'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
			'posts_per_page'         => -1
		);
		
		$query = new WP_Query( $args );
		
		if ( false == $query->have_posts() ) {
			return array();
		}
		
		return $query->posts;
	
	}

}
