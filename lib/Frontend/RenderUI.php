<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-25
 * Time: 21:36
 */

namespace PCC_EPE\Frontend;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_Extension_Debug;

class RenderUI
{

    public static function renderSections($data,$preview) {

    // Specify our Twig templates location
        $loader = new Twig_Loader_Filesystem(EZPEPATH .'../views');

    // Instantiate our Twig
        $twig = new Twig_Environment($loader, array(
            'debug' => true,

        ));
        $twig->addExtension(new Twig_Extension_Debug());

        return $preview ? $twig->render('preview_config.twig', $data) : $twig->render('editor.twig', $data);

    }


}