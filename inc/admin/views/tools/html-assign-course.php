<?php
/**
 * @author  ThimPress
 * @package LearnPress/Admin/Views
 * @version 4.0.0
 */

defined( 'ABSPATH' ) or die();

?>
<div class="lp-assign-courses">
	<h2><?php esc_html_e( 'Assign Courses', 'learnpress' ); ?></h2>
	<p><?php _e( 'Manually assign course to users that they can enroll in a specified courses.', 'learnpress' ); ?></p>
	<fieldset class="lp-assign-courses__options">
		<legend><?php esc_html_e( 'Options', 'learnpress' ); ?></legend>
		<ul class="lp-assign-courses__list-type">
			<li>
				<p><?php esc_html_e( 'Courses:', 'learnpress' ); ?></p>
				<select id ="course-assign" name="course-assign" value="">
					<option value=""><?php echo __('Select only a courseID', 'learnpress') ?></option>
					<?php
						$args = array(
							'post_type'      => LP_COURSE_CPT,
							'posts_per_page' => -1,
							'post_status'    => 'publish',
						);
						$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) :
								while ( $the_query->have_posts() ) : $the_query->the_post();
									echo '<option value=" ' . get_the_ID() . ' ">' . get_the_title() . '</option>';
								endwhile;
							endif;
						wp_reset_postdata();
					?>
				</select>
			</li>
			<li>
				<p><?php esc_html_e( 'Assign To:', 'learnpress' ); ?></p>
				<div class="lp-assign-courses__wrap-item">
					<span class="label">
						<input type="radio" value="type-users" name="type-assign">
						<strong><?php esc_html_e( 'Users', 'learnpress' ); ?></strong>
					</span>
					<select id="type-users" class="hide" value="" name="list-users[]">
						<?php
						$users = get_users(
							array(
								'count_total' => false,
							)
						);
						if ( ! empty ( $users ) ) {
							foreach( $users as $user ) {
								echo '<option value="'.$user->ID. '">'.$user->display_name.'</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="lp-assign-courses__wrap-item">
					<span class="label">
						<input type="radio" value="type-roles" name="type-assign">
						<strong><?php esc_html_e( 'Roles', 'learnpress' ); ?></strong>
					</span>
					<select id="type-roles" class="hide" value="" name="list-roles[]">
						<?php
							$roles = wp_roles();
							if ( ! empty( $roles->roles ) ){
								foreach( $roles->roles as $slug => $role ) {
									echo '<option value="'.$slug.'">'.$role['name'].'</option>';
								}
							}
						?>
					</select>
				</div>
			</li>
		</ul>
	</fieldset>
	<div class="lp-assign-courses__result"></div>
	<button type="submit" class=" button button-primary lp-assign-courses__button-assign"><?php echo __('Assign Now', 'learnpress'); ?></button>
</div>
