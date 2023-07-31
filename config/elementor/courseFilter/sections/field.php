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
		'title_field_item',
		esc_html__( 'Title Field Item', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'title',
			'.lp-form-course-filter__title',[],['text_display']
        ),
		LPElementorControls::add_controls_style_button(
			'title-button',
			'.lp-form-course-filter__title'
        ),
    ),
    LPElementorControls::add_fields_in_section(
		'list_item_filter',
		esc_html__( 'List Item Filter', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_text(
			'filter-item',
			'.lp-form-course-filter__content .lp-course-filter__field'
		)
	),
	LPElementorControls::add_fields_in_section(
		'dropdown_wrapper',
		esc_html__( 'DropDown Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-dropdown',
			'.lp-form-course-filter-wrapper.dropdown .lp-form-course-filter__content',[],['text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'accordion_wrapper',
		esc_html__( 'Accordion Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-accordion',
			'.lp-form-course-filter-wrapper.accordion .lp-form-course-filter__content',[],['text_display']
		)
	),
	LPElementorControls::add_fields_in_section(
		'list_wrapper',
		esc_html__( 'List Wrapper', 'learnpress' ),
		Controls_Manager::TAB_STYLE,
		LPElementorControls::add_controls_style_button(
			'filter-list',
			'.lp-form-course-filter-wrapper.list .lp-form-course-filter__content',[],['text_display']
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