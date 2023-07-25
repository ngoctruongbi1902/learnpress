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
				'instructor_id',
				esc_html__( 'Set Instructor ID', 'learnpress' ),
				'',
				Controls_Manager::TEXT,
				[
					'description' => 'If widget include on page is Single Instructor, will be get instructor id automatic, from query var.',
				]
			),
			LPElementorControls::add_control_type(
				'wrapper_tags',
				esc_html__( 'Add html tag wrapper Instructor Name', 'learnpress' ),
				[
					[
						'open_tag'  => '<div class="">',
						'close_tag' => '</div>',
					],
				],
				Controls_Manager::REPEATER,
				[
					'fields'        => [
						[
							'name'        => 'open_tag',
							'label'       => esc_html__( 'Html Open tag', 'learnpress' ),
							'type'        => Controls_Manager::TEXT,
							'label_block' => true,
						],
						[
							'name'        => 'close_tag',
							'label'       => esc_html__( 'Html Close tag', 'learnpress' ),
							'type'        => Controls_Manager::TEXT,
							'label_block' => true,
						],

					],
					'prevent_empty' => false,
				]
			),
		]
	),
	[]
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_filter_title_name',
		esc_html__( 'Course Filter Title name', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		[
            LPElementorControls::add_control_type(
                'item_layouts',
                esc_html__( 'Add layout and drag to top to set Active', 'learnpress' ),
                [
                    [
                        'layout_name' => 'Layout Default',
                        'layout_html' => '',
                    ],
                ],
                Controls_Manager::REPEATER,
                [
                    'fields'        => [
                        [
                            'name'        => 'column_name',
                            'label'       => esc_html__( 'Column Name', 'learnpress' ),
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
                        [
                            'name'         => 'has_icon',
                            'type'         => Controls_Manager::HIDDEN,
                            'default'      => false,
                            'return_value' => true,
                        ],
                        [
                            'name'         => 'download_icon',
                            'label'        => esc_html__( 'Download Icon', 'learnpress' ),
                            'type'         => Controls_Manager::ICONS,
                            'default'      => [
                                    'value' => 'fas fa-file-download',
                                    'library' => 'fa-solid',
                                ],
                            'condition'    => [
                                'has_icon'    => 'yes',
                            ]
                        ],
                    ],
                    'default'       =>[
                        'file-name' => [
                            'column_name' => esc_html__( 'Name', 'learnpress' ),
                            'show_column' => esc_html__( 'yes', 'learnpress' ),
                            'has_icon'    => false,
                        ],
                        'file-type' =>[
                            'column_name' => esc_html__( 'Type', 'learnpress' ),
                            'show_column' => esc_html__( 'yes', 'learnpress' ),
                            'has_icon'    => false,
                        ],
                        'file-size' => [
                            'column_name' => esc_html__( 'Size', 'learnpress' ),
                            'show_column' => esc_html__( 'yes', 'learnpress' ),
                            'has_icon'    => false,
                        ],
                        'file-link' => [
                            'column_name' => esc_html__( 'Download', 'learnpress' ),
                            'show_column' => esc_html__( 'yes', 'learnpress' ),
                            'has_icon'    => 'yes',
                            'download_icon' => [
                                'value' => 'fas fa-file-download',
                            ],
                        ],
                    ],
                    'prevent_empty' => false,
                    'title_field'   => '{{{ column_name }}}',
                    'item_actions' => [
                        'add' => false,
                        'duplicate' => false,
                        'remove' => false,
                        'sort' => true,
                    ],
                ]
            ),
        ]
	),
	[]
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