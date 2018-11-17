<?php
namespace BPCUT;

use BPCUT\Admin\AdminPage;
use BPCUT\Admin\UsersDatasource;

/**
 * Class Plugin
 * @package BPCUT
 *
 * Base class for the plugin
 */
class Plugin
{

    /**
     * Plugin constructor.
     */
    public function __construct() 
    {
        $this->register_hooks();
    }

    /**
     * Registers the plugin hooks.
     */
    private function register_hooks()
    {

        if(is_admin()) {
            $adminPage = new AdminPage();
            add_action('admin_menu', [$adminPage, 'hook_menu']);
            add_action( 'admin_enqueue_scripts', [$adminPage, 'hook_enqueue_static_files'] );

            $usersDatasource = new UsersDatasource();
            add_action('wp_ajax_bpcut_get_users', [$usersDatasource, 'getUsers']);
        }
    }
}