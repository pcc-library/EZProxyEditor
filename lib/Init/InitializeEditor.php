<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 14:55
 */

namespace PCC_EPE\Init;

use PCC_EPE\Functions\Files;
use PCC_EPE\Functions\LoadConfig;

class InitializeEditor
{

    /**
     * @return array
     */
    public static function init() {

        $files = new Files();

        $config = $files->loadConfigFile();

        return LoadConfig::parseConfig($config);

    }

    public static function loadEditorConfig() {



    }

}