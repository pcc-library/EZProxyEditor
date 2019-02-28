<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 11:57
 */

namespace PCC_EPE\Functions;

class RSSFeed
{

    public static function fetchRSSFeed() {

        $url = "https://www.oclc.org/support/services/ezproxy/database-setup.en.rss";

        $json = json_encode(simplexml_load_file($url), JSON_PRETTY_PRINT);

        return json_decode($json);

    }

}