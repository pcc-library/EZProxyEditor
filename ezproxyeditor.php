<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Init\InitializeEditor;
use PCC_EPE\Functions\RSSFeed;
use PCC_EPE\Functions\Files;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Models\Config;
use AltoRouter;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use \Twig\Extension\DebugExtension;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

$baseurl = '/library/ezproxyeditor';

$files = new Files();
$router = new AltoRouter();
$router->setBasePath($baseurl);

// Specify our Twig templates location
$loader = new FilesystemLoader(EZPEPATH .'views');

// Instantiate our Twig
$twig = new Environment($loader, [
    'debug' => true,
]);

$twig->addExtension(new DebugExtension());

Config::$twig=$twig;

Config::$files=$files;

$post_data = $_REQUEST['section'];
$renderUI = new RenderUI();

$data = InitializeEditor::init($post_data);

$data['rss_feed'] = []; //RSSFeed::fetchRSSFeed();
$data['baseurl'] = $baseurl;

$router->map( 'GET', '/', function() use ($renderUI, $data) {
    echo  $renderUI->renderTemplate('editor', $data);
});


$router->map( 'POST', '/', function() use ($renderUI, $data) {
    echo  $renderUI->renderTemplate('editor', $data);
});

$router->map( 'GET', '/preview', function() use ($renderUI, $data) {
    echo $renderUI->renderTemplate('preview', $data);
});

$router->map( 'GET', '/write', function() use ($renderUI, $data, $files) {
    $data['messages'][] = $files->writeTextConfig();
    echo $renderUI->renderTemplate('editor', $data);
});


$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header("HTTP/1.0 404 Not Found");
    echo $renderUI->renderTemplate('404', []);
}


//if($_POST) {
 //echo '<pre>'.print_r($data['messages'],true).'</pre>';
//};
