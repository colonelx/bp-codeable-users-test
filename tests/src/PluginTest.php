<?php

class PluginTest extends \WP_Mock\Tools\TestCase
{
    private $stub;
    private $usersDatasourceMock;
    private $adminPageMock;
    public function setUp() {
        \WP_Mock::setUp();
        $this->stub = $this->getMockBuilder(\BPCUT\Plugin::class)
        ->disableOriginalConstructor()
        ->setMethods(['get_users_datasource_instance', 'get_admin_page_instance' ])
        ->getMock();

        $this->userDatasourceMock = new UsersDatasourceMock();
        $this->adminPageMock = new AdminPageMock();

        $this->stub->expects($this->any())
            ->method('get_users_datasource_instance')
            ->willReturn($this->userDatasourceMock);

        $this->stub->expects($this->any())
            ->method('get_admin_page_instance')
            ->willReturn($this->adminPageMock);
    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }

    
    public function testPluginRun()
    {
        $stub = $this->getMockBuilder(\BPCUT\Plugin::class)
            ->disableOriginalConstructor()
            ->setMethods(['register_hooks' ])
            ->getMock();
        $stub->expects($this->once())
            ->method('register_hooks');

        $stub->run();
    }

    public function testRegisterHooksNotAdmin()
    {
        \WP_Mock::userFunction('is_admin',['times' => 1, 'return' => false]);
        \WP_Mock::expectActionNotAdded('admin_menu', [$this->adminPageMock,'hook_menu']);
        \WP_Mock::expectActionNotAdded('adadmin_enqueue_scriptsmin_menu', [$this->adminPageMock,'hook_enqueeue_static_files']);
        \WP_Mock::expectActionNotAdded('wp_ajax_bpcut_get_users', [$this->usersDatasourceMock,'getUsers']);

        $this->stub->run();
        $this->assertConditionsMet();   
    }

    public function testRegisterHooksAdmin()
    {   
        \WP_Mock::userFunction('is_admin',['times' => 1, 'return' => true]);
        \WP_Mock::expectActionAdded('admin_menu', [$this->adminPageMock,'hook_menu']);
        \WP_Mock::expectActionAdded('admin_enqueue_scripts', [$this->adminPageMock,'hook_enqueue_static_files']);
        // \WP_Mock::expectActionAdded('wp_ajax_bpcut_get_users', [$this->usersDatasourceMock, 'getUsers']);
        $this->stub->run();
        $this->assertConditionsMet();
    }  
    
    public function testGetAdminPageInstance()
    {   
        $class = new ReflectionClass(\BPCUT\Plugin::class);
        $method = $class->getMethod('get_admin_page_instance');
        $method->setAccessible(true);
        $instance = $method->invoke(new \BPCUT\Plugin());
        $this->assertInstanceOf(\BPCUT\Admin\AdminPage::class, $instance);
    } 

    public function testGetUsersDatasourceInstance()
    {   
        $class = new ReflectionClass(\BPCUT\Plugin::class);
        $method = $class->getMethod('get_users_datasource_instance');
        $method->setAccessible(true);
        $instance = $method->invoke(new \BPCUT\Plugin());
        $this->assertInstanceOf(\BPCUT\Admin\UsersDatasource::class, $instance);
    } 
}
class AdminPageMock {
    public function hook_menu()
    { 
        return true; 
    }
}

class UsersDatasourceMock {
    public function get_users()
    {
        return true;
    }
}