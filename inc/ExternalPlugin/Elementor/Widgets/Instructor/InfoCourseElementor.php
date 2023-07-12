<?php
/**
 * Class SingleInstructorElementor
 *
 * @sicne 4.2.3
 * @version 1.0.0
 */

namespace LearnPress\ExternalPlugin\Elementor\Widgets\Instructor;

use LearnPress\ExternalPlugin\Elementor\LPElementorWidgetBase;
use LearnPress\Helpers\Config;

class InfoCourseElementor extends LPElementorWidgetBase {
	public function __construct( $data = [], $args = null ) {
		$this->title    = esc_html__( 'Info Course', 'learnpress' );
		$this->name     = 'info_course';
		$this->keywords = [ 'course', 'info' ];
		$this->icon     = 'eicon-document-file';
		parent::__construct( $data, $args );
	}

	protected function register_controls() {
		$this->controls = Config::instance()->get( 'info-course', 'elementor/instructor' );
		parent::register_controls();
	}

	public function render() {
		$settings = $this->get_settings_for_display();
	?>
<div class="info-course-wapper">
    <ul class="info-course-all">
        <?php
			if ( $settings['item_layouts'] ) {
				foreach ( $settings['item_layouts'] as $key => $item ) 
				{ ?>
        <li>
            <a>
                <span></span>
                <?php echo esc_html( $item['info_name'] ); ?>
                <?php echo esc_html( $item['info_description'] ); ?>
            </a>
        </li>
        <?php 
			}
			} 
		?>
    </ul>
</div>
<?php
		}

public function get_style_depends() {
wp_register_style( 'learnpress', LP_PLUGIN_URL . 'assets/css/learnpress.css', array(), uniqid() );

return array( 'learnpress' );
}
}