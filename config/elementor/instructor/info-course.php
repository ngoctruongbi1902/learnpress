<?php
/**
 * Elementor Controls for widget Become a teacher settings.
 *
 * @since 4.2.3
 * @version 1.0.0
 */

use Elementor\Controls_Manager;
use LearnPress\ExternalPlugin\Elementor\LPElementorControls;

// Fields tab content
$content_fields = array_merge(
	LPElementorControls::add_fields_in_section(
		'layouts',
		esc_html__( 'Item Info Course', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[
			LPElementorControls::add_control_type(
				'item_layouts',
				esc_html__( 'Add item info course', 'learnpress' ),
				[
					[
						'info_name' => 'Item Info',
						'info_html' => '{{instructor_avatar}}<a href="{{instructor_url}}" style="display: block">{{instructor_display_name}}</a><p>{{instructor_total_courses}}</p>{{instructor_total_students}}',
					],
				],
				Controls_Manager::REPEATER,
				[
					'fields'        => [
						[
							'name'        => 'info_icon',
							'label'       => esc_html__( 'Info Icon', 'learnpress' ),
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
							'mobile_default' => 'top',
							'options' => [
								'left' => [
									'title' => esc_html__( 'Left', 'learnpress' ),
									'icon' => 'eicon-h-align-left',
								],
								'top' => [
									'title' => esc_html__( 'Top', 'learnpress' ),
									'icon' => 'eicon-v-align-top',
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
							'name'        => 'info_name',
							'label'       => esc_html__( 'Info Name', 'learnpress' ),
							'type'        => Controls_Manager::TEXT,
							'label_block' => true,
						],
						[
							'name'        => 'info_description',
							'label'       => esc_html__( 'Info Description', 'learnpress' ),
							'type'        => Controls_Manager::WYSIWYG,
							'description' => 'Sections: {{instructor_avatar}}, {{instructor_url}}, {{instructor_display_name}}, {{instructor_total_courses}}, {{instructor_total_students}}',
							'label_block' => true,
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
	LPElementorControls::add_fields_in_section(
		'content',
		esc_html__( 'Content', 'learnpress' ),
		Controls_Manager::TAB_CONTENT,
		[

			'order_by' => LPElementorControls::add_control_type_select(
				'order_by',
				esc_html__( 'Order By', 'learnpress' ),
				[
					'name'      => esc_html__( 'Name a-z', 'learnpress' ),
					'desc_name' => esc_html__( 'Name z-a', 'learnpress' ),
				],
				'name'
			),
			'limit'    => LPElementorControls::add_control_type(
				'limit',
				esc_html__( 'Limit', 'learnpress' ),
				5,
				Controls_Manager::NUMBER,
				[
					'min'         => - 1,
					'max'         => 100,
					'description' => 'Number of items to show. Enter -1 to show all instructors.',
				]
			),
		]
	),
	[]
);
// Fields tab style
$style_fields = [];

return apply_filters(
	'learn-press/elementor/instructor/info-course',
	array_merge(
		apply_filters(
			'learn-press/elementor/instructor/info-course/tab-content',
			$content_fields
		),
		apply_filters(
			'learn-press/elementor/instructor/info-course/tab-styles',
			$style_fields
		)
	)
);