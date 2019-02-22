<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 13:56
 */

namespace PCC_EPE\Functions;

use PCC_EPE\Functions\Files;

class ParseConfigFile
{

    public static function parseConfig() {

        $loadFile = new Files();

        $file = $loadFile->loadConfigFile();

        return self::splitConfigFile($file);

    }

    public static function splitConfigFile( $file ) {

        $output = [];
        $config = explode('## ', $file);

        foreach($config as $stanza) {

            $stanza_title = strtok($stanza, "\n");

            $pos = strpos($stanza, $stanza_title);
            if ($pos !== false) {
                $stanza_body = substr_replace($stanza, '', $pos, strlen($stanza_title));
            }

            $output[] = [
                'title' => $stanza_title,
                'body' => $stanza_body
            ];
            
        }
        
        return $output;
        
    }

}