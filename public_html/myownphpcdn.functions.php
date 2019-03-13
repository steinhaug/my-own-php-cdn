<?php
/* My Own PHP CDN - Optimization and self-assembling web-assets CDN.
 * 
 * Copyright (C) 2019 Kim Stalsberg Steinhaug (https://kim.steinhaug.com)
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 
 
 * You should have received a copy of the MIT License with
 * this file. If not, please write to kim@systemweb.no, 
 * or visit https://github.com/steinhaug/my-own-php-cdn/blob/master/LICENSE
 *
 * @package myownphpcdn
 */

define('mopcdn_debug_level', 1);

/**
 * Removes trailing slash if it exists.
 */
function untrailingslashit( $string ) {
	return rtrim( $string, '/\\' );
}

/**
 * Make sure the given folder structure already exists or create it
 * 
 * @param string $paths_string A directory path of n directories, eg. "/asset/images/2019/"
 * @return bool False if any errors or directory structure does not exist or can be made
 */
function make_folders($paths_string, $root = null){

    // String must start with a / to be valid
    if( strpos($paths_string, '/') === false )
        return false;

    // We require atleast a directory structure of 1 level deep
    if( !strlen(str_replace('/','',$paths_string)) )
        return false;

    // If root is not given default setup is defined
    if( is_null($root) OR empty($root) )
        $root = __dir__;

    $paths_string = untrailingslashit($paths_string);
    $paths = explode('/', $paths_string);
    $dirpath = $root . '';

    foreach($paths AS $dir){

        if( empty($dir) )
            continue;

        if( $dir == '/' )
            continue;

        $dirpath = $dirpath . '/' . $dir;
        if( mopcdn_debug_level ) echo $dirpath . '<br>';

        if(!file_exists($dirpath)){
            if ( ! @mkdir($dirpath) ){
                trigger_webmaster_alert(debug_backtrace());
                return false;
            }
            @chmod($dirpath, FS_CHMOD_DIR);
        }
    }

}

/**
 * Alert and notify webmaster that there are problems with the CDN and filecreation
 * 
 * @param array $debug_backtrace Array from debug_backtrace()
 */
function trigger_webmaster_alert($debug_backtrace){

    // Function does not do anything at the moment

    return null;
}
