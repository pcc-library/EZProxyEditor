<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-25
 * Time: 21:36
 */

namespace PCC_EPE\Frontend;

use PCC_EPE\Models\Config;

class RenderUI
{

    public function renderTemplate($template,$data) {

        $twig = Config::$twig;

        return $twig->render($template.".twig", $data);

    }

}