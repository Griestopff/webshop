<?php
    
    session_start();

    // display PHP Errors on Screen
    error_reporting(-1);
    ini_set('display_errors', 'On');

    // defines the direction to the config file
    define('CONFIG_DIR',__DIR__.'/configs');
    define('STYLE_DIR',__DIR__.'/styles');

    // show cookie consent by first load
    require_once __DIR__.'/templates/cookie_consent.php';

    // get functions and route scripts
    require_once __DIR__.'/includes.php';
    
    // set cookie for 30 days (get $userId from routes.php, included by includes.php)
    setcookie('userId', getCurrentCookieUserId(), strtotime('+30 days'));
    
    include('content.php');
    #session_write_close();

?>
