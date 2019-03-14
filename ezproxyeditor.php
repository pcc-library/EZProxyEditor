<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Functions\Files;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Models\Config;
use AltoRouter;

use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

define( 'BASEURL','/library/ezproxyeditor');

$files = new Files();
$router = new AltoRouter();
$router->setBasePath(BASEURL);
$strSubfolderRoute = Config::$strSubfolderRoute;

$renderUI = new RenderUI();

// Specify our Twig templates location
$loader = new FilesystemLoader(EZPEPATH .'views');

// Instantiate our Twig
$twig = new Environment($loader, [
    'debug' => true,
]);

$twig->addExtension(new DebugExtension());

$post_data = $_REQUEST['section'];

Config::$twig = $twig;
Config::$files = $files;
Config::$post_data = $post_data;
Config::$renderUI = $renderUI;

$router->map('GET',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'editor');

$router->map('POST',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'update');

$router->map('GET',$strSubfolderRoute.'/write','PCC_EPE\Controllers\RouteController#write', 'write');

$router->map('GET',$strSubfolderRoute.'/preview','PCC_EPE\Controllers\RouteController#preview', 'preview');

$match = $router->match();

if ($match === false) {

    header("HTTP/1.0 404 Not Found");
    echo $renderUI->renderTemplate('404', []);

} else {
    list($controller, $action) = explode('#', $match['target']);
    $controller = new $controller;
    if (is_callable(array($controller, $action))) {
        call_user_func_array(array($controller, $action), array($match['params']));
    } else {
        echo 'Error: can not call ' . get_class($controller) . '#' . $action;
        // here your routes are wrong.
        // Throw an exception in debug, send a 500 error in production
    }
}

