<?php
/**
 * Class CourseFilterFieldElementor
 *
 * @sicne 4.2.3
 * @version 1.0.0
 */

namespace LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\Sections;

use Elementor\Plugin;
use Exception;
use LP_Course;
use LP_Course_DB;
use LP_Course_Filter;
use LP_Request;
use Throwable;
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\CourseFilterBaseElementor;
use LearnPress\Helpers\Config;
use LearnPress\Helpers\Template;
use LearnPress\ExternalPlugin\Elementor\LPElementorWidgetBase;
use LearnPress\TemplateHooks\Course\FilterCourseTemplate;

class CourseFilterFieldElementor extends CourseFilterBaseElementor {
	public function __construct( $data = [], $args = null ) {
		$this->title    = esc_html__( 'Course Filter Field', 'learnpress' );
		$this->name     = 'course_filter_field';
		$this->keywords = [ 'Course filter', 'name', 'seartag' ];
		$this->icon     = 'eicon-tags';
		parent::__construct( $data, $args );
	}

	protected function register_controls() {
		$this->controls = Config::instance()->get( 'field', 'elementor/courseFilter/sections' );
		parent::register_controls();
	}

	/**
	 * Show content of widget
	 *
	 * @return void
	 */
	public function render() {
		try {

			$settings = $this->get_settings_for_display();
			$course_filter_tag = FilterCourseTemplate::instance();
			
			
			$repeater_items = isset($settings['field_item']) ? $settings['field_item'] : array();
			$course_layout= isset($settings['course_layout']) ? $settings['course_layout'] : '';
			$column_item =isset($settings['number_column_item']) ? $settings['number_column_item'] : '';

			if (!empty($repeater_items)) {
				echo '<form class="lp-form-course-filter-elementor '. esc_html($course_layout) .' landscape_col_'. esc_html($column_item) .'">';
				echo $course_filter_tag->html_search(); 
				
				foreach ($repeater_items as $item) {
					
					$type_layout = isset($item['type_show']) ? $item['type_show'] : '';
					$html_tag_title = isset($item['html_tag_title']) ? $item['html_tag_title'] : 'h4';
					$title = isset($item['info_name']) ? $item['info_name'] : '';
					$icon_title = isset($item['filter_icon']) ? $item['filter_icon'] : '';
					$icon = !empty( $item['filter_icon']['value'] ) ? $item['filter_icon']['value'] : '';
					$icon_library = !empty( $item['filter_icon']['library'] ) ? $item['filter_icon']['library'] : 'Font Awesome 5 Free';

					
					echo '<div class="lp-form-course-filter-wrapper '. esc_html($type_layout) .'">';	
					echo '<div class="lp-form-course-filter__title">';
					echo '<' . esc_attr($html_tag_title) . ' class="course-filter-title"' . '>';
					if ($type_layout === "dropdown") {					
						echo esc_html($title) .'<div class="selectedCount"></div>';
					} else {
						echo esc_html($title);
					}	
					echo '</' . esc_attr($html_tag_title) . '>';
					
					if ( !empty( $icon ) ) {
						echo '<span class="' . esc_attr( $icon_library ) . ' ' . esc_attr( $icon ) . '"></span>';
					}
					
					echo '</div>';
					
					$field_name = $item['field_name'] ?? '';
					switch ($field_name) {
						case 'author':
							echo $course_filter_tag->html_author();
							break;
						case 'tag':
							echo $course_filter_tag->html_tag();
							break;
						case 'level':
							echo $course_filter_tag->html_level();
							break;
						case 'price':
							echo $course_filter_tag->html_price();
							break;
						case 'category':
							echo $course_filter_tag->html_category();
							break;
						default:
							break;
					}
					echo '</div>';
				}
				echo '<div class="lp-form-course-filter-btn">';
				echo $course_filter_tag->html_btn_submit();
				echo $course_filter_tag->html_btn_reset(); 
				echo '</div>';
				echo '</form>';
			}
			
		} catch ( \Throwable $e ) {
			echo $e->getMessage();
		}
		

	}
	public function get_style_depends() {
		wp_register_style( 'learnpress', LP_PLUGIN_URL . 'assets/css/learnpress.css', array(), uniqid() );

		return array( 'learnpress' );
	}
	public function get_script_depends() {

		wp_register_script( 'lp-widget-course-filter', LP_PLUGIN_URL . 'assets/src/js/admin/lp-widget-course-filter.js', array(), uniqid() );

		return array( 'lp-widget-course-filter' );
		
		wp_register_script( 'lp-widget-course-filter-2', LP_PLUGIN_URL . 'assets/src/apps/js/frontend/lp-widget-course-filter.js', array(), uniqid() );

		return array( 'lp-widget-course-filter-2' );
	}
}