<?php

class ViewsTest  extends \WP_Mock\Tools\TestCase
{
    public function setUp() 
    {
        \WP_Mock::setUp();
        
        define('BPCUT_PLUGIN_VIEWS_DIR', realpath(dirname(__FILE__).'/../../_data') . DIRECTORY_SEPARATOR);
        
        $this->stub = $this->getMockBuilder(\BPCUT\Library\Views::class)
         ->getMock();
    }

    public function tearDown() 
    {
        \WP_Mock::tearDown();
    }

    public function testRender()
    {
        \BPCUT\Library\Views::render('includedFile');
        
        $this->assertTrue(defined('TEST_FILE_INCLUDED'));
        $this->assertEquals(1, TEST_FILE_INCLUDED);
    }
}