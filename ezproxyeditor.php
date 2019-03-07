<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Functions\RSSFeed;

$post_data = $_REQUEST['section'];

$data = InitializeEditor::init($post_data);

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

echo RenderUI::renderSections($data,$post_data['preview']);

//if($_POST) {
echo '<pre>'.print_r(json_encode($data, JSON_PRETTY_PRINT),true).'</pre>';
//};
