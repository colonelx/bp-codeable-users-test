<?php

define('BPCUT_PLUGIN_DIR_FULL', '');
define('BPCUT_VERSION', '');
class AdminPageTest extends \WP_Mock\Tools\TestCase
{
    private $stub;
    
    public function setUp() {
        \WP_Mock::setUp();
        $this->stub = $this->getMockBuilder(\BPCUT\Admin\AdminPage::class)
            ->setMethods(['display'])
            ->getMock();
    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }

    public function testHookMenu()
    {
        \WP_Mock::userFunction(
            'add_menu_page', 
            [
                'args' => [
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('callable'),
                    \WP_Mock\Functions::type('string'),
                ],
                'times' => 1
            ]
        );
        $this->stub->hook_menu();
        $this->assertConditionsMet();
    }

    public function testHookEnqueueStaticFilesInvalidHook()
    {
        \WP_Mock::userFunction(
            'wp_enqueue_style',
            [
                'args' => [
                    'bpcut-main-style',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 0
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_style',
            [
                'args' => [
                    'bpcut-datatables-style',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 0
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_script',
            [
                'args' => [
                    'bpcut-main-script',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 0
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_script',
            [
                'args' => [
                    'bpcut-datatables-script',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 0
            ]
        );


        $this->stub->hook_enqueue_static_files('invalid_hook');

        $this->assertConditionsMet();
    }

    public function testHookEnqueueStaticFilesValidHook()
    {
        global $wp_roles;
        $wp_roles = new stdClass();
        $wp_roles->roles = [];
        \WP_Mock::userFunction(
            'plugins_url',
            [ 
                'args' => [\WP_Mock\Functions::type('string'), \WP_Mock\Functions::type('string')],
                'return' => ''
            ]
        );

        \WP_Mock::userFunction(
            'admin_url',
            [
                'args' => [ \WP_Mock\Functions::type('string') ],
                'return' => ''
            ]
        );

        \WP_Mock::userFunction(
            'wp_localize_script',
            [
                'args' => [
                    \WP_Mock\Functions::type('string'),
                    'ajax_get_users_url',
                    \WP_Mock\Functions::type('string'),
                ]
            ]
        );

        \WP_Mock::userFunction(
            'wp_localize_script',
            [
                'args' => [
                    \WP_Mock\Functions::type('string'),
                    'wp_defined_roles',
                    \WP_Mock\Functions::type('array'),
                ]
            ]
        );

        \WP_Mock::userFunction(
            'wp_enqueue_style',
            [
                'args' => [
                    'bpcut-main-style',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 1
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_style',
            [
                'args' => [
                    'bpcut-datatables-style',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 1
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_script',
            [
                'args' => [
                    'bpcut-main-script',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 1
            ]
        );
        \WP_Mock::userFunction(
            'wp_enqueue_script',
            [
                'args' => [
                    'bpcut-datatables-script',
                    \WP_Mock\Functions::type('string'),
                    \WP_Mock\Functions::type('array'),
                    \WP_Mock\Functions::type('string')
                ],
                'times' => 1
            ]
        );


        $this->stub->hook_enqueue_static_files('toplevel_page_bpcut');

        $this->assertConditionsMet();
    }
}