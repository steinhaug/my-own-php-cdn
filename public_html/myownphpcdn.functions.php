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

define('mopcdn_debug_level', 0);

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
        $root = __DIR__;

    $paths_string = untrailingslashit($paths_string);
    $paths = explode('/', $paths_string);
    $dirpath = $root . '';

    foreach($paths AS $dir){

        if( empty($dir) )
            continue;

        if( $dir == '/' )
            continue;

        $dirpath = $dirpath . '/' . $dir;
        if( mopcdn_debug_level ) echo 'mkdir ' . $dirpath . '<br>';

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

function request($url,$headers=array(),$params=array(),$referrer="",$http_code=false){
    //global $cachemode;

        static $cookiefile = "cpanel_cookie.txt";
        static $curlfile = "cpanel_curl.txt";

        if(!empty($headers)){
            $headers = [
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3",
                "accept-encoding: deflate, br",
                "Accept-Language: nb-NO,nb;q=0.9,en;q=0.8,no;q=0.7,en-US;q=0.6,sv;q=0.5,da;q=0.4",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safar"
            ];
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0');
        if(!empty($headers)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if(!empty($params)){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookiefile));
        curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookiefile));
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        if(!empty($referrer)){
           curl_setopt($ch, CURLOPT_REFERER, $referrer);  
        }
        $answer = curl_exec($ch);

        //if($http_code){
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            $status = curl_getinfo($ch);
        //}
        curl_close($ch);

        if($http_code){
            if($status['http_code'] == 302){
              $answer = $status['redirect_url'];
            }
        }

        //echo '<pre>';
        //var_dump($status);
        return [$answer, $status];
    }

function logfile($the_string, $logfile='errors', $lf="\n" ){
    if( !is_string($the_string) ){
        $the_string = json_encode($the_string, true);
        $the_string = str_replace(',"',',' . "\n" . ' "', $the_string);
    }

    if( $fh = @fopen( dirname(__FILE__) . '/.' . $logfile . ".log", "a+" ) ){
        fputs( $fh, $the_string . $lf, strlen($the_string . $lf) );
        fclose( $fh );
        return( true );
    } else {
        return( false );
    }
}

/**
 * Make sure string ends with a /
 */
function with_ending_seperator($path){
    if(empty($path))
        return '/';
    if( preg_match("/\/$/", $path) )
        return $path;
        else
        return $path . '/';
}

/**
 * Make sure string starts without / but ends with /
 */
function without_starting_seperator($path){
    $path = with_ending_seperator($path);
    if($path == '/') return '';
    if( preg_match("/^\//", $path) )
        return substr($path,1);
        else
        return $path;
}