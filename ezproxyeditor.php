<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Functions\RSSFeed;
use PCC_EPE\Frontend\Routes;
use PCC_EPE\Frontend\Router;
use PCC_EPE\Frontend\RenderUI;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

$action = $_SERVER['REQUEST_URI'];
$post_data = $_REQUEST['section'];

$routes = new Routes();
$router = new Router();
//$renderUI = new RenderUI();


$routes->setRoute('/library/ezproxyeditor/', 'editor');
$routes->setRoute('/library/ezproxyeditor/preview', 'preview');


$data = InitializeEditor::init($post_data);

$data['rss_feed'] = RSSFeed::fetchRSSFeed();

$data['url_base'] = '/library/ezproxyeditor/';

echo $router->dispatch($action,$data);

//if($_POST) {
// echo '<pre>'.print_r($action,true).'</pre>';
//};
