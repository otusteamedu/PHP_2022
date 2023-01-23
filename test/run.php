<?php

/**
 * Class for hand-made testing of functionality
 *
 * Youtube test methods:
 * Sample PHP code for youtube.search.list
 * See instructions for running these code samples locally:
 * https://developers.google.com/explorer-help/guides/code_samples#php
 * @source https://www.freakyjolly.com/google-api-php-how-to-use-google-api-like-youtube-data-v3-api-in-php/
 */

ini_set("display_errors", 1);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/MyYoutubeApi.class.php';

class BotTest
{

    private $case = null;

    /**
     * On start
     */
    public function __construct()
    {
        if (php_sapi_name() == 'cli') {
            $args = $_SERVER['argv'];
            $this->case = (isset($args[1]) ? $args[1] : '');
            define('BR', "\n");
        } else {
            $this->case = (isset($_REQUEST['case']) ? $_REQUEST['case'] : '');
            define('BR', "<BR />");
        }

        print BR . "START TEST" . BR;
    }

    /**
     * On test finish
     * @return void
     */
    private function finish()
    {
        print BR . "DONE" . BR;
    }

    /**
     * @return void
     */
    private function defaultAction()
    {
        print "Error: Unknown case" . BR;
        print "Usage samples: " . BR;
        print "- run from console: " . __FILE__ . " <int_case>" . BR;
        print "- run from web: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?case=<int_case>" . BR;
        print BR . "Available actions (int_case - method name): " . BR;

        $class_methods = get_class_methods(__CLASS__);
        $i = 1;
        foreach ($class_methods as $method_name) {
            if (!in_array($method_name, ['execTest', '__construct', 'finish', 'defaultAction'])) {
                echo "$i - $method_name" . BR;
                $i++;
            }
        }
    }

    /**
     * @return void
     */
    public function execTest()
    {
        switch ($this->case) {
            case "1":               // search videos by query, return as response
                $this->testSearchVideoList();
                break;

            case "2":               // search videos by query, return as URLS
                $this->testSearchVideosUrlsList();
                break;

            case "3":               // get random video by query, return URL
                $this->testSearchRandomVideo();
                break;

            default:
                $this->defaultAction();
        }

        $this->finish();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// Test methods

    /**
     * 1. test fetch youtube search
     * @return void
     */
    public function testSearchVideoList()
    {
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
    }

    /**
     * 2. test fetch youtube search (urls only)
     * @return void
     */
    public function testSearchVideosUrlsList()
    {
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
    }

    /**
     * 3. get random youtube video from search
     * @return void
     */
    public function testSearchRandomVideo()
    {
        $ytApi = new MyYoutubeApi();
        $url = $ytApi->searchRandomVideo('mishaikon');

        if (php_sapi_name() == 'cli') {
            print_r($url);
        } else {
            print "<pre>";
            print_r($url);
            print "</pre>";
        }
    }
}


$test = new BotTest();
$test->execTest();

