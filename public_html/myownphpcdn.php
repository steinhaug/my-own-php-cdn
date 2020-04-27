<?php
/* My Own PHP CDN - Optimization and self-assembling web-assets CDN.
 * 
 * Copyright (C) 2019 Kim Stalsberg Steinhaug (https://kim.steinhaug.com)
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *  
 * You should have received a copy of the MIT License with
 * this file. If not, please write to kim@systemweb.no, 
 * or visit https://github.com/steinhaug/my-own-php-cdn/blob/master/LICENSE
 */

define('ASSETS_DOMAIN', 'http://mysite.com');
define('ASSETS_PATH',   '/vedlegg'); // '' or subdir as '/somedir'
define('ASSETS_RETRIEVAL', 'file'); // file, curl
define('ASSETS_REPOSITORY_PATH', '../public_html');
define('FS_CHMOD_DIR', ( 0755 & ~ umask() ));

require __dir__ . '/myownphpcdn.functions.php';

// define asset requested
// locate and retrieve asset
// optimize asset and save it
// deliver asset

$serverpath = dirname(__FILE__);
$asset = pathinfo($_GET['url']);

if( empty($_GET['url']) ){
    http_response_code(404);
    exit;
}

if( empty($asset['dirname']) ){
    logfile($_GET);
    http_response_code(500);
    exit;
}

$remote_url = ASSETS_DOMAIN . ASSETS_PATH . with_ending_seperator($asset['dirname']) . $asset['basename'];
$local_url = dirname(__FILE__) . with_ending_seperator($asset['dirname']) . $asset['basename'];

list($the_asset,$status) = request($remote_url);
if($status['http_code'] == 200){
    if( $asset['dirname'] != '/' ){
        make_folders($asset['dirname']);
    }
    file_put_contents($local_url, $the_asset);
    if( file_exists($local_url) )
        header('Location: ' . without_starting_seperator($asset['dirname']) . $asset['basename']);
        else
        http_response_code(404);
} else if($status['http_code'] == 404){
    http_response_code(404);
    exit;
} else {
    logfile($status);
}

http_response_code(404);