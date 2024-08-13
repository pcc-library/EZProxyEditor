<?php
/**
 * ezpe-initialize.php
 *
 * Initialization file for the EZProxy Editor application.
 * Sets up CAS authentication, routing, and Twig templating engine.
 *
 * @package PCC_EPE
 * @version 1.0
 */

namespace PCC_EPE;

use phpCAS;
use PCC_EPE\Controllers\Authentication;
use PCC_EPE\Models\Config;
use AltoRouter;
use phpseclib3\Net\SSH2;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require 'vendor/autoload.php';

$settings = require("ezpe-config.php");

define('EZPEPATH', __DIR__ . '/');
define('EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'] . $settings['write_path']);
define('BASEURL', $settings['baseurl']);

// Ensure the base URL includes the protocol
$baseURL = $settings['baseurl'];
if (!preg_match('/^https?:\/\//', $baseURL)) {
    $baseURL = 'http://' . $_SERVER['HTTP_HOST'] . $baseURL;
}

// CAS configuration
define('CAS_HOST', $settings['cas_host']);
define('CAS_CONTEXT', $settings['cas_context']);
define('CAS_PORT', 443);
define('NET_SSH2_LOGGING', SSH2::LOG_COMPLEX);

/** Initialize CAS authentication */
phpCAS::client(CAS_VERSION_2_0, CAS_HOST, CAS_PORT, CAS_CONTEXT, $baseURL);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();

/** Initialize router */
$router = new AltoRouter();
$router->setBasePath($settings['baseurl']);
$strSubfolderRoute = Config::$strSubfolderRoute;

/** Specify Twig template location */
$loader = new FilesystemLoader(EZPEPATH . 'views');

/** Instantiate Twig */
$twig = new Environment($loader, [
    'debug' => true,
]);

/** Configure Twig */
$twig->addExtension(new DebugExtension());

/** Set state in Models\Config */
Config::$twig = $twig;
Config::$post_data = $_REQUEST;
Config::$router = $router;

/** Define application routes */
$router->map('GET', $strSubfolderRoute . '/', 'PCC_EPE\Controllers\RouteController#editor', 'editor');
$router->map('GET', $strSubfolderRoute . '/new', 'PCC_EPE\Controllers\RouteController#addnew', 'new');
$router->map('POST', $strSubfolderRoute . '/', 'PCC_EPE\Controllers\RouteController#editor', 'update');
$router->map('GET', $strSubfolderRoute . '/write', 'PCC_EPE\Controllers\RouteController#write', 'write');
$router->map('GET', $strSubfolderRoute . '/preview', 'PCC_EPE\Controllers\RouteController#preview', 'preview');
$router->map('GET', $strSubfolderRoute . '/validate', 'PCC_EPE\Controllers\RouteController#validate', 'validate');
$router->map('GET', $strSubfolderRoute . '/upload', 'PCC_EPE\Controllers\RouteController#upload', 'upload');

/** Handle CAS logout */
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}
