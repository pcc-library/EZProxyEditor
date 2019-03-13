<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:47
 */

namespace PCC_EPE\Models;


class Config
{

    /**
     *  Twig template engine instance
     */
    public static $twig;

    /**
     *  Default application folder (in case placing project in subfolder on the shared remote hosting)
     */
    public static $strSubfolderRoute = "";

    public static $files;

    public static $router;


}