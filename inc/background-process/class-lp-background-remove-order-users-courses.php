<?php
/**
 * Class LP_Background_Remove_Order_Users_Courses
 *
 * Single to run not schedule, run one time and done when be call
 *
 * @since 4.1.1
 * @author tungnx
 * @version 1.0.1
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Background_Remove_Order_Users_Courses' ) ) {
	class LP_Background_Remove_Order_Users_Courses extends LP_Async_Request {
		protected $action = 'background_remove_order_users_courses';

		protected $offset     = 0;
		protected $limit      = 0;
		protected $total_page = 0;
		protected $item_ids   = [];
		protected $list_users = [];

		protected static $instance;

		protected function handle() {
			try {
				$handle_name      = LP_Helper::sanitize_params_submitted( $_POST['handle_name'] ?? '' );
				$this->list_users = LP_Helper::sanitize_params_submitted( $_POST['list_users'] ?? [] );
				$this->item_ids   = LP_Helper::sanitize_params_submitted( $_POST['item_ids'] ?? [] );
				$this->offset     = LP_Helper::sanitize_params_submitted( $_POST['offset'] ?? 0 );
				$this->limit	  = LP_Helper::sanitize_params_submitted( $_POST['limit'] ?? 0 );
				$this->total_page = LP_Helper::sanitize_params_submitted( $_POST['total_page'] ?? 0 );

				if ( empty( $handle_name ) ) {
					return;
				}

				switch ( $handle_name ) {
					case 'remove_order':
						$item_ids = array_slice( $this->item_ids, $this->offset, $this->limit, true);
						$this->remove_order( $item_ids );
						break;
					default:
						break;
				}
			} catch ( Throwable $e ) {
				error_log( $e->getMessage() );
			}
		}

		/**
		 * Remove order for user
		 *
		 * @throws Exception
		 */
		protected function remove_order( $item_ids ) {
			$lp_user_items_db = LP_User_Items_DB::getInstance();
			$this->offset++;

			try{
				foreach( $item_ids as $item ) {
					if( in_array( $item['user_id'], $this->list_users ) )  {
						$lp_user_items_db->delete_user_items_old( $item['user_id'], $item['item_id'] );
					}
				}

				if( $this->offset < $this->total_page ) {
					$this->data( array(
						'handle_name' => 'remove_order',
						'item_ids'    => $this->item_ids,
						'list_users'  => $this->list_users,
						'offset'      => $this->offset,
						'limit'       => $this->limit,
						'total_page'  => $this->total_page,
					) )->dispatch();
				}

			} catch ( Throwable $e ) {
				error_log($e->getMessage());
			}

		}

		/**
		 * @return LP_Background_Remove_Order_Users_Courses
		 */
		public static function instance(): self {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	// Must run instance to register ajax.
	LP_Background_Remove_Order_Users_Courses::instance();
}
