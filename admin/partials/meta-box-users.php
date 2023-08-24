<?php
/**
 * Renders meta box to accociate unique content with users
 *
 * @since      1.0.0
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	global $post;

	$current_ucc_users_meta = get_post_meta( $object->ID, 'learndash-ucc-users-data', true );

if ( ! $current_ucc_users_meta ) {
	$current_ucc_users_meta = array();
}

?>

<div class="ld-ucc-meta-container">

	<!--
	<div class="ld-ucc-meta-overlay"><span></span></div>
	-->
	<div class="ld-ucc-meta-content">

		<select name="ld-ucc-users[]" multiple class="ld-ucc-users">
			<?php
			if ( $users_list ) :
				foreach ( $users_list as $key => $value ) :
					?>
			<option
					<?php
					if ( in_array( $key, $current_ucc_users_meta ) ) {
						echo 'selected'; }
					?>
			value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
							<?php
			endforeach;
endif;
			?>
		</select>

	</div>

</div>
