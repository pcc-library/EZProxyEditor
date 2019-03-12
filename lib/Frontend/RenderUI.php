<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-25
 * Time: 21:36
 */

namespace PCC_EPE\Frontend;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use \Twig\Extension\DebugExtension;

class RenderUI
{

    public function renderTemplate($template,$data) {

    // Specify our Twig templates location
        $loader = new FilesystemLoader(EZPEPATH .'views');

    // Instantiate our Twig
        $twig = new Environment($loader, [
            'debug' => true,
        ]);

        $twig->addExtension(new DebugExtension());

        return $twig->render($template.".twig", $data);

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