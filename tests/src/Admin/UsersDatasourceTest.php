<?php

class UsersDatasourceTest extends \WP_Mock\Tools\TestCase
{
    private $stub;
    
    public function setUp() {
        \WP_Mock::setUp();
        $this->stub = $this->getMockBuilder(\BPCUT\Admin\UsersDatasource::class)
            ->setMethods(['render_result'])
            ->getMock();
    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }

    public function testGetUsers()
    {
        $this->stub->expects($this->any())
            ->method('render_result')
            ->will($this->returnCallback([$this, 'assertObjectIsValid']));

        $_POST = [
            'draw' => 1,
            'columns' => [
                0 => [
                    'name' => 'display_name'
                ]
            ],
            'order' => [
                0 => [
                    'column' => 0,
                    'dir' => 'asc'
                ]
            ],
            'length' => 1,
            'start' => 0
        ];
        $roles = new stdClass();
        $roles->roles = ['role'];
        \WP_Mock::userFunction('get_userdata',
        [
            'args' => [1],
            'return' => $roles
        ]);

        $returned_object = $this->stub->get_users(); 
        $this->assertConditionsMet();
    }

    public function testGetUsersWithRole()
    {
        $this->stub->expects($this->any())
            ->method('render_result')
            ->will($this->returnCallback([$this, 'assertSearchArgsIsPassed']));

        $_POST = [
            'draw' => 1,
            'columns' => [
                0 => [
                    'name' => 'display_name'
                ]
            ],
            'order' => [
                0 => [
                    'column' => 0,
                    'dir' => 'asc'
                ]
            ],
            'search' => ['value' => 'some-string'],
            'length' => 1,
            'start' => 0
        ];
        $roles = new stdClass();
        $roles->roles = ['role'];
        \WP_Mock::userFunction('get_userdata',
        [
            'args' => [1],
            'return' => $roles
        ]);

        $returned_object = $this->stub->get_users(); 
        $this->assertConditionsMet();
    }

    public function assertObjectIsValid($object)
    {
       
        $this->assertEquals(1, $object['draw']);
        $this->assertEquals(1, $object['recordsTotal']);
        $this->assertEquals(1, $object['recordsFiltered']);

        $this->assertTrue(is_array($object['data']));

        $this->assertEquals('Display Name', $object['data'][0][0]);
        $this->assertEquals('user_login', $object['data'][0][1]);
        $this->assertEquals('user_email', $object['data'][0][2]);
        $this->assertEquals('role', $object['data'][0][3]);
        
    }

    public function assertSearchArgsIsPassed($object)
    {
        $this->assertEquals(0, $object['recordsTotal']);
    }
}

class WP_User_Query
{
    public $args;
    public function __construct($args)
    {
        $this->args = $args;
    }

    public function get_results()
    {
        if (isset($this->args['search'])) {
            return [];
        }

        $user = new stdClass();
        $user->ID = 1;
        $user->display_name = 'Display Name';
        $user->user_login = 'user_login';
        $user->user_email = 'user_email';
        
        return [
            $user 
        ];
    }

    public function get_total()
    {
        return (isset($this->args['search'])) ? 0 : 1;
    }
}