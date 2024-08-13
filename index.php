<?php

use DI\Container;
use PCC_EPE\Controllers\Authentication;
use PCC_EPE\Controllers\RouteController;
use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;

require_once 'vendor/autoload.php';

/**
 * Entry point of the EZProxy Editor application.
 *
 * This script bootstraps the application, initializes dependencies,
 * authenticates the user using CAS, and handles routing.
 */

// Bootstrap the application and retrieve the DI container
$container = require __DIR__ . '/bootstrap.php';

// Debugging output: Log container initialization
error_log("Container initialized successfully.");

if (!$container instanceof Container) {
    error_log("Error: Bootstrap did not return a valid Container instance.");
    die('Container initialization failed.');
}

/**
 * @var Authentication $authentication
 *
 * Initialize CAS Authentication (this automatically authenticates the user).
 */
$authentication = $container->get(Authentication::class);

// Debugging output: Log authenticated user
$authenticatedUser = $authentication->getUser();
error_log("CAS Authenticated User: " . $authenticatedUser);

/**
 * @var AltoRouter $router
 *
 * Get the AltoRouter instance from the container.
 */
$router = $container->get(AltoRouter::class);

// Debugging output: Log router initialization
error_log("Router initialized successfully.");

/**
 * Set the base path for the router using the configuration settings.
 */
$settings = $container->get('config');
Config::$router->setBasePath(parse_url($settings['baseurl'], PHP_URL_PATH));


// Debugging output: Log the base path that was set
error_log("Router base path set to: " . parse_url($settings['baseurl'], PHP_URL_PATH));

/**
 * Map the application routes.
 */
$router->map('GET', '/', 'RouteController#editor', 'editor');
$router->map('GET', '/new', 'RouteController#addnew', 'new');
$router->map('POST', '/', 'RouteController#update', 'update');
$router->map('GET', '/write', 'RouteController#write', 'write');
$router->map('GET', '/preview', 'RouteController#preview', 'preview');
$router->map('GET', '/validate', 'RouteController#validate', 'validate');
$router->map('GET', '/upload', 'RouteController#upload', 'upload');

// Debugging output: Log mapped routes
error_log("Routes have been mapped.");

/**
 * Match the current request URL with the mapped routes.
 */
$match = $router->match();

// Debugging output: Log route matching
error_log("Router match result: " . print_r($match, true));

/**
 * Handle the matched route.
 */
try {
    if ($match) {
        list($controller, $action) = explode('#', $match['target']);
        $controllerClass = "PCC_EPE\\Controllers\\$controller";

        // Debugging output: Log controller retrieval
        error_log("Attempting to retrieve controller: " . $controllerClass);

        // Try to retrieve the controller from the DI container
        $controllerInstance = $container->get($controllerClass);

        // Call the matched controller action
        call_user_func_array([$controllerInstance, $action], $match['params']);

        // Debugging output: Log successful route handling
        error_log("Route matched and handled: " . $controllerClass . " -> " . $action);
    } else {
        // No route matched, handle the 404 error
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo $container->get(RenderView::class)->getTemplate('404', []);

        // Debugging output: Log 404 error
        error_log("404 Not Found: No matching route for the request.");
    }
} catch (\Exception $e) {
    // Debugging output: Log exception details
    error_log("Exception caught: " . $e->getMessage());

    // Handle the exception by rendering the 500 error page
    echo $container->get(RenderView::class)->getTemplate('500', ['error' => $e->getMessage()]);
}
