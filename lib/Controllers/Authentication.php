<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-17
 * Time: 21:40
 */

namespace PCC_EPE\Controllers;

use phpCAS;
use PCC_EPE\Models\Config;

/**
 * Class Authentication
 * @package PCC_EPE\Controllers
 */
class Authentication
{

    /**
     * Authentication constructor.
     */
    public function __construct() {

        $messages = new State();

        $post_data = Config::$post_data;

        // Enable debugging
        phpCAS::setDebug();

        // Enable verbose error messages. Disable in production!
        phpCAS::setVerbose(true);

        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0, CAS_HOST, CAS_PORT, CAS_CONTEXT);

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);
        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!

        phpCAS::setNoCasServerValidation();

        // force CAS authentication
        phpCAS::forceAuthentication();

        Config::$user = phpCAS::getUser();



    }

    /**
     * @return bool
     */
    public function getUser() {

        return Config::$user;

    }

}