<?php

namespace PCC_EPE\Controllers;

use phpCAS;
use PCC_EPE\Models\Config;

/**
 * Class Authentication
 * Handles user authentication using CAS.
 */
class Authentication
{
    /**
     * Authentication constructor.
     */
    public function __construct()
    {
        // Enable debugging
        phpCAS::setDebug('/var/log/cas_debug.log');

        // Enable verbose error messages (useful for development)
        phpCAS::setVerbose(true);

        // Use only the base URL (without path) for CAS client
        $baseUrl = 'http://localhost:8888';

//        // Debug: Log the base URL before passing to phpCAS::client
//        error_log("Base URL before phpCAS::client: " . $baseUrl, 3, "/var/log/cas_debug.log");

        // Initialize phpCAS with the CAS server details
        phpCAS::client(CAS_VERSION_2_0, CAS_HOST, CAS_PORT, CAS_CONTEXT, $baseUrl);

        // Disable SSL validation (not recommended for production)
        phpCAS::setNoCasServerValidation();

        // Force CAS authentication
        phpCAS::forceAuthentication();

        // Retrieve authenticated user
        $user = phpCAS::getUser();

        // Debug output to log or display the user information
//        error_log('CAS Authenticated User: ' . print_r($user, true), 3, "/var/log/cas_debug.log");
//        echo '<pre>';
//        var_dump($user);
//        echo '</pre>';

        // Store the authenticated user in the configuration
        Config::$user = $this->checkUser($user);
    }

    /**
     * Check if the authenticated user is in the allowed users list.
     *
     * @param string $user The CAS authenticated user
     * @return bool|string The user if allowed, false otherwise
     */
    public function checkUser($user)
    {
        $allowedUsers = Config::$users;

        // Debug logging
//        error_log("Authenticated User: " . $user, 3, "/var/log/cas_debug.log");
//        error_log("Allowed Users: " . print_r($allowedUsers, true), 3, "/var/log/cas_debug.log");

        $isAllowed = in_array($user, $allowedUsers);
        error_log("Check Result: " . ($isAllowed ? 'Allowed' : 'Denied'), 3, "/var/log/cas_debug.log");

        return $isAllowed ? $user : false;
    }

    /**
     * Get the authenticated user.
     *
     * @return bool|string
     */
    public function getUser()
    {
        return Config::$user;
    }
}
