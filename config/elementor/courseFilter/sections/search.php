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
		'course_filter_search',
		esc_html__( 'Course Filter Search', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'course_filter_search',
				esc_html__( 'Set Instructor ID', 'learnpress' ),
				'',
				Controls_Manager::TEXT,
				[
					'description' => 'If widget include on page is Single Instructor, will be get instructor id automatic, from query var.',
				]
			),
		]
	),
	[]
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_filter_search_style',
		esc_html__( 'Course Filter Search', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		[
            LPElementorControls::add_controls_style_text(
				'title',
				'.lp-form-course-filter__title'
			)
		],
		Controls_Manager::TAB_STYLE,
		[
            LPElementorControls::add_responsive_control_type(
				'title',
				'.lp-form-course-filter__title'
			)
        ]
	),
	[]
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