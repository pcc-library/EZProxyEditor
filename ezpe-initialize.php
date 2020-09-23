<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-17
 * Time: 21:45
 */

namespace PCC_EPE;

$settings = require("ezpe-config.php");

use PCC_EPE\Controllers\Authentication;
use PCC_EPE\Models\Config;

use AltoRouter;
use phpCAS;
use phpseclib\Net\SSH2;

use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].$settings['write_path']);

define( 'BASEURL',$settings['baseurl']);

// Full Hostname of your CAS Server
define('CAS_HOST',$settings['cas_host']);

// Context of the CAS Server
define('CAS_CONTEXT',$settings['cas_context']);

// Port of your CAS server. Normally for a https server it's 443
define('CAS_PORT', 443);

define('NET_SSH2_LOGGING', SSH2::LOG_COMPLEX);

/** Initialize CAS auth */
new Authentication();

/** initialize router */
$router = new AltoRouter();
$router->setBasePath(BASEURL);
$strSubfolderRoute = Config::$strSubfolderRoute;

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
Config::$router = $router;

$router->map('GET',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'editor');

$router->map('GET',$strSubfolderRoute.'/new','PCC_EPE\Controllers\RouteController#addnew', 'new');

$router->map('POST',$strSubfolderRoute.'/','PCC_EPE\Controllers\RouteController#editor', 'update');

$router->map('GET',$strSubfolderRoute.'/write','PCC_EPE\Controllers\RouteController#write', 'write');

$router->map('GET',$strSubfolderRoute.'/preview','PCC_EPE\Controllers\RouteController#preview', 'preview');

$router->map('GET',$strSubfolderRoute.'/validate','PCC_EPE\Controllers\RouteController#validate', 'validate');

$router->map('GET',$strSubfolderRoute.'/upload','PCC_EPE\Controllers\RouteController#upload', 'upload');

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}
