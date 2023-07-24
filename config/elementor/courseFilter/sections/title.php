<?php
/**
 * Elementor Controls for widget Instructor Display Name settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'CourseFilterTtile',
		esc_html__( 'Course Filter Title', 'learnpress' ),

	),
	[]
);
// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'title',
		esc_html__( 'Course Filter Title', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'title',
			'.course-filter-title'
		)
	),
	[]
);

return apply_filters(
	'learn-press/elementor/courseFilter/title',
	array_merge(
		apply_filters(
			'learn-press/elementor/courseFilter/title/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/courseFilter/title/tab-styles',
			$style_fields
		)
	)
);