<?php

add_action( 'plugins_loaded', 'bpcut_init' );

/**
 * init the plugin
 */
function bpcut_init()
{
    new BPCUT\Plugin();
    
}