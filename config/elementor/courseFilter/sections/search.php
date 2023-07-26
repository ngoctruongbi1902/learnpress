<?php
/**
 * Elementor Controls for widget Course Filter Search settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_filter_search_label',
		esc_html__( 'Course Filter Search Label', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'course_filter_search',
				esc_html__( 'Set Instructor ID', 'learnpress' ),
				'',
				Controls_Manager::TEXT,
				[
					'label' => 'Label filter',
					'default' => 'Search',
				]
			),
			LPElementorControls::add_control_type(
				'course_filter_search_input',
				esc_html__( 'Placeholder', 'learnpress' ),
				'',
				Controls_Manager::TEXT,
				[
					'placeholder' => 'Search Course',
				]
			),
		]
	),
	[]
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'filter_search_label',
		esc_html__( 'Course Filter Label', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'title',
			'.lp-form-course-filter__title'
		)
	),
	LPElementorControls::add_fields_in_section(
		'filter_search_input',
		esc_html__( 'Filter Search Input', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'form_input_text',
			'.lp-form-course-filter__content input[type=text]'
		)
	),
);

return apply_filters(
	'learn-press/elementor/courseFilter/courser-filter-search',
	array_merge(
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-search/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-search/tab-styles',
			$style_fields
		)
	)
);