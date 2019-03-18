<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-25
 * Time: 21:36
 */

namespace PCC_EPE\View;

use PCC_EPE\Controllers\MessageController;
use PCC_EPE\Models\Config;

/**
 * Class RenderView
 * @package PCC_EPE\View
 */
class RenderView
{

    /**
     * @param $template
     * @param $data
     * @return mixed
     */
    public function getTemplate($template, $data) {

        $twig = Config::$twig;

        $messages = new MessageController();

        $data['messages'] = $messages->getMessages();

        return $twig->render($template.".twig", $data);

    }

}