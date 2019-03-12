<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:50
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Config;

/**
 * Class RouteController
 * @package PCC_EPE\Controllers
 */
class RouteController
{


    public function getTwigInstance()
    {
        return Config::$twig;
    }
    public function getProjectSubFolderPath()
    {
        return Config::$strSubfolderRoute;
    }

    public function getRouterInstance()
    {
        return Config::$router;
    }


}