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

    public function renderSections($callback,$data) {

    // Specify our Twig templates location
        $loader = new Twig_Loader_Filesystem(EZPEPATH .'views');

    // Instantiate our Twig
        $twig = new Twig_Environment($loader, array(
            'debug' => true,

        ));
        $twig->addExtension(new Twig_Extension_Debug());

        return $twig->render($callback.".twig", $data);

    }

//    public function findViewFile($pattern) {
//
//        $files = glob(EZPEPATH.'views/'.$pattern.'.twig');
//        $files = array_combine($files, array_map('filectime', $files));
//        arsort($files);
//
//        return key($files); // the filename
//
//    }


}