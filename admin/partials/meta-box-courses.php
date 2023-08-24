<?php
/**
 * Renders meta box to accociate unique content with courses
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

$current_ucc_courses_meta = get_post_meta( $object->ID, 'learndash-ucc-courses-data', true );

if ( ! $current_ucc_courses_meta ) {
	$current_ucc_courses_meta = array();
}

?>

<div class="ld-ucc-meta-container">

	<!--
	<div class="ld-ucc-meta-overlay"><span></span></div>
	-->

	<div class="ld-ucc-meta-content">

		<select name="ld-ucc-courses[]" multiple class="ld-ucc-courses">
			<?php
			if ( $course_list ) :
				foreach ( $course_list as $key => $value ) :
					?>
			<option
					<?php
					if ( in_array( $key, $current_ucc_courses_meta ) ) {
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
