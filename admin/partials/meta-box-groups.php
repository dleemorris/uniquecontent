<?php
/**
 * Renders meta box to accociate unique content with groups
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

$current_ucc_groups_meta = get_post_meta( $object->ID, 'learndash-ucc-groups-data', true );

if ( ! $current_ucc_groups_meta ) {
	$current_ucc_groups_meta = array();
}

?>

<div class="ld-ucc-meta-container">

	<!--
	<div class="ld-ucc-meta-overlay"><span></span></div>
	-->
	<div class="ld-ucc-meta-content">

		<select name="ld-ucc-groups[]" multiple class="ld-ucc-groups">
			<?php
			if ( $groups_list ) :
				foreach ( $groups_list as $key => $value ) :
					?>
			<option
					<?php
					if ( in_array( $key, $current_ucc_groups_meta ) ) {
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
