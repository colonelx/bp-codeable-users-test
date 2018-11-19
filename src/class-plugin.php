<?php
/**
 * Plugin init
 *
 * @package \
 */

namespace BPCUT;

use BPCUT\Admin\AdminPage;
use BPCUT\Admin\UsersDatasource;

/**
 * Class Plugin
 *
 * @package BPCUT
 *
 * Base class for the plugin
 */
class Plugin {

	/**
	 * AdminPage instance
	 *
	 * @var \BPCUT\Admin\AdminPage
	 */
	private $admin_page_instance;

	/**
	 * UserDatasource instance
	 *
	 * @var \BPCUT\Admin\UserDatasource
	 */
	private $users_datasource_instance;

	/**
	 * Run the plugin
	 */
	public function run() {
		$this->register_hooks();
	}

	/**
	 * Registers the plugin hooks.
	 */
	public function register_hooks() {
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this->get_admin_page_instance(), 'hook_menu' ] );
			add_action( 'admin_enqueue_scripts', [ $this->get_admin_page_instance(), 'hook_enqueue_static_files' ] );

			add_action( 'wp_ajax_bpcut_get_users', [ $this->get_users_datasource_instance(), 'get_users' ] );
		}
	}

	/**
	 * Fetches an AdminPage instance
	 *
	 * @return \BPCUT\AdminPage
	 */
	protected function get_admin_page_instance() {
		if ( ! isset( $this->admin_page_instance ) ) {
			$this->admin_page_instance = new AdminPage();
		}
		return $this->admin_page_instance;
	}

	/**
	 * Fetches an UsersDatasource instance
	 *
	 * @return \BPCUT\UsersDatasource
	 */
	protected function get_users_datasource_instance() {
		if ( ! isset( $this->users_datasource_instance ) ) {
			$this->users_datasource_instance = new UsersDatasource();
		}
		return $this->users_datasource_instance;
	}
}
