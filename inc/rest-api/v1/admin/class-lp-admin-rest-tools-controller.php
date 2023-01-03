<?php

/**
 * Class LP_REST_Admin_Tools_Controller
 *
 * @since 4.0.3
 * @author tungnx
 * @version 1.0.1
 */
class LP_REST_Admin_Tools_Controller extends LP_Abstract_REST_Controller {
	public function __construct() {
		$this->namespace = 'lp/v1/admin';
		$this->rest_base = 'tools';
		parent::__construct();
	}

	/**
	 * Register rest routes.
	 */
	public function register_routes() {
		$this->routes = array(
			'create-indexs'      => array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_indexs' ),
					'permission_callback' => '__return_true',
				),
			),
			'list-tables-indexs' => array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'get_list_tables_indexs' ),
					'permission_callback' => '__return_true',
				),
			),
			'clean-tables'       => array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'clean_tables' ),
					'permission_callback' => '__return_true',
				),
			),
			'admin-notices'      => array(
				array(
					'methods'             => WP_REST_Server::ALLMETHODS,
					'callback'            => array( $this, 'admin_notices' ),
					'permission_callback' => '__return_true',
				),
			),
			'assign-course'      => array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'assign_course' ),
					'permission_callback' => '__return_true',
				),
			),
			'remove-order-users-courses'      => array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'remove_order_users_courses' ),
					'permission_callback' => '__return_true',
				),
			),
		);

		parent::register_routes();
	}

	public function remove_order_users_courses( WP_REST_Request $request ) {
		$params = $request->get_params();
		$response = new stdClass();
		$response->status = 'error';
		$response->status = __('Error', 'learnpress' );
		$list_users = $params['listUsers'] ?: array();
		$list_courses = $params['listCourses'] ?: array();

		try {

			if ( empty( $list_courses[0] ) ) {
				throw new Exception( __( 'Please select courses', 'learnpress' ) );
			}
			if ( empty( $list_users[0] ) ) {
				throw new Exception( __( 'Please select users', 'learnpress' ) );
			}

			global $wpdb;
			$format     = array_fill( 0, count( $list_courses ), '%d' );
			$args       = $list_courses;
			$args[]     = LP_COURSE_CPT;
			$query      = $wpdb->prepare( "SELECT item_id, user_id FROM {$wpdb->learnpress_user_items} WHERE item_id IN(" . implode( ',', $format ) . ') AND item_type = %s', $args );
			$item_ids   = $wpdb->get_results( $query ); //get list courses enrolled

			if ( ! empty( $item_ids ) ) {
				$total  = count( $item_ids );
				$limit  = 10;
				$params = array(
					'handle_name' => 'remove_order',
					'limit'       => $limit,
					'offset'      => 0,
					'total_page'  => ceil( $total / $limit ),
					'item_ids'    => $item_ids,
					'list_users'  => $list_users,
				);
				$bg = LP_Background_Remove_Order_Users_Courses::instance();
				$bg->data( $params )->dispatch();

				$response->status = 'success';
				$response->message = __('Remove Successfully', 'learnpress' );
			}

		} catch ( Exception $e ) {
			$response->status = 'error';
			$response->message = $e->getMessage();
		}

		return rest_ensure_response( $response );
	}

	public function assign_course( WP_REST_Request $request ) {
		$params = $request->get_params();
		$response = new stdClass();
		$response->status = 'success';
		$response->message = __('Assign Successfully', 'learnpress' );

		$type       = $params['type'] ?: '';
		$list_users = $params['listUsers'] ?: array();
		$list_roles = $params['listRoles'] ?: array();
		$course_id  = absint( $params['courseID'] ) ?: 0;

		try {

			if ( empty( $course_id ) ) {
				throw new Exception( __( 'Course ID invalid', 'learnpress' ) );
			}

			if ( empty( $type ) ) {
				throw new Exception( __( 'Please select type assign', 'learnpress' ) );
			}

			if ( $type == 'users' ) {
				if ( empty( $list_users[0]) ) {
					throw new Exception( __( 'Please select Users to assign Course', 'learnpress' ) );
				}
			} else {
				if ( empty( $list_roles[0]) ) {
					throw new Exception( __( 'Please select Roles to assign Course', 'learnpress' ) );
				} else {
					$user_by_role = get_users(
						array(
							'role__in' => $list_roles
						)
					);
					if ( ! empty( $user_by_role ) ) {
						$list_users = array();
						foreach (  $user_by_role as $user ) {
							$list_users[] = $user->ID;
						}
					}
				}
			}
			//assign users
			$this->handle_assign_course( $course_id , $list_users );

		} catch ( Exception $e ) {
			$response->status = 'error';
			$response->message = $e->getMessage();
		}

		return rest_ensure_response( $response );
	}

	public function handle_assign_course( $course_id, $list_users ) {

		if ( ! empty( $list_users ) ) {
			$lp_user_items_db = LP_User_Items_DB::getInstance();
			foreach( $list_users as $user_id ) {
				// Delete lp_user_items old
				$lp_user_items_db->delete_user_items_old( $user_id, $course_id );
				// End
				$user_item_data = [
					'user_id'      => $user_id,
					'item_id'      => $course_id,
					'graduation'   => LP_COURSE_GRADUATION_IN_PROGRESS,
					'status'       => LP_COURSE_ENROLLED,
					'start_time'   => time(),
				];
				$user_item_new_or_update = new LP_User_Item_Course( $user_item_data );
				$result                  = $user_item_new_or_update->update();
			}
		}
	}

	/**
	 * Create indexs.
	 *
	 * @param WP_REST_Request $request .
	 *
	 * @return void
	 */
	public function create_indexs( WP_REST_Request $request ) {
		$response = new LP_REST_Response();
		$lp_db    = LP_Database::getInstance();

		try {
			$tables     = $request->get_param( 'tables' );
			$table      = $request->get_param( 'table' );
			$table_keys = array();

			$lp_db->wpdb->query( 'SET autocommit = 0' );

			if ( empty( $tables ) ) {
				throw new Exception( 'Param invalid!' );
			} else {
				$table_keys = array_keys( $tables );
			}

			if ( empty( $table ) ) {
				$table = $lp_db->tb_lp_user_items;
			} elseif ( array_key_exists( $table, $table_keys ) ) {
				throw new Exception( 'Table invalid!' );
			}

			// Create Indexs for a table.
			if ( $table === $lp_db->tb_lp_question_answermeta ) {
				$lp_db->drop_indexs_table( $lp_db->tb_lp_question_answermeta );
				$lp_db->wpdb->query(
					"
					ALTER TABLE {$lp_db->tb_lp_question_answermeta}
					ADD INDEX question_answer_meta (`learnpress_question_answer_id`, `meta_key`(150))
					"
				);
				$lp_db->check_execute_has_error();
			} elseif ( $table === $lp_db->tb_lp_section_items ) {
				$lp_db->drop_indexs_table( $lp_db->tb_lp_section_items );

				$lp_db->wpdb->query(
					"
					ALTER TABLE {$lp_db->tb_lp_section_items}
					ADD INDEX section_item (`section_id`, `item_id`)
					"
				);
				$lp_db->check_execute_has_error();
			} else {
				$lp_db->add_indexs_table( $table, $tables[ $table ] );
			}

			// Set next table key.
			$index_key = array_search( $table, $table_keys );
			++ $index_key;

			if ( ! array_key_exists( $index_key, $table_keys ) ) {
				$response->status        = 'finished';
				$response->data->percent = 100;
			} else {
				$response->data->table   = $table_keys[ $index_key ];
				$response->data->percent = 100;
				$response->status        = 'success';
			}
		} catch ( Exception $e ) {
			$response->message = $e->getMessage();
		}

		wp_send_json( $response );
	}

	public function get_list_tables_indexs( WP_REST_Request $request ) {
		$response = new LP_REST_Response();
		$lp_db    = LP_Database::getInstance();

		$tables_indexs = array(
			$lp_db->tb_lp_user_items          => array( 'user_id', 'item_id', 'item_type', 'status', 'ref_type', 'ref_id', 'parent_id' ),
			$lp_db->tb_lp_user_itemmeta       => array( 'learnpress_user_item_id', 'meta_key', 'meta_value' ),
			$lp_db->tb_lp_quiz_questions      => array( 'quiz_id', 'question_id' ),
			$lp_db->tb_lp_question_answers    => array( 'question_id' ),
			$lp_db->tb_lp_question_answermeta => '',
			$lp_db->tb_lp_order_items         => array( 'order_id', 'item_id', 'item_type' ),
			$lp_db->tb_lp_order_itemmeta      => array( 'learnpress_order_item_id', 'meta_key', 'meta_value' ),
			$lp_db->tb_lp_sections            => array( 'section_course_id' ),
			$lp_db->tb_lp_section_items       => '',
		);

		$response->data->tables = $tables_indexs;
		$response->data->table  = $lp_db->tb_lp_user_items;
		$response->status       = 'success';

		wp_send_json( $response );
	}

	public function clean_tables( WP_REST_Request $request ) {
		$response            = new LP_REST_Response();
		$lp_db_sessions      = LP_Sessions_DB::getInstance();
		$tables              = $request->get_param( 'tables' );
		$item_before_process = $request->get_param( 'itemtotal' );
		if ( empty( $tables ) ) {
			throw new Exception( 'Param invalid!' );
		}

		if ( empty( $item_before_process ) ) {
			$item_before_process = 0;
		}

		if ( $item_before_process == 0 ) {
			$response->data->percent = 100;
			$response->status        = 'finished';
			wp_send_json( $response );
		}

		try {
			// Delete result in table select
			if ( $tables == 'learnpress_sessions' ) {
				$lp_db_sessions->delete_rows();
				// check the number of lines remaining after each query
				$item_after_process        = $lp_db_sessions->count_row_db_sessions();
				$response->data->processed = $item_before_process - $item_after_process;
				$percent                   = ( ( $item_before_process - $item_after_process ) / $item_before_process ) * 100;
				$response->data->percent   = number_format_i18n( $percent, '2' );
			}
			if ( $response->data->percent == 100 ) {
				$response->status = 'finished';
			} else {
				$response->status = 'success';
			}
		} catch ( Exception $e ) {
			$response->message = $e->getMessage();
		}
		wp_send_json( $response );
	}

	/**
	 * Show admin notices.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return void
	 * @since 4.1.7.3.2
	 * @version 1.0.0
	 */
	public function admin_notices( WP_REST_Request $request ) {
		$response = new LP_REST_Response();
		$content  = '';

		try {
			$params               = $request->get_params();
			$admin_notices        = ! empty( $_COOKIE['lp_admin_notices_dismiss'] ) ? json_decode( wp_unslash( $_COOKIE['lp_admin_notices_dismiss'] ) ) : [];
			$lp_beta_version_info = LP_Admin_Notice::check_lp_beta_version();

			if ( isset( $params['dismiss'] ) ) {
				if ( $lp_beta_version_info ) {
					// Store version of LP beta to session.
					learn_press_setcookie( 'lp_beta_version', $lp_beta_version_info['version'] ?? 0 );
				}

				$admin_notices[ $params['dismiss'] ] = $params['dismiss'];
				learn_press_setcookie( 'lp_admin_notices_dismiss', json_encode( $admin_notices ) );
				$response->message = __( 'Dismissed!', 'learnpress' );
			} else {
				$show_notice_lp_beta_version = false;
				/**
				 * Check if LP beta version is not dismissed or dismissed version lower than current version, will bet to show notice.
				 */
				if ( $lp_beta_version_info && ! isset( $_GET['tab'] ) &&
					( ! isset( $_COOKIE['lp_beta_version'] ) || version_compare( $_COOKIE['lp_beta_version'], $lp_beta_version_info['version'], '<' ) ) ) {
					$show_notice_lp_beta_version = true;
				}

				$rules = apply_filters(
					'learn-press/admin-notices',
					[
						// Check wp_remote call success.
						'check_wp_remote'   => [
							'template' => 'admin-notices/wp-remote.php',
							'check'    => LP_Admin_Notice::check_wp_remote(),
						],
						// Check name plugin base.
						'check_plugin_base' => [
							'template' => 'admin-notices/plugin-base.php',
							'check'    => LP_Admin_Notice::check_plugin_base(),
						],
						// Show beta version of LP.
						'lp-beta-version'   => [
							'template' => 'admin-notices/beta-version.php',
							'check'    => $show_notice_lp_beta_version,
							'info'     => $lp_beta_version_info,
							'dismiss'  => 1,
						],
						// Show message needs upgrades database compatible with LP version current.
						'lp-upgrade-db'     => [
							'template' => 'admin-notices/upgrade-db.php',
							'check'    => LP_Updater::instance()->check_lp_db_need_upgrade(),
						],
						// Show message wrong permalink structure.
						'lp-permalink'      => [
							'template' => 'admin-notices/permalink-wrong.php',
							'check'    => ! get_option( 'permalink_structure' ),
						],
						// Show notice setup wizard.
						'lp-setup-wizard'   => [
							'template' => 'admin-notices/setup-wizard.php',
							'check'    => ! get_option( 'learn_press_setup_wizard_completed', false ) && ! isset( $admin_notices['lp-setup-wizard'] ),
							'dismiss'  => 1,
						],
					]
				);

				foreach ( $rules as $template_data ) {
					$content .= learn_press_admin_view( $template_data['template'] ?? '', [ 'data' => $template_data ], true, true );
				}
			}

			$response->status        = 'success';
			$response->data->content = $content;
		} catch ( Exception $e ) {
			$response->message = $e->getMessage();
		}

		wp_send_json( $response );
	}
}
