<?php
/**
 * ezproxyeditor.php
 *
 * Main entry point for the EZProxy Editor application.
 * Handles routing and rendering of views.
 *
 * @package PCC_EPE
 * @version 1.0
 */

use PCC_EPE\Models\Config;

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Include the initialization file
require_once 'ezpe-initialize.php';

// Authenticate the user
$auth = new PCC_EPE\Controllers\Authentication();
$casUser = phpCAS::getUser();
$authenticatedUser = $auth->checkUser($casUser);

var_dump($authenticatedUser);

// Debug output for CAS user
error_log("CAS Authenticated User: " . var_export($authenticatedUser, true), 3, '/var/log/cas_debug.log');

if (!$authenticatedUser) {
    // Redirect to a "Not Authorized" page or show an error
    header('Location: ' . BASEURL . '/unauthorized');
    exit();
}

// Debug output for router base path
error_log("Router Base Path: " . var_export(Config::$router->getBasePath(), true), 3, '/var/log/cas_debug.log');

// Match the current request
$match = Config::$router->match();

// Debug output for router match
error_log("Router Match: " . var_export($match, true), 3, '/var/log/cas_debug.log');

if ($match) {
    list($controller, $method) = explode('#', $match['target']);
    if (is_callable(array($controller, $method))) {
        call_user_func_array(array(new $controller, $method), array($match['params']));
    } else {
        // Handle the error
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo "404 Not Found";
        error_log("Error: 404 Not Found - Controller method not callable", 3, '/var/log/cas_debug.log');
    }
} else {
    // No route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "404 Not Found";
    error_log("Error: 404 Not Found - No route matched", 3, '/var/log/cas_debug.log');
}

// Output headers after routing logic
header("Content-Type: text/html; charset=utf-8");

