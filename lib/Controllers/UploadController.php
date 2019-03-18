<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-18
 * Time: 10:47
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Upload;

class UploadController
{


    public function  UploadConfig() {

        $files = new Files();

        $messages = new MessageController();

        // find the most recent local file
        $filename = $files->findConfigFile('config_*','txt');

        if(!$filename) {

             $messages->addMessage(true, 'Config Not Found');


        } else {

             $messages->addMessage(true, 'Found ' . basename($filename));

             $upload = Upload::uploadFile($filename);

             if($upload) {

                 $messages->addMessage(true, 'Uploading ' . basename($filename));

                 $source = 'text';

                 $file = file_get_contents($filename);

                 $data = [
                     'file' => $file,
                     'config' => [ 'source' => $source ]
                 ];


                 return Parsers::parseTextConfigFile($data);


             }

        }

    }
}


