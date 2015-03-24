<?php

/**
 * Represents a single feed item
 * 
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * Represents a single feed item
 *
 * @since      1.0.0
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 * @author:       admin <mrwiblog@gmail.com>
 */
class Feed_Alligator_Alligator_Feed_Item_CPT {

	
		/**
		* Register this Custom Post Type.
		*
		* @since    1.0.0
		*/
	   public function register() {
		
			$labels = array(
				'name'                => _x( 'Items', 'Post Type General Name', 'feed-alligator' ),
				'singular_name'       => _x( 'Item', 'Post Type Singular Name', 'feed-alligator' ),
				'menu_name'           => __( 'Items', 'feed-alligator' ),
				'parent_item_colon'   => __( 'Parent Item:', 'feed-alligator' ),
				'all_items'           => __( 'Items', 'feed-alligator' ),
				'view_item'           => __( 'View Item', 'feed-alligator' ),
				'add_new_item'        => __( 'Create New Item', 'feed-alligator' ),
				'add_new'             => __( 'Create Item', 'feed-alligator' ),
				'edit_item'           => __( 'Edit Item', 'feed-alligator' ),
				'update_item'         => __( 'Update Item', 'feed-alligator' ),
				'search_items'        => sprintf( __( 'Search %s', 'feed-alligator' ), 'Items' ),
				'not_found'           => __( 'Not found', 'feed-alligator' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'feed-alligator' ),
			);
			$args = array(
				'label'               => __( 'alligator-feed-item', 'feed-alligator' ),
				'description'         => __( 'Feed_Alligator_Alligator_Feed_Item_CPT', 'feed-alligator' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => false,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 20,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'alligator-feed-item', $args );
		
		}
		

}
