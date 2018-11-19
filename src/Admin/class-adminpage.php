<?php
/**
 * Admin Page
 *
 * @package BPCUT\Admin\AdminPage
 */

namespace BPCUT\Admin;

use BPCUT\Library\Views;

/**
 * Class AdminPage
 *
 * @package BPCUT\Admin\
 */
class AdminPage {

	/**
	 * Default capability
	 *
	 * @var string
	 */
	protected $capability = 'list_users';

	/**
	 * Default page slug
	 *
	 * @var string
	 */
	protected $slug = 'bpcut';

	/**
	 * Add menu hooks
	 */
	public function hook_menu() {
		$title      = __( 'Codeable User Test', 'bpcut' );
		$menu_title = __( 'Codeable Users', 'bpcut' );

		add_menu_page( $title, $menu_title, $this->capability, $this->slug, [ $this, 'display' ], 'dashicons-groups' );
	}

	/**
	 * Add static file hooks
	 *
	 * @param string $hook - the page url.
	 */
	public function hook_enqueue_static_files( $hook ) {
		global $wp_roles;

		// we want to load those files only on our own admin page.
		if ( 'toplevel_page_bpcut' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'bpcut-main-style',
			plugins_url( 'static/css/bp-styles.css', BPCUT_PLUGIN_DIR_FULL . basename( __FILE__ ) ),
			[ 'bpcut-datatables-style' ],
			BPCUT_VERSION
		);

		wp_enqueue_style(
			'bpcut-datatables-style',
			plugins_url( 'static/external/datatables.min.css', BPCUT_PLUGIN_DIR_FULL . basename( __FILE__ ) ),
			[],
			'1.10.18'
		);

		wp_enqueue_script(
			'bpcut-main-script',
			plugins_url( 'static/js/bp-main.js', BPCUT_PLUGIN_DIR_FULL . basename( __FILE__ ) ),
			[ 'jquery', 'bpcut-datatables-script' ],
			BPCUT_VERSION,
			true
		);

		$url_params = [
			'action'      => 'bpcut_get_users',
			'bpcut-nonce' => wp_create_nonce( 'admin_url_users' ),
		];
		$ajax_url   = 'admin-ajax.php?' . http_build_query( $url_params );

		wp_localize_script(
			'bpcut-main-script',
			'ajax_get_users_url',
			$ajax_url
		);

		$roles = array_map(
			function( $item ) {
				return $item['name']; },
			$wp_roles->roles
		);
		wp_localize_script( 'bpcut-main-script', 'wp_defined_roles', $roles );

		wp_enqueue_script(
			'bpcut-datatables-script',
			plugins_url( 'static/external/datatables.min.js', BPCUT_PLUGIN_DIR_FULL . basename( __FILE__ ) ),
			[ 'jquery' ],
			'1.10.18',
			true
		);

	}

	/**
	 * Render the view
	 */
	public function display() {
		Views::render( 'index' );
	}

}
