<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 11:57
 */

namespace PCC_EPE\Controllers;

/**
 * Class RSSFeed
 * @package PCC_EPE\Functions
 */
class RSSFeed
{


    /**
     * @return false|mixed|string
     */
    public static function rssFeed() {

        return self::rssCache();
    }


    /**
     * @return mixed
     */
    public static function fetchRSSFeed() {

            $url = "https://www.oclc.org/support/services/ezproxy/database-setup.en.rss";

            $xml = simplexml_load_file($url);

            $output = json_decode(json_encode($xml),true);

            return $output;

    }


    /**
     * @return false|mixed|string
     */
    public static function rssCache() {

        $cache_time = 3600*4; // 4 hours

        $filename = EZPEWRITEABLE.'cache_oclc.rss';

        $timedif = @(time() - filemtime($filename));

        if (file_exists($filename) && $timedif < $cache_time) {

            return json_decode(file_get_contents($filename));

        } else {

            $rss = self::fetchRSSFeed();

            file_put_contents($filename, json_encode($rss) );

            return json_decode($rss);
        }

    }

}