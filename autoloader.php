<?php
spl_autoload_register('bpcut_autoloader');

/**
 * Custom autoloader
 * @param $className
 * @throws RuntimeException
 */
function bpcut_autoloader( $className ) {
    if ( substr($className, 0, 5) !== 'BPCUT' ) {
        return;
    }
    
    $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($className,6)) . '.php';
    if ( !include_once( realpath(BPCUT_PLUGIN_DIR_FULL . 'src' . DIRECTORY_SEPARATOR . $classFilePath) ) ){
        throw new \RuntimeException(sprintf("Can't load class '%s'", $className));
    }
    
}
