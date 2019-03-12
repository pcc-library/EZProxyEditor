<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Functions\RSSFeed;
use PCC_EPE\Frontend\Routes;
use PCC_EPE\Functions\Files;
use PCC_EPE\Frontend\RenderUI;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

$action = $_SERVER['REQUEST_URI'];
$post_data = $_REQUEST['section'];

$routes = new Routes();
$files = new Files();
$renderUI = new RenderUI();


$routes->setRoute('/library/ezproxyeditor/', 'editor');
$routes->setRoute('/library/ezproxyeditor/preview', 'preview');


$data = InitializeEditor::init($post_data);

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

$data['url_base'] = '/library/ezproxyeditor/';

//if($_REQUEST['write']) {

    $data['messages'][] = $files->writeTextConfig();

//}

$callback = $routes->getRoute($action);

echo $renderUI->renderTemplate($callback, $data);

//if($_POST) {
 echo '<pre>'.print_r($data['messages'],true).'</pre>';
//};
