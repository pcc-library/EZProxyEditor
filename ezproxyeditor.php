<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Functions\RSSFeed;
//use PCC_EPE\Frontend\Routes;
use PCC_EPE\Functions\Files;
use PCC_EPE\Frontend\RenderUI;
use AltoRouter;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

$baseurl = '/library/ezproxyeditor';

$router = new AltoRouter();
$router->setBasePath($baseurl);

$post_data = $_REQUEST['section'];
$renderUI = new RenderUI();

$data = InitializeEditor::init($post_data);

$data['rss_feed'] = RSSFeed::fetchRSSFeed();
$data['baseurl'] = $baseurl;

$router->map( 'GET', '/', function() use ($renderUI, $data) {
    echo  $renderUI->renderTemplate('editor', $data);
});

$router->map( 'GET', '/preview', function() use ($renderUI, $data) {
    echo $renderUI->renderTemplate('preview', $data);
});

$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    echo $renderUI->renderTemplate('404', []);
}


//if($_POST) {
 //echo '<pre>'.print_r($data['messages'],true).'</pre>';
//};
