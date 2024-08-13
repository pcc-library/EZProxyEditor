<?php
// bootstrap.php

use DI\Container;
use DI\ContainerBuilder;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use PCC_EPE\Models\Config;

/**
 * Bootstrap the application.
 *
 * This script initializes the dependency injection container,
 * loads configuration settings, and defines necessary constants.
 *
 * @return Container The dependency injection container.
 * @throws Exception If required configuration values are missing.
 */
function bootstrap(): Container {
    // Load the configuration file
    $settings = require __DIR__ . '/ezpe-config.php';

    // Define essential constants
    define('EZPEPATH', __DIR__ . '/');
    define('EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'] . $settings['write_path']);
    define('BASEURL', $settings['baseurl']);

    // Create a ContainerBuilder instance
    $containerBuilder = new ContainerBuilder();

    // Add definitions for dependencies
    $containerBuilder->addDefinitions([
        'config' => $settings, // Store settings in the container
        AltoRouter::class => DI\create(AltoRouter::class),
        Environment::class => function () {
            $loader = new FilesystemLoader(__DIR__ . '/views');
            return new Environment($loader, [
                'debug' => true,
            ]);
        },
        PCC_EPE\Controllers\Authentication::class => function ($container) use ($settings) {
            // Set necessary constants for CAS authentication
            define('CAS_HOST', $settings['cas_host']);
            define('CAS_CONTEXT', $settings['cas_context']);
            define('CAS_PORT', $settings['cas_port']); // Assuming CAS_PORT is defined in config

            return new PCC_EPE\Controllers\Authentication();
        },
    ]);

    // Build and return the container
    $container = $containerBuilder->build();

    // Initialize and store in Config
    Config::$twig = $container->get(Environment::class);
    Config::$router = $container->get(AltoRouter::class);
    Config::$post_data = $_REQUEST;
    Config::$settings = $settings;

    return $container;
}


try {
    return bootstrap();
} catch (Exception $e) {
    // Debugging output: Log the exception message and trace
    error_log("Bootstrap Error: " . $e->getMessage());
    error_log("Stack Trace: " . $e->getTraceAsString());

    // Optionally, you can display the error message to the user in a simple way
    echo "An error occurred during bootstrapping. Please check the logs for more details.";
    exit(1); // Exit with a status code indicating an error
}
