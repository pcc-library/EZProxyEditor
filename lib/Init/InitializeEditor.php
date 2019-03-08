<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 14:55
 */

namespace PCC_EPE\Init;

use PCC_EPE\Functions\Files;
use PCC_EPE\Functions\Parsers;

class InitializeEditor
{

    /**
     * @return array
     */
    public static function init($post_data) {

       return self::getDataOnLoad($post_data);

    }

    public static function initializeEditor() {


    }

    public static function getDataOnLoad($post_data) {

        $files = new Files();

        if($post_data) {

            $config = Parsers::parsePostData($post_data);

        } else {

            $config = $files->loadConfigFile();

        }

        return Parsers::parseConfig($config);

    }

}