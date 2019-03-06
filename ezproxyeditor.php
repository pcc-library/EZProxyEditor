<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Functions\LoadConfig;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Functions\RSSFeed;

$data = LoadConfig::init();

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

$preview = $_GET['preview'];

echo RenderUI::renderSections($data,$preview);

//echo "<pre>".print_r($data,true)."</pre>";

//if($_POST) {
//echo '<pre>'.print_r(json_encode($data, JSON_PRETTY_PRINT),true).'</pre>';
//};
