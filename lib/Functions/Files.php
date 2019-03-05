<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 14:41
 */

namespace PCC_EPE\Functions;

use Exception;

/**
 * Class Files
 * Read & write config.txt files
 * @package PCC_EPE\Functions
 */
class Files
{


    /**
     * Find the file matching the pattern, return the filename
     * @param string $pattern
     * @return int|string|null
     */
    public function findConfigFile($pattern = 'config_*') {

        $files = glob(PCCEPEPATH.$pattern);
        $files = array_combine($files, array_map('filectime', $files));
        arsort($files);

        return key($files); // the filename

    }

    /**
     * Find the latest config file, and if not found, load config.master.txt
     * @return array
     */
    public function loadConfigFile() {

        $filename = $this->findConfigFile();

        if(!$filename) {

            $messages['status'] = false;
            $messages['text'] = "Custom config.txt file not found. Creating new one from master.";
            $filename = PCCEPEPATH."/src/data/config.master.txt";
            $JSON = false;

        } else {
            $messages['status'] = true;
            $messages['text'] = "Found ".$filename;
            $JSON = true;

        }

        $file = file_get_contents($filename);

        return ['file' => $file, 'messages' => [$messages], 'json' => $JSON];

    }

    public function writeConfigFile($filename, $data) {

        try {
            file_put_contents($filename, json_encode($data['sections'], JSON_PRETTY_PRINT));

           $data['messages'][] = ['status'=>true, 'text'=>'Wrote file '.$filename.' succenssfully'];

        }  catch(Exception $e) {

           $data['messages'][] = ['status'=>false, 'text'=>'Couldn\'t write file '.$filename];

        }

        return $data;
    }

    public function generateFilename() {

        return 'config_'.date('mdY').'.json';

    }

    /**
     * Delete local file
     * @param $file
     * @return bool
     */
    public function RemoveLocalFile($file) {

        if(file_exists($file)) {

            unlink($file);

            return true;

        } else {

            return false;

        }

    }


}
