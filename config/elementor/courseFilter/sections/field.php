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
		esc_html__( 'Filter Field Content', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'field_item',
				esc_html__( 'Add item filter', 'learnpress' ),
				[
					[
						'info_name' => 'Price',
						'info_html' => '',
					],
				],
				Controls_Manager::REPEATER,
				[
					'fields'        => [
						[
							'name'        => 'info_name',
							'label'       => esc_html__( 'Field Title', 'learnpress' ),
							'type'        => Controls_Manager::TEXT,
							'label_block' => true,
						],
						[
							'name'        => 'field_name',
							'label'       => esc_html__( 'Field Name', 'learnpress' ),
							'type'        => Controls_Manager::SELECT2,
							'multiple' => false,
							'options' => [
								'tag'       => esc_html__( 'Tag', 'learnpress' ),
								'author'    => esc_html__( 'Author', 'learnpress' ),	
								'category'  => esc_html__( 'Category', 'learnpress' ),
								'level'     => esc_html__( 'Level', 'learnpress' ),	
								'price'     => esc_html__( 'Price', 'learnpress' ),							
							],
						],
						[
							'label' => esc_html__( 'Type Show Filter', 'learnpress' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'list'  => esc_html__( 'List', 'learnpress' ),
								'dropdown' => esc_html__( 'Dropdown', 'learnpress' ),								
							],
							'default' => 'list',
						],
						[
							'name'        => 'filter_icon',
							'label'       => esc_html__( 'Filter Icon', 'learnpress' ),
							'label_block' => true,
							'type'        => Controls_Manager::ICONS,
							'skin'        => 'inline',
							'label_block' => false,
							'default'     => array(
								'value'   => 'far fa-address-book',
								'library' => 'Font Awesome 5 Free',
							),
						],
						[
							'name' => 'icon_position',
							'label' => esc_html__( 'Icon Position', 'learnpress' ),
							'type' => Controls_Manager::CHOOSE,
							'mobile_default' => 'right',
							'options' => [
								'left' => [
									'title' => esc_html__( 'Left', 'learnpress' ),
									'icon' => 'eicon-h-align-left',
								],
								'right' => [
									'title' => esc_html__( 'Right', 'learnpress' ),
									'icon' => 'eicon-h-align-right',
								],
							],
							'devices' => [ 'desktop', 'tablet' ],
							'prefix_class' => 'content-align-%s',
						],
						[
                            'name'         => 'show_field',
                            'label'        => esc_html__( 'Show Field', 'learnpress' ),
                            'type'         => Controls_Manager::SWITCHER,
                            'label_on'     => esc_html__( 'Show', 'learnpress' ),
                            'label_off'    => esc_html__( 'Hide', 'learnpress' ),
                            'return_value' => 'yes',
                            'default'      => 'yes',
                        ],
						
						// Toggle Custom Css
						[
							'name'  => 'toggle-custom-css',
							'label' => esc_html__( 'Advanced Css', 'learnpress' ),
							'type'  => Controls_Manager::POPOVER_TOGGLE,
						],
						[
							'method' => 'start_popover',
						],
						[
							'name'        => 'info_custom_css',
							'label'       => esc_html__( 'Custom CSS', 'learnpress' ),
							'type'        => Controls_Manager::CODE,
							'label_block' => true,
							'language'    => 'css',
							'description' => 'Should start with selector before style. Ex: selector .[className] {color: red;}',
						],
						[ 'method' => 'end_popover' ],
					],
					'prevent_empty' => false,
					'title_field'   => '{{{ info_name }}}',
				]
			),
		]
	),
);

// Fields tab style
$style_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'filter_tag_style',
		esc_html__( 'Filter Field Style', 'learnpress' ),
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
	'learn-press/elementor/courseFilter/courser-filter-field',
	array_merge(
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-field/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/courseFilter/courser-filter-field/tab-styles',
			$style_fields
		)
	)
);