<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 * @author:       admin <mrwiblog@gmail.com>
 */
class Feed_Alligator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Feed_Alligator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Feed_Alligator    The string used to uniquely identify this plugin.
	 */
	protected $Feed_Alligator;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'feed-alligator';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Feed_Alligator_Loader. Orchestrates the hooks of the plugin.
	 * - Feed_Alligator_i18n. Defines internationalization functionality.
	 * - Feed_Alligator_Admin. Defines all hooks for the dashboard.
	 * - Feed_Alligator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * utils.php
		 *
		 * util.php is a collection of useful functions and snippets that you need or could use every day, designed to avoid conflicts with existing projects.
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/util.php';
		


		/**
		 * WordPress Settings Framework
		 *
		 * The WordPress Settings Framework aims to take the pain out of creating settings pages for your WordPress plugins by effectively creating a wrapper around the WordPress settings API and making it super simple to create and maintain settings pages.
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-settings-framework.php';
		
				
		/**
		 * Custom Post Type: Feed_Alligator_Alligator_Feed_CPT
		 *
		 * Represents a single feed
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-alligator-feed-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-alligator-feed-cpt-manager.php';
			

				
		/**
		 * Custom Post Type: Feed_Alligator_Alligator_Feed_Item_CPT
		 *
		 * Represents a single feed item
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-alligator-feed-item-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-alligator-feed-item-cpt-manager.php';
			

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-feed-alligator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-feed-alligator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-feed-alligator-public.php';

		$this->loader = new Feed_Alligator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Feed_Alligator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Feed_Alligator_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Feed_Alligator_Admin( $this->get_plugin_name(), $this->get_version() );

		// add pages to the admin menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Feed_Alligator_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Feed_Alligator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	/**
	 * Retrieve the current feed.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_current_feed() {
		
		global $post;
		$feed = new Feed_Alligator_Feed();
		$feed->convert_from_post( $post );
		return $feed;
		
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given post as an 
	 * int, or the given default if the meta data does not exist or cannot be parsed as an int.
	 *
	 * @since    1.0.0
	 */
	public static function get_meta_int( $post, $meta_key, $default ) {
		
		$meta_value = get_post_meta( $post->ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) && is_numeric( $meta_value ) ) {
			return ( int ) trim( $meta_value );
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given post as a 
	 * bool, or the given default if the meta data does not exist or cannot be parsed as an bool.
	 *
	 * @since    1.0.0
	 */
	public static function get_meta_bool( $post, $meta_key, $default ) {
		
		$meta_value = get_post_meta( $post->ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) && is_numeric( $meta_value ) ) {
			$val = ( int ) trim( $meta_value );
			return $val == 1;
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given post as a 
	 * string, or the given default if the meta data does not exist.
	 *
	 * @since    1.0.0
	 */
	public static function get_meta_string( $post, $meta_key, $default, $options = null ) {
		
		$meta_value = get_post_meta( $post->ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) ) {
			
			$value = trim( $meta_value );
			
			// if a set of acceptable options has been given, check if this value is one of the options
			if ( null != $options && is_array( $options ) && 0 < count( $options ) && false === in_array ( $value, $options ) ) {
				return $default;
			}
			
			return $value;
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given post as a 
	 * date, or the given default if the meta data does not exist.
	 *
	 * @since    1.0.0
	 */
	public static function get_meta_date( $post, $meta_key, $default ) {
		
		$meta_value = get_post_meta( $post->ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) ) {
			return strtotime( trim( $meta_value ) );
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given comment as an 
	 * int, or the given default if the meta data does not exist or cannot be parsed as an int.
	 *
	 * @since    1.0.0
	 */
	public static function get_comment_meta_int( $comment, $meta_key, $default ) {
		
		$meta_value = get_comment_meta( $comment->comment_ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) && is_numeric( $meta_value ) ) {
			return ( int ) trim( $meta_value );
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given comment as a 
	 * bool, or the given default if the meta data does not exist or cannot be parsed as an bool.
	 *
	 * @since    1.0.0
	 */
	public static function get_comment_meta_bool( $comment, $meta_key, $default ) {
		
		$meta_value = get_comment_meta( $comment->comment_ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) && is_numeric( $meta_value ) ) {
			$val = ( int ) trim( $meta_value );
			return $val == 1;
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given comment as a 
	 * string, or the given default if the meta data does not exist.
	 *
	 * @since    1.0.0
	 */
	public static function get_comment_meta_string( $comment, $meta_key, $default, $options = null ) {
		
		$meta_value = get_comment_meta( $comment->comment_ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) ) {
			
			$value = trim( $meta_value );
			
			// if a set of acceptable options has been given, check if this value is one of the options
			if ( null != $options && is_array( $options ) && 0 < count( $options ) && false === in_array ( $value, $options ) ) {
				return $default;
			}
			
			return $value;
		}
		return $default;	
	}
	
	/**
	 * Returns the value of the meta data with the given key for the given comment as a 
	 * date, or the given default if the meta data does not exist.
	 *
	 * @since    1.0.0
	 */
	public static function get_comment_meta_date( $comment, $meta_key, $default ) {
		
		$meta_value = get_comment_meta( $comment->comment_ID, $meta_key, true );
		if ( isset( $meta_value ) && '' != trim( $meta_value ) ) {
			return strtotime( trim( $meta_value ) );
		}
		return $default;	
	}
	
	/**
	 * Check if the site is using pretty URLs.
	 *
	 * @since  1.0.0
	 */
	public static function pretty_urls() {

		$structure = get_option( 'permalink_structure' );

		if ( '' != $structure || false === strpos( $structure, '?' ) ) {
			return true;
		}

		return false;
	}
	
	/**
	 * Get the users IP address
	 *
	 * From http://roshanbh.com.np/2007/12/getting-real-ip-address-in-php.html
	 *
	 * @since  1.0.0
	 * @access public
	 * @return The current users IP address
	 */
	public static function ip() {

		// check ip from share internet
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];

			// to check ip is pass from proxy
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	/**
	 * Get the URL of the current page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string The current page URL
	 */
	public static function page_url() {
		$pageURL = 'http';

		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
			$pageURL .= 's';
		}

		$pageURL .= '://';

		if ( '80' != $_SERVER['SERVER_PORT'] ) {
			$pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		return $pageURL;
	}

	/**
	 * Get the current blog ID (for WP Multisite) or '1' for standard WP
	 *
	 * @since  1.0.0
	 * @access public
	 * @return int The blog ID, or '1' if not WP MultiSite
	 */
	public static function blog_id() {
		global $current_blog;

		if ( is_object( $current_blog ) && '' != $current_blog->blog_id ) {
			return $current_blog->blog_id;
		}

		return 1;
	}

	/**
	 * Get the current user ID
	 *
	 * @since  1.0.0
	 * @access public
	 * @return int The current users ID
	 */
	public static function user_id() {
		global $current_user;

		return $current_user->ID;
	}

	/**
	 * Triggers an error with the given message
	 *
	 * @since  1.0.0
	 * @access public
	 * @var string $message The message to display
	 * @var int    $errno   The error number; one of the error constants from http://php.net/manual/en/errorfunc.constants.php
	 * @return void
	 */
	public static function trigger_error( $message, $errno ) {

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'error_scrape' ) {

			echo '<strong>' . $message . '</strong>';
			exit;

		}

		trigger_error( $message, $errno );
	}
	
	/**
	 * Verifies the POSTed nonce with the given key
	 *
	 * @since  1.0.0
	 */
	public static function verify_nonce( $key ) {
	    
	    if ( isset( $_POST[$key . '_nonce'] ) && wp_verify_nonce( $_POST[$key . '_nonce'], $key ) ) {
		return true;
	    }
	    
	    return false;
	    
	}
	
	/**
	 * Saves the settings object.
	 *
	 * @since    1.0.0
	 */
	public static function save_settings( $settings ) {
	    
		return update_option ( 'feed_alligator_settings', $settings );
	    
	}
	
	/**
	 * Gets the settings object.
	 *
	 * @since    1.0.0
	 */
	public static function get_settings() {
	    
		$settings = get_option( 'feed_alligator_settings' );
		
		// if the settings haven't been saved then save the defaults
		if ( '' == $settings ) {
			global $current_user;
			$settings = new stdClass();
			$settings->email_address = $current_user->user_email;
			$settings->email_name = $current_user->display_name;
			Feed_Alligator::save_settings( $settings );
		}
		
		return $settings;
	}
	
	/**
	 * Return a value indicating if VoucherPress is in debug mode
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    bool                  Whether the plugin is in debug mode
	 */
	public static function is_debugging() {
		if ( defined( "WP_DEBUG" ) && WP_DEBUG ) {
			return true;
		}

		return false;
	}

	/**
	 * Prints  the given debug message
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       $message          The debug message to print
	 */
	public static function debug( $message ) {

		if ( Feed_Alligator::is_debugging() ) {
			print "<div class='updated'><p>$message</p></div>";
		}
	}

}
