<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Functions\RSSFeed;

$data = InitializeEditor::init();

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

$preview = $_REQUEST['preview'];

echo RenderUI::renderSections($data,$preview);

//echo "<pre>".print_r($data,true)."</pre>";

//if($_POST) {
//echo '<pre>'.print_r(json_encode($data, JSON_PRETTY_PRINT),true).'</pre>';
//};
