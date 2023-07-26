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
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\CourseFilterBaseElementor;
use LearnPress\Helpers\Config;
use LearnPress\Helpers\Template;
use LearnPress\ExternalPlugin\Elementor\LPElementorWidgetBase;

class CourseFilterTitleElementor extends CourseFilterBaseElementor {
	public function __construct( $data = [], $args = null ) {
		$this->title    = esc_html__( 'Course Filter Title', 'learnpress' );
		$this->name     = 'course_filter_title';
		$this->keywords = [ 'Course filter', 'name', 'title' ];
		$this->icon     = 'eicon-site-title';
		parent::__construct( $data, $args );
	}

	protected function register_controls() {
		$this->controls = Config::instance()->get( 'title', 'elementor/courseFilter/sections' );
		parent::register_controls();
	}

	/**
	 * Show content of widget
	 *
	 * @return void
	 */
	protected function render() {
		try {
			$settings = $this->get_settings_for_display();
			$heading_tag = isset($settings['course_filter_html']) ? $settings['course_filter_html'] : 'h2';
			
			echo '<' . esc_attr($heading_tag) . ' class="course-filter-title"' . '>' . esc_html($settings['course_filter_title']) . '</' . esc_attr($heading_tag) . '>';
			echo '<div  class="course-filter-description" >' . esc_html($settings['course_filter_description']) . '</div>';

		} catch ( \Throwable $e ) {
		echo $e->getMessage();
		}
	}
}