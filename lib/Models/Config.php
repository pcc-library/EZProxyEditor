<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:47
 */

namespace PCC_EPE\Models;


/**
 * Class Config
 * @package PCC_EPE\Models
 */
class Config
{

    /**
     *  Twig template engine instance
     */
    public static $twig;

    /**
     * @var
     */
    public static $renderUI;

    /**
     *  Default application folder (in case placing project in subfolder on the shared remote hosting)
     */
    public static $strSubfolderRoute = "";

    public static $files;

    public static $router;

    public static $post_data;

    public static $master;

    public static $user = false;

    public static $users = ['dmeeds','gustavo.lanzas', 'lisa.morrow' ,'maria.wagner','amanda.perez1'];

    public static $settings;

    public static $container;

    /**
     * Get the server's base URL.
     *
     * This method dynamically generates the base URL of the server
     * using the current request's protocol (HTTP/HTTPS) and host.
     *
     * @return string The base URL of the server, e.g., 'http://localhost:8888'
     */
    public static function getServerBaseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];

        return $protocol . $host;
    }


}