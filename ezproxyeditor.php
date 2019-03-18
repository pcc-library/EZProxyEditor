<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/settings.php';

use PCC_EPE\Controllers\Authentication;
use PCC_EPE\Controllers\Files;
use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;

use AltoRouter;
use phpCAS;

use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

/** Initialize CAS auth */
new Authentication();

/** initialize router */
$router = new AltoRouter();
$router->setBasePath(BASEURL);
$strSubfolderRoute = Config::$strSubfolderRoute;

/** Instantiate view renderer */
$view = new RenderView();

/** Specify Twig template location */
$loader = new FilesystemLoader(EZPEPATH .'views');

/** Instantiate Twig */
$twig = new Environment($loader, [
    'debug' => true,
]);

/** config Twig */
$twig->addExtension(new DebugExtension());

/** set state in Models\Config **/
Config::$twig = $twig;
Config::$post_data = $_REQUEST;

$router->map('GET',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'editor');

$router->map('POST',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'update');

$router->map('GET',$strSubfolderRoute.'/write','PCC_EPE\Controllers\RouteController#write', 'write');

$router->map('GET',$strSubfolderRoute.'/preview','PCC_EPE\Controllers\RouteController#preview', 'preview');

$router->map('GET',$strSubfolderRoute.'/upload','PCC_EPE\Controllers\RouteController#upload', 'upload');

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}

$match = $router->match();

if ($match === false) {

    header("HTTP/1.0 404 Not Found");
    echo $view->getTemplate('404', []);

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
