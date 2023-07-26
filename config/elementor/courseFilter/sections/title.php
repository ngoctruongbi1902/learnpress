<?php
/**
 * Elementor Controls for widget Course Filter Title settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_title',
		esc_html__( 'Course Filter Title', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'course_filter_title',
				esc_html__( 'Course filter title', 'learnpress' ),
				esc_html__( 'Course Filter', 'learnpress' ),
				Controls_Manager::TEXT,
			),
            LPElementorControls::add_control_type_select(
				'course_filter_html',
				esc_html__( 'Html tag title', 'learnpress' ),
                [
                    'p'         => esc_html__( 'p', 'learnpress' ),
                    'h1'   => esc_html__( 'H1', 'learnpress' ),
                    'h2'  => esc_html__( 'H2', 'learnpress' ),
                    'h3' => esc_html__( 'H3', 'learnpress' ),
                    'h4'  => esc_html__( 'H4', 'learnpress' ),
                    'h5' => esc_html__( 'H5', 'learnpress' ),
                    'h6' => esc_html__( 'H6', 'learnpress' ),
                ],
                'h2'
			),
            LPElementorControls::add_control_type(
				'course_filter_description',
				esc_html__( 'Course filter description', 'learnpress' ),
				esc_html__( 'Fill in your information and send it to us to become a teacher.', 'learnpress' ),
				Controls_Manager::TEXTAREA,
			),
			LPElementorControls::add_control_type_select(
				'course_filter_alignment',
				esc_html__( 'Alignment', 'learnpress' ),
				[
					'left' => [
						'title' => esc_html__( 'Left', 'learnpress' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'learnpress' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'learnpress' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'learnpress' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'left',		
			),
		]
	),
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'filter_title_style',
		esc_html__( 'Filter Title Style', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'filter_title',
			'.course-filter-title'
        ),
    ),
	LPElementorControls::add_fields_in_section(
		'filter_description_style',
		esc_html__( 'Filter Description Style', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'filter_description',
			'.course-filter-description',
        ),
    ),
);

return apply_filters(
	'learn-press/elementor/courseFilter/courser-filter-title',
	array_merge(
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-title/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-title/tab-styles',
			$style_fields
		)
	)
);