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
define('ASSETS_RETRIEVAL', 'file'); // file, curl
define('ASSETS_REPOSITORY_PATH', '../public_html');
define('FS_CHMOD_DIR', ( 0755 & ~ umask() ));

require __dir__ . '/myownphpcdn.functions.php';

// define asset requested
// locate and retrieve asset
// optimize asset and save it
// deliver asset
