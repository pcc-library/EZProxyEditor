<?php

namespace PCC_EPE;

require __DIR__ . '/editor-config/ezpe-config.php';

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Functions\RSSFeed;

$post_data = $_REQUEST['section'];

$data = InitializeEditor::init($post_data);

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

echo RenderUI::renderSections($data,$_REQUEST['preview']);

//if($_POST) {
//echo '<pre>'.print_r($_SERVER,true).'</pre>';
//};
