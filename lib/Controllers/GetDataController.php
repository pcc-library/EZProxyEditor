<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-28
 * Time: 14:55
 */

namespace PCC_EPE\Controllers;

/**
 * Class GetDataController
 * @package PCC_EPE\Controllers
 */
class GetDataController
{

    /**
     * @return array
     */
    public static function init() {

       $state = new State();

        $messages = new MessageController();

        //$messages->clearMessages();

       return self::getDataOnLoad($state->getPostDataInstance());

    }

    /**
     * @param $post_data
     * @return array
     */
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