<?php
/**
 * The voucher registration settings tab
 *
 * @package     VoucherPress
 * @subpackage VoucherPress/admin/partials
 * @link       http://voucherpress.com
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// get the current voucher
$voucher = $helper->get_voucher();
?>

<h3 class="hide"><?php _e( "Registration", "voucherpress" ) ?></h3>

<?php do_action( "voucherpress_admin_before_registration_fields" ) ?>



<?php do_action( "voucherpress_admin_after_registration_fields" ) ?>

<div id="registrationfields">

<p><?php _e( "If you want to collect other information from people who download this voucher, enter the fields below. Deleting or changing the name of a field that has already collected information will lose all information for that field.", "voucherpress" ) ?></p>

<table class="widefat">
<thead>
    <tr>
	<th><?php _e( "Field name", "voucherpress" ) ?></th>
	<th><?php _e( "Help text", "voucherpress" ) ?></th>
	<th></th>
    </tr>
</thead>
<tbody>

    <?php
if ( $voucher->settings && count( $voucher->settings ) > 0 ) {
    $fields = $voucher->settings["registration_fields"];
    if ( is_array( $fields ) ) {
	foreach($fields as $field) {
	    echo '
	    <tr>
		<td><input type="text" name="fieldname[]" value="' . $field["name"] . '" /></td>
		<td><input type="text" name="fieldhelptext[]" value="' . $field["helptext"] . '" /></td>
		<td><button type="button" class="button delete deleteregistrationfield"><?php _e( "Delete" ) ?></td>
	    </tr>
	    ';
	}
    }
}
?>

    <tr>
	<td><input type="text" name="fieldname[]" /></td>
	<td><input type="text" name="fieldhelptext[]" /></td>
	<td><button type="button" class="button add addregistrationfield"><?php _e( "Add" ) ?></td>
    </tr>
</tbody>
</table>

</div>