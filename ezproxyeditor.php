<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/settings.php';

use PCC_EPE\Functions\Files;
use PCC_EPE\Frontend\RenderUI;
use PCC_EPE\Models\Config;
use PCC_EPE\Controllers\Authentication;

use AltoRouter;

use phpCAS;

use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;



$files = new Files();
$router = new AltoRouter();
$router->setBasePath(BASEURL);
$strSubfolderRoute = Config::$strSubfolderRoute;

$user = new Authentication();

$renderUI = new RenderUI();

// Specify our Twig templates location
$loader = new FilesystemLoader(EZPEPATH .'views');

// Instantiate our Twig
$twig = new Environment($loader, [
    'debug' => true,
]);

$twig->addExtension(new DebugExtension());

//$post_data = $_REQUEST['section'];

Config::$twig = $twig;
Config::$files = $files;
Config::$post_data = $_REQUEST;
Config::$renderUI = $renderUI;

$router->map('GET',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'editor');

$router->map('POST',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'update');

$router->map('GET',$strSubfolderRoute.'/write','PCC_EPE\Controllers\RouteController#write', 'write');

$router->map('GET',$strSubfolderRoute.'/preview','PCC_EPE\Controllers\RouteController#preview', 'preview');


//// Enable debugging
//phpCAS::setDebug();
//// Enable verbose error messages. Disable in production!
//phpCAS::setVerbose(true);
//// Initialize phpCAS
//phpCAS::client(CAS_VERSION_2_0, CAS_HOST, CAS_PORT, CAS_CONTEXT);
//// For production use set the CA certificate that is the issuer of the cert
//// on the CAS server and uncomment the line below
//// phpCAS::setCasServerCACert($cas_server_ca_cert_path);
//// For quick testing you can disable SSL validation of the CAS server.
//// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
//// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
//phpCAS::setNoCasServerValidation();
//// force CAS authentication
//phpCAS::forceAuthentication();
//// at this step, the user has been authenticated by the CAS server
//// and the user's login name can be read with phpCAS::getUser().
//// logout if desired
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}



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

?>
