<?php
/**
 * Template for remove user enroll form course
 * @author  ThimPress
 * @package LearnPress/Admin/Views
 * @version 4.0.0
 */

defined( 'ABSPATH' ) or die();

?>
<div class="lp-remove-users-courses">
	<h2><?php _e( 'Unassign Course', 'learnpress' ); ?></h2>
	<div class="description">
		<p><?php _e( 'This action will remove user and user\'s order from a course.', 'learnpress' ); ?></p>
	</div>
	<ul class="list-field">
		<li class="lp-select-2">
			<p><?php esc_html_e( 'Courses:', 'learnpress' ); ?></p>
			<select id ="list-courses" class="" name="list-course[]" value="">
				<option value=""></option>
				<?php
					$args = array(
						'post_type'      => LP_COURSE_CPT,
						'posts_per_page' => -1,
						'post_status'    => 'publish',
					);
					$the_query = new WP_Query( $args );
						if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) : $the_query->the_post();
								echo '<option value="' . get_the_ID() . '">' . get_the_title() . ' (#'.get_the_ID().') ' . '</option>';
							endwhile;
						endif;
					wp_reset_postdata();
				?>
			</select>
		</li>
		<li class="lp-select-2">
			<p><?php esc_html_e( 'Users:', 'learnpress' ); ?></p>
			<div class="lp-remove-users-courses__wrap-item">

			</div>
			<select id="list-users" class="" value="" name="list-users[]">
				<option value=""></option>
				<?php
				$users = get_users(
					array(
						'count_total' => false,
					)
				);
				if ( ! empty ( $users ) ) {
					foreach( $users as $user ) {
						echo '<option value="'.$user->ID. '">'.$user->display_name.' '.' (#'.$user->ID.') '.'</option>';
					}
				}
				?>
			</select>
		</li>
	</ul>
	<div class="lp-remove-users-courses__result"></div>
	<button type="submit" class=" button button-primary lp-remove-users-courses__button-remove"><?php echo __('Remove', 'learnpress'); ?></button>
</div>
<style>
	/* .select2-selection__rendered {
		line-height: 30px !important;
	} */
	.select2-container .select2-selection--multiple {
		height: 30px !important;
	}
	.select2-selection__arrow {
		height: 30px !important;
	}
	.select2-container .select2-search--inline .select2-search__field {
		margin-top: -1px !important;
	}
</style>
