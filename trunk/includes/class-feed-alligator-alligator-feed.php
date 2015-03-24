<?php
/**
 * Class providing properties for an individual feed
 *
 * @link:       http://www.stillbreathing.co.uk/wordpress/feed-alligator
 * @since      1.0.0
 *
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 */

/**
 * Class providing properties for an individual feed
 * 
 * @since      1.0.0
 * @package    Feed_Alligator
 * @subpackage Feed_Alligator/includes
 * @author:       admin <mrwiblog@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
class Feed_Alligator_Feed {

	// properties
	var $post;
	var $url;
	var $name;
	var 
	
	/**
	 * Gets the properties of the given WordPress post an applies them to this feed instance.
	 * 
	 * @since 2.0
	 */
	public function convert_from_post( $post ) {
		
		do_action( 'feed_alligator_before_feed_convert_from_post', $this, $post );
		
		// get the settings object
		$settings = VoucherPress::get_settings();
		
		// the WordPress post object which stores the details for this voucher
		$this->post = $post;
		
		// the database ID of this voucher
		$this->id = $post->ID;
		
		// the GUID of this voucher is just an MD5 hash of the ID
		$this->guid = VoucherPress::get_meta_string( $post, 'voucher_guid', VoucherPress::guid( 8 ) );
		
		// the name of this voucher
		$this->name = $post->post_title;

		// the HTML to go on this voucher
		$this->html = $post->post_content;
		
		// the description of this voucher
		$this->description = $post->post_excerpt;
		
		// the database ID of the template for this voucher
		$this->template_id = VoucherPress::get_meta_int( $post, 'template_id', 0 );
		
		// the date format to use
		$this->date_format = VoucherPress::get_meta_string( $post, 'date_format', 'Y/m/d' );
	    
		// whether this voucher can only be downloaded after registration
		$this->require_registration = VoucherPress::get_meta_bool( $post, 'require_registration', false );
		
		// the email address emails about this voucher will be sent from
		$this->email_address = VoucherPress::get_meta_string( $post, 'email_address', $settings->email_address );
		
		// the `from` name for emails about this voucher
		$this->email_name = VoucherPress::get_meta_string( $post, 'email_name', $settings->email_name );
		
		// the number of times this voucher can be downloaded with a single registration code (0 for unlimited)
		$this->download_limit = VoucherPress::get_meta_int( $post, 'download_limit', 0 );
		
		// the number of 'copies' of this voucher - how many times it can be downloaded in total (0 for unlimited)
		$this->voucher_limit = VoucherPress::get_meta_int( $post, 'voucher_limit', 0 );

		// the date this voucher will become available
		$this->start_date = VoucherPress::get_meta_date( $post, 'start_date', null );

		// the number of days this voucher will stay live
		$this->expiry_days = VoucherPress::get_meta_int( $post, 'expiry_days', 0 );
		
		// the date on which this voucher will become unavailable
		$this->expiry_date = VoucherPress::get_meta_date( $post, 'expiry_date', null );

		// the type of code generation to use
		$this->code_type = VoucherPress::get_meta_string( $post, 'code_type', 'random', VoucherPress::get_code_types() );

		// the length of the generated code
		$this->code_length = VoucherPress::get_meta_int( $post, 'code_length', 6, VoucherPress::get_code_lengths() );

		// the prefix for an autto-generated code
		$this->code_prefix = VoucherPress::get_meta_string( $post, 'code_prefix', '' );

		// the suffix for an autto-generated code
		$this->code_suffix = VoucherPress::get_meta_string( $post, 'code_suffix', '' );

		// the manually-entered codes
		$this->codes = VoucherPress::get_meta_string( $post, 'codes', '' );
		
		do_action( 'feed_alligator_after_feed_convert_from_post', $this );
		
		return $this;
	}
	
}
