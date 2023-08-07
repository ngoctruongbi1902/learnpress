<?php
/**
 * Elementor Controls for widget Course Filter settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'course_filter',
		esc_html__( 'Course Filter', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			'course_layout'       => LPElementorControls::add_control_type_select(
			'course_layout',
				esc_html__( 'Layout Course Filter', 'learnpress' ),
				[
					'landscape' => esc_html__( 'Landscape', 'learnpress' ),
					'portrait' => esc_html__( 'Portrait', 'learnpress' ),
				],
				'portrait'
			),
			'number_column_item'       => LPElementorControls::add_control_type_select(
				'number_column_item',
					esc_html__( 'The number of items displayed on a row in case of Landscape layout', 'learnpress' ),
					[
						'1' => esc_html__( '1', 'learnpress' ),
						'2' => esc_html__( '2', 'learnpress' ),
						'3' => esc_html__( '3', 'learnpress' ),
						'4' => esc_html__( '4', 'learnpress' ),
						'5' => esc_html__( '5', 'learnpress' ),
						'6' => esc_html__( '6', 'learnpress' ),
					],
					'2'
				),
		]	
		
	),
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
						'info_name' => 'Filter Item',
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
							'name'        => 'html_tag_title',
							'label'       => esc_html__( 'Html tag title', 'learnpress' ),
							'type'        => Controls_Manager::SELECT2,
							'multiple' => false,
							'options' => [
								'h1'   => esc_html__( 'H1', 'learnpress' ),
								'h2'  => esc_html__( 'H2', 'learnpress' ),
								'h3' => esc_html__( 'H3', 'learnpress' ),
								'h4'  => esc_html__( 'H4', 'learnpress' ),
								'h5' => esc_html__( 'H5', 'learnpress' ),
								'h6' => esc_html__( 'H6', 'learnpress' ),
								'span' => esc_html__( 'span', 'learnpress' ),
								'div' => esc_html__( 'div', 'learnpress' ),		
								'p'         => esc_html__( 'p', 'learnpress' ),		
							],
							'default' => 'h4'
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
							'default' => 'category'
						],
						[
							'name'  => 'type_show',
							'label' => esc_html__( 'Type Show Filter', 'learnpress' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'list'  => esc_html__( 'List', 'learnpress' ),
								'dropdown' => esc_html__( 'Dropdown', 'learnpress' ),
								'accordion' => esc_html__( 'Accordion', 'learnpress' ),								
							],
							'default' => 'dropdown',
						],
						[
							'name'        => 'filter_icon',
							'label'       => esc_html__( 'Filter Icon', 'learnpress' ),
							'label_block' => true,
							'type'        => Controls_Manager::ICONS,
							'skin'        => 'inline',
							'label_block' => false,
							'default'     => array(
								'value'   => 'fas fa-angle-down',
								'library' => 'Font Awesome 5 Free',
							),
						],
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
		'field_search',
		esc_html__( 'Search Field', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'form-search',
			'.lp-course-filter-search-field input',[],['text_display','text_color_hover','text_background_hover']
        ),
    ),
	LPElementorControls::add_fields_in_section(
		'title_field_item',
		esc_html__( 'Title Field', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'title',
			'.lp-form-course-filter__title .course-filter-title',[],['text_display','btn_border_radius']
        ),
    ),
    LPElementorControls::add_fields_in_section(
		'list_item_filter',
		esc_html__( 'List Content', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-item',
			'.lp-form-course-filter__content .lp-course-filter__field',[],['text_display','btn_border_radius']
		)
	),
	LPElementorControls::add_fields_in_section(
		'dropdown_wrapper',
		esc_html__( 'DropDown Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-dropdown',
			'.lp-form-course-filter-wrapper.dropdown .lp-form-course-filter__item',[],['text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'accordion_wrapper',
		esc_html__( 'Accordion Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-accordion',
			'.lp-form-course-filter-wrapper.accordion .lp-form-course-filter__item',[],['text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'list_wrapper',
		esc_html__( 'List Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-list',
			'.lp-form-course-filter-wrapper.list .lp-form-course-filter__item',[],['text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'button_filter',
		esc_html__( 'Button Filter', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'button_filter',
			'.lp-form-course-filter-btn button',[],['padding','text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'result_filter',
		esc_html__( 'Result Filter', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'result_filter',
			'.lp-course-filter-search-result',[],['text_display','text_typography','text_shadow','text_color','text_color_hover']
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