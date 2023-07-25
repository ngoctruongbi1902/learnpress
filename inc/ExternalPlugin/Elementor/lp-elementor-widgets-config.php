<?php

/**
 * Declare list LP widgets for elementor
 */

use LearnPress\ExternalPlugin\Elementor\Widgets\BecomeATeacherElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\InfoCourseElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseListElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\Sections\CourseFilterTitleElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\Sections\CourseFilterSearchElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\CourseFilter\Sections\CourseFilterTagElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\Sections\InstructorButtonViewElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\Sections\InstructorDescriptionElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\Sections\InstructorTitleElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\ListInstructorsElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\LoginUserFormElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\RegisterUserFormElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Instructor\SingleInstructorElementor;
use LearnPress\ExternalPlugin\Elementor\Widgets\Course\CourseMaterialElementor;
return apply_filters(
	'lp/elementor/widgets',
	[
		//'single-instructor'      => SingleInstructorElementor::class,
		'list-instructors'       => ListInstructorsElementor::class,
		'instructor-title'       => InstructorTitleElementor::class,
		'instructor-description' => InstructorDescriptionElementor::class,
		'instructor-button-view' => InstructorButtonViewElementor::class,
		'become-a-teacher'       => BecomeATeacherElementor::class,
		'info-course'            => InfoCourseElementor::class,
		'login-form'             => LoginUserFormElementor::class,
		'register-form'          => RegisterUserFormElementor::class,
		'list-courses'           => CourseListElementor::class,
		'courser-filter-title'		 => CourseFilterTitleElementor::class,
		'courser-filter-search'		 => CourseFilterSearchElementor::class,
		'courser-filter-tag'		 => CourseFilterTagElementor::class,
		// 'course-material'        => CourseMaterialElementor::class,
	]
);