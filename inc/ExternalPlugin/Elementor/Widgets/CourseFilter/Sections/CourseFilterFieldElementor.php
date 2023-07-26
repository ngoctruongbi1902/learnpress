<?php
/**
 * Class InstructorTitleElementor
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
	protected function render() {
		try {
			// $settings = $this->get_settings_for_display();
            $course_filter_tag = FilterCourseTemplate::instance();
            echo $course_filter_tag -> html_tag();
			echo $course_filter_tag -> html_category();
			echo $course_filter_tag -> html_price();
			echo $course_filter_tag -> html_author();

			$settings = $this->get_settings_for_display();

			// $repeater_items = isset($settings['field_item']) ? $settings['field_item'] : array();

			// if (!empty($repeater_items)) {
			// 	echo '<div>'; 

			// 	foreach ($repeater_items as $item) {
			// 		$course_filter_tag = FilterCourseTemplate::instance();
			// 		$title = isset($item['info_name']) ? $item['info_name'] : '';
			// 		$description = isset($item['field_name']) ? $item['field_name'] : '';
					
			// 		if (is_array($description)) {
			// 			$description = implode(', ', $description);
			// 		}
					
			// 		echo '<div class="lp-form-course-filter__item">';
			// 		echo '<div class="lp-form-course-filter__title">' . esc_html($title) . '</div>';
			// 		echo '<p>' . esc_html('html_' . $description.'()') . '</p>'; 
					
			// 		// echo $course_filter_tag -> html_tag();
        	// 		// echo $course_filter_tag ->  esc_html('html_' . $description.'()');
					
			// 		echo '</div>';
			// 	}

			// 	echo '</div>'; 
			// }

		} catch ( \Throwable $e ) {
			echo $e->getMessage();
		}
	}
}