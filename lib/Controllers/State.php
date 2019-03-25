<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-18
 * Time: 11:25
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Config;

class State
{

    /**
     * @return mixed
     */
    public function getTwigInstance()
    {
        return Config::$twig;
    }


    /**
     * @return string
     */
    public function getProjectSubFolderPath()
    {
        return Config::$strSubfolderRoute;
    }

    /**
     * @return mixed
     */
    public function getRouterInstance()
    {
        return Config::$router;
    }

    /**
     * @return mixed
     */
    public function getPostDataInstance()
    {
        return Config::$post_data;
    }

    public function getSettingsInstance() {
        return Config::$settings;
    }

}