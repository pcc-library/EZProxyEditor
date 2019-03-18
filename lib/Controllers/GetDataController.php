<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 14:55
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Functions\Files;

class GetDataController
{

    /**
     * @return array
     */
    public static function init() {

       $post_data = new RouteController();

       return self::getDataOnLoad($post_data->getPostDataInstance());

    }

    public static function getDataOnLoad($post_data) {

        $files = new Files();

        if($post_data['section']) {

            $config = Parsers::parsePostData($post_data['section']);

        } else {

            $config = $files->loadConfigFile();

        }

        return Parsers::parseConfig($config);

    }

}