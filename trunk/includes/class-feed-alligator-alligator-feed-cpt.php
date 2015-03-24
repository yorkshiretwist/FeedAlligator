<?php

/**
 * Represents a single feed
 * 
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * Represents a single feed
 *
 * @since      1.0.0
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 * @author:       admin <mrwiblog@gmail.com>
 */
class Feed_Alligator_Alligator_Feed_CPT {

	
		/**
		* Register this Custom Post Type.
		*
		* @since    1.0.0
		*/
	   public function register() {
		
		$labels = array(
			'name'                => _x( 'Feed', 'Post Type General Name', 'feed-alligator' ),
			'singular_name'       => _x( 'Feeds', 'Post Type Singular Name', 'feed-alligator' ),
			'menu_name'           => __( 'Feeds', 'feed-alligator' ),
			'parent_item_colon'   => __( 'Parent Item:', 'feed-alligator' ),
			'all_items'           => __( 'Feeds', 'feed-alligator' ),
			'view_item'           => __( 'View Item', 'feed-alligator' ),
			'add_new_item'        => __( 'Create New Feed', 'feed-alligator' ),
			'add_new'             => __( 'Create Feed', 'feed-alligator' ),
			'edit_item'           => __( 'Edit Item', 'feed-alligator' ),
			'update_item'         => __( 'Update Item', 'feed-alligator' ),
			'search_items'        => sprintf( __( 'Search %s', 'feed-alligator' ), 'Feeds' ),
			'not_found'           => __( 'Not found', 'feed-alligator' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'feed-alligator' ),
		);
		$args = array(
			'label'               => __( 'alligator-feed', 'feed-alligator' ),
			'description'         => __( 'Feed_Alligator_Alligator_Feed_CPT', 'feed-alligator' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);
		register_post_type( 'alligator-feed', $args );

	}
	
	/**
	 * Sets up the meta boxes for this custom post type.
	 *
	 * @since    2.0.0
	 */
	public function setup_meta_boxes( $loader ) {
		
		$loader->add_action( 'add_meta_boxes', $this, 'add_meta_boxes' );
		
	}
	
	/**
	 * Removes the author meta box from the main column.
	 *
	 * @since    1.0.0
	 */
	public function remove_author_meta_box() {
	    
		remove_meta_box( 'authordiv', 'alligator-feed', 'normal' );
		
	}
	
	/**
	 * Removes the excerpt meta box.
	 *
	 * @since    2.0.0
	 */
	public function remove_excerpt_meta_box() {
	    
		remove_meta_box( 'postexcerpt', 'alligator-feed', 'side' );
		
	}
	
	/**
	 * Sets up the actions to call when a feed is saved.
	 *
	 * @since    1.0.0
	 */
	public function setup_save( $loader ) {
	    
	    $loader->add_action( 'save_post', $this, 'save_feed' );
	    
	}
	
	/**
	 * Called when a feed is saved.
	 *
	 * @since    1.0.0
	 */
	public function save_feed( $post_id ) {
	    
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		$this->save_meta( $post_id );
	    
	}
	
	/**
	 * Saves the metadata when a feed is saved.
	 *
	 * @since    1.0.0
	 */
	private function save_meta( $post_id ) {
	    
		do_action( 'feed_alligator_before_save_feed_metadata', $post_id );
	    
		$this->metadata = get_post_meta( $post_id, 'alligator_feed_metadata', true );
		
		// what do we need to save here?
		
		do_action( 'feed_alligator_before_save_feed_metadata', $post_id );
	    
	}
	
	/**
	 * Add the meta boxes for the Voucher Custom Post Type.
	 *
	 * @since    2.0.0
	 */
	public function add_meta_boxes() {
	    
		global $post;
		
		add_meta_box(
			'voucherpress_voucher_registration',
			__( 'Registration', 'voucherpress' ),
			array( $this, 'render_registration_meta_box' ),
			'alligator-feed',
			apply_filters( 'voucherpress_voucher_registration_meta_box_context', 'side' ),
			apply_filters( 'voucherpress_voucher_registration_meta_box_priority', 'default' )
		);
		
		add_meta_box(
			'voucherpress_voucher_limits',
			__( 'Limits', 'voucherpress' ),
			array( $this, 'render_limits_meta_box' ),
			'vp-voucher',
			apply_filters( 'voucherpress_voucher_limits_meta_box_context', 'side' ),
			apply_filters( 'voucherpress_voucher_limits_meta_box_priority', 'default' )
		);
		
		add_meta_box(
			'voucherpress_voucher_codes',
			__( 'Voucher codes', 'voucherpress' ),
			array( $this, 'render_codes_meta_box' ),
			'vp-voucher',
			apply_filters( 'voucherpress_voucher_codes_meta_box_context', 'normal' ),
			apply_filters( 'voucherpress_voucher_codes_meta_box_priority', 'default' )
		);
		
		// the code meta box should not be changed, and is only available when creating the voucher
		add_meta_box(
			'voucherpress_voucher_code',
			__( 'Download code', 'voucherpress' ),
			array( $this, 'render_download_code_meta_box' ),
			'vp-voucher',
			'side',
			'default'
		);
		
		// if this post hasn't yet been saved we don't want to show any of the meta boxes below
		if ( 'auto-draft' == $post->post_status ) {
			do_action( 'voucherpress_after_add_voucher_meta_boxes' );
			return;
		}
		
		add_meta_box(
			'voucherpress_voucher_shortcodes',
			__( 'Shortcodes', 'voucherpress' ),
			array( $this, 'render_shortcodes_meta_box' ),
			'vp-voucher',
			apply_filters( 'voucherpress_voucher_shortcodes_meta_box_context', 'normal' ),
			apply_filters( 'voucherpress_voucher_shortcodes_meta_box_priority', 'default' )
		);
		
		add_meta_box(
			'voucherpress_voucher_statistics',
			__( 'Statistics', 'voucherpress' ),
			array( $this, 'render_statistics_meta_box' ),
			'vp-voucher',
			apply_filters( 'voucherpress_voucher_statistics_meta_box_context', 'normal' ),
			apply_filters( 'voucherpress_voucher_statistics_meta_box_priority', 'default' )
		);
		
		do_action( 'voucherpress_after_add_voucher_meta_boxes' );
		
		add_action( 'post_submitbox_misc_actions', array( $this, 'add_preview_link' ) );
	
	}
	
	/**
	 * Renders the cpreview link in the publish box.
	 *
	 * @since    2.0.0
	 */
	public function add_preview_link() {
	    
		global $post;
		$guid = get_post_meta( $post->ID, 'voucher_guid', true );
		echo '
	<div class="misc-pub-section" id="voucherpress_preview"> 
		<a href="edit.php?post_type=vp-voucher&amp;preview=' . $guid . '" class="button voucher-preview">' . __( 'Preview voucher', 'voucherpress' ) . '</a>
	</div>
	    ';
		
	}
	
	/**
	 * Renders the code meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_download_code_meta_box( $post ) {
	    
		$voucher = VoucherPress::get_current_voucher();

		if ( 'auto-draft'  == $post->post_status ) {
		    $meta_box_path = VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-download-code-meta-box.php';
		} else {
		    $meta_box_path = VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-fixed-download-code-meta-box.php';
		}
		
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the codes meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_codes_meta_box( $post ) {
	    
		$voucher = VoucherPress::get_current_voucher();
		$helper = new VoucherPress_Admin_Helper( $this );
		$meta_box_path = VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-codes-meta-box.php';
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the template meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_template_meta_box( $post ) {
	
		$voucher = VoucherPress::get_current_voucher();
		$meta_box_path = apply_filters( 'voucherpress_voucher_template_meta_box_path', VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-template-meta-box.php' );
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the registration meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_registration_meta_box( $post ) {
	
		$feed = Feed_Alligator::get_current_feed();
		$meta_box_path = apply_filters( 'voucherpress_voucher_registration_meta_box_path', VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-registration-meta-box.php' );
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the download limits meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_limits_meta_box( $post ) {
	
		$voucher = VoucherPress::get_current_voucher();
		$meta_box_path = apply_filters( 'voucherpress_voucher_limits_meta_box_path', VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-limits-meta-box.php' );
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the shortcodes meta box.
	 *
	 * @since    2.0.0
	 */
	public function render_shortcodes_meta_box( $post ) {
	
		$voucher = VoucherPress::get_current_voucher();
		$meta_box_path = apply_filters( 'voucherpress_voucher_shortcodes_meta_box_path', VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-shortcodes-meta-box.php' );
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Renders the statistics meta boxes for the Voucher Custom Post Type.
	 *
	 * @since    2.0.0
	 */
	public function render_statistics_meta_box( $post ) {

		$voucher = VoucherPress::get_current_voucher();
		$meta_box_path = apply_filters( 'voucherpress_voucher_statistics_meta_box_path', VOUCHERPRESS_PLUGIN_DIR . 'admin/partials/voucher-statistics-meta-box.php' );
		require_once( $meta_box_path );
		
	}
	
	/**
	 * Sets up the columns for the Voucher Custom Post Type.
	 *
	 * @since    2.0.0
	 */
	public function setup_columns( $loader ) {

		$loader->add_filter( 'manage_edit-vp-voucher_columns', $this, 'get_columns' );
		$loader->add_action( 'manage_vp-voucher_posts_custom_column', $this, 'render_column', 10, 2 );
		$loader->add_filter( 'post_row_actions', $this, 'filter_actions', 10, 2 );
		
	}
	
	/**
	 * Filters the quick actions links for a post.
	 *
	 * @since    2.0.0
	 */
	public function filter_actions( $actions, $post ) {
		
		if ( 'vp-voucher' != $post->post_type ) {
			return $actions;
		}
		
		$metadata = get_post_meta( $post->ID, 'voucher_metadata' );
		
		$guid = VoucherPress::get_meta_string( $metadata, 'voucher_guid', false );
		$actions['preview_voucher'] = $post->ID;
		// if the guid can't be fetched then this isn't a valid voucher
		if ( false === $guid ) {
			return $actions;
		}
		
		$actions['preview_voucher'] = '<a href="edit.php?post_type=vp-voucher&amp;preview=' . $guid . '" class="voucher-preview">Preview</a>';
		
		return $actions;
		
	}
	
	/**
	 * Returns the columns for the Voucher Custom Post Type.
	 *
	 * @since    2.0.0
	 */
	public function get_columns() {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Voucher Name', 'voucherpress' ),
			'voucher_description' => __( 'Description', 'voucherpress' ),
			'voucher_preview' => __( 'Preview', 'voucherpress' ),
			'voucher_registration' => __( 'Registration', 'voucherpress' ),
			'voucher_expiry' => __( 'Expiry', 'voucherpress' )
		);
		
		$columns = apply_filters( 'voucherpress_voucher_cpt_columns', $columns );
		
		return $columns;
		
	}
	
	/**
	 * Renders a column in the Custom Post Type admin table.
	 *
	 * @since    2.0.0
	 */
	public function render_column( $column, $post_id ) {
		
		global $post;
		$voucher = new VoucherPress_Voucher();
		$voucher->convert_from_post( $post );
		
		switch ( $column ) {
			
			case 'voucher_description':
				$this->render_description_column( $voucher );
				break;
			
			case 'voucher_preview':
				$this->render_preview_column( $voucher );
				break;
			
		}
		
	}
	
	/*
	 * Renders the title column.
	 *
	 * @since    2.0.0
	 */
	private function render_description_column( $voucher ) {
		
		echo $voucher->description;
		
	}
	
	/*
	 * Renders the preview column.
	 *
	 * @since    2.0.0
	 */
	private function render_preview_column( $voucher ) {
		
		echo '<img src="';
		echo VOUCHERPRESS_PLUGIN_URL . 'templates/' . $voucher->template_id . '_thumb.jpg';
		echo '" alt="" />';
		
	}
}
