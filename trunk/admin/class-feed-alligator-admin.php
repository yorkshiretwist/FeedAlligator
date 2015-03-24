<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/admin
 * @author:       admin <mrwiblog@gmail.com>
 */
class Feed_Alligator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}
	
	/**
	 * Register pages in the Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
	    
		// remove meta boxes not needed
		$feed_cpt = new Feed_Alligator_Alligator_Feed_CPT();
		$feed_cpt->remove_author_meta_box();
		$feed_cpt->remove_excerpt_meta_box();
		
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feed_Alligator_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feed_Alligator_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/feed-alligator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feed_Alligator_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feed_Alligator_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/feed-alligator-admin.js', array( 'jquery' ), $this->version, FALSE );

	}

}
