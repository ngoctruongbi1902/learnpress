<?php
/**
 * Elementor Controls for widget Course Filter Tag settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_filter_tag',
		esc_html__( 'Filter Tag Content', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'course_filter_tag',
				esc_html__( 'Set Infomation Filter', 'learnpress' ),
				'',
				Controls_Manager::TEXT,
				[
					'description' => 'If widget include on page is Single Instructor, will be get instructor id automatic, from query var.',
                ],
                Controls_Manager::REPEATER,
                [
                    'fields'        => [
                        [
                            'name'        => 'label_filter',
                            'label'       => esc_html__( 'Label filter', 'learnpress' ),
                            'type'        => Controls_Manager::TEXT,
                            'label_block' => true,
                        ],
                        [
                            'name'         => 'show_column',
                            'label'        => esc_html__( 'Show Column', 'learnpress' ),
                            'type'         => Controls_Manager::SWITCHER,
                            'label_on'     => esc_html__( 'Show', 'learnpress' ),
                            'label_off'    => esc_html__( 'Hide', 'learnpress' ),
                            'return_value' => 'yes',
                            'default'      => 'yes',
                        ],
                    ],
                ]
			),
		]
	),
	[]
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'filter_tag_style',
		esc_html__( 'Filter Tag Style', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'title',
			'.lp-form-course-filter__title'
        ),
    ),
    LPElementorControls::add_fields_in_section(
		'filter-item',
		esc_html__( 'Filter Item Style', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'filter-item',
			'.lp-form-course-filter__content .lp-course-filter__field'
		)
	),
);

return apply_filters(
	'learn-press/elementor/courseFilter/courser-filter-tag',
	array_merge(
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-tag/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-tag/tab-styles',
			$style_fields
		)
	)
);