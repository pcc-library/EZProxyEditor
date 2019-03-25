<?php

namespace PCC_EPE;

require( __DIR__ . '/vendor/autoload.php');
require( __DIR__ . '/ezpe-initialize.php');

use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;

/** Instantiate view renderer */
$view = new RenderView();
$router = Config::$router;

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
