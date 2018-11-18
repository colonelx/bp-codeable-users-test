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
    private $adminPageInstance;
    private $usersDataSourceInstance;

    public function run()
    {
        $this->register_hooks();
    }

    /**
     * Registers the plugin hooks.
     */
    public function register_hooks()
    {
        if(is_admin()) {
            add_action('admin_menu', [$this->get_admin_page_instance(), 'hook_menu']);
            add_action('admin_enqueue_scripts', [$this->get_admin_page_instance(), 'hook_enqueue_static_files']);

            add_action('wp_ajax_bpcut_get_users', [$this->get_users_datasource_instance(), 'get_users']);
        }
    }

    /**
     * Fetches an AdminPage instance
     * @return \BPCUT\AdminPage
     */
    protected function get_admin_page_instance()
    {
        if(!isset($this->adminPageInstance)) {
            $this->adminPageInstance = new AdminPage();
        }
        return $this->adminPageInstance;
    }

    /**
     * Fetches an UsersDatasource instance
     * @return \BPCUT\UsersDatasource
     */
    protected function get_users_datasource_instance()
    {
        if(!isset($this->usersDataSourceInstance)) {
            $this->usersDataSourceInstance = new UsersDatasource();
        }
        return $this->usersDataSourceInstance;
    }
}