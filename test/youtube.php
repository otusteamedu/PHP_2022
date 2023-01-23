<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

/**
 * Sample PHP code for youtube.search.list
 * See instructions for running these code samples locally:
 * https://developers.google.com/explorer-help/guides/code_samples#php
 * @source https://www.freakyjolly.com/google-api-php-how-to-use-google-api-like-youtube-data-v3-api-in-php/
 */

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/MyYoutubeApi.class.php';

// clientCode

if (php_sapi_name() == 'cli') {
    $args = $_SERVER['argv'];
    $case = (isset($args[1]) ? $args[1] : '');
    define('BR', "\n");
} else {
    $case = (isset($_GET['case']) ? $_GET['case'] : '');
    define('BR', "<BR />");
}

switch($case) {
    case "1":               // search videos by query, return as response
        $ytApi = new MyYoutubeApi();
        $list = $ytApi->searchVideosList('mishaikon', 5);

        if (php_sapi_name() == 'cli') {
            print_r($list['items']);
        } else {
            print "<pre>";
            print_r($list['items']);
            print "</pre>";
        }
        
        print "Videos found: " . count($list['items']) . BR;
        print "DONE" . BR;
        break;

    case "2":               // search videos by query, return as URLS
        $ytApi = new MyYoutubeApi();
        $list = $ytApi->searchVideosUrlsList('mishaikon', 10);

        if (php_sapi_name() == 'cli') {
            print_r($list);
        } else {
            print "<pre>";
            print_r($list);
            print "</pre>";
        }

        print "Videos found: " . count($list) . BR;
        print "DONE" . BR;
        break;

    case "3":               // get random video by query, return URL
        $ytApi = new MyYoutubeApi();
        $url = $ytApi->searchRandomVideo('mishaikon');

        if (php_sapi_name() == 'cli') {
            print_r($url);
        } else {
            print "<pre>";
            print_r($url);
            print "</pre>";
        }

        print "DONE" . BR;
        break;

    default:
       print "Error: Unknown case" . BR;
       print "Usage samples: " . BR;
       print "- run from console: " . __FILE__ . " <int_case>" . BR;
       print "- run from web: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?case=<int_case>" . BR;
}
