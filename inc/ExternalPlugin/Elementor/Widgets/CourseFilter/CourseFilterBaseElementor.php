<?php
/**
 * Class SingleInstructorBaseElementor
 *
 * Has general methods for sections single instructor widgets use
 *
 * @sicne 4.2.3
 * @version 1.0.0
 */

namespace LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter;

use Elementor\Plugin;
use Exception;
use LearnPress\ExternalPlugin\Elementor\LPElementorWidgetBase;
use LearnPress\Helpers\Config;
use LP_User;

class CourseFilterBaseElementor extends LPElementorWidgetBase {
	/**
	 * Set category for widget
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'learnpress_course_filter' );
	}

}