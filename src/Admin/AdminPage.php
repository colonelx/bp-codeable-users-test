<?php

namespace BPCUT\Admin;

use BPCUT\Library\Views;

/**
 * Class AdminPage
 * @package BPCUT\Admin\
 */
class AdminPage 
{
    /**
     * @var string
     */
    protected $title = 'Codeable User Test';

    /**
     * @var string
     */
    protected $menu_title = 'Codeable Users';

    /**
     * @var string
     */
    protected $capability = 'list_users';

    /**
     * @var string
     */
    protected $slug = 'bpcut';

    /**
     * Add menu hooks
     */
    public function hook_menu()
    {
        add_menu_page(__($this->title, 'bpcut'), __($this->menu_title, 'bpcut'), $this->capability, $this->slug, [$this,'display'],'dashicons-groups');
    }

    /**
     * Add static file hooks
     * @param string $hook
     */
    public function hook_enqueue_static_files($hook)
    {
        global $wp_roles;

        // we want to load those files only on our own admin page.
        if ($hook !== 'toplevel_page_bpcut') {
            return;
        }
        wp_enqueue_style( 
            'bpcut-main-style', 
            plugins_url('static/css/bp-styles.css', BPCUT_PLUGIN_DIR_FULL . basename(__FILE__)),
            ['bpcut-datatables-style'],
            BPCUT_VERSION    
        );

        wp_enqueue_style( 
            'bpcut-datatables-style', 
            plugins_url('static/external/datatables.min.css', BPCUT_PLUGIN_DIR_FULL . basename(__FILE__)),
            [],
            '1.10.18'
        );

        wp_enqueue_script(
            'bpcut-main-script',
            plugins_url('static/js/bp-main.js', BPCUT_PLUGIN_DIR_FULL . basename(__FILE__)),
            ['jquery', 'bpcut-datatables-script'],
            BPCUT_VERSION
        );

        wp_localize_script( 'bpcut-main-script', 'ajax_get_users_url', admin_url('admin-ajax.php?action=bpcut_get_users') );

        $roles =  array_map(
            function($item) { return $item['name']; },
            $wp_roles->roles
        );
        wp_localize_script('bpcut-main-script', 'wp_defined_roles', $roles);

        wp_enqueue_script(
            'bpcut-datatables-script',
            plugins_url('static/external/datatables.min.js', BPCUT_PLUGIN_DIR_FULL . basename(__FILE__)),
            ['jquery'],
            '1.10.18'
        );
        
    }

    /**
     * Render the view
     */
    public function display()
    {
        Views::render('index');
    }

}