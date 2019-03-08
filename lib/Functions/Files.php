<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 14:41
 */

namespace PCC_EPE\Functions;

use Exception;
use PCC_EPE\Functions\Formatters;

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

        $files = glob(EZPEPATH.'../'.$pattern);
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
            $messages['text'] = "Custom config file not found. Creating new one from master.";
            $filename = EZPEPATH."/config.master.txt";
            $source = 'text';

        } else {

            $messages['status'] = true;
            $messages['text'] = "Found ".basename($filename);
            $source = 'json';

        }

        $file = file_get_contents($filename);

        $data = [
            'file' => $file,
            'config' => [ 'source' => $source ]
            ];

        $data['messages'][] = Formatters::formatMessage($messages['status'], $messages['text']);

        return $data;

    }

    public function writeConfigFile($filename, $data) {

        try {

            $filecontent = Formatters::updateDate($data['sections']);

            file_put_contents($filename, json_encode($filecontent, JSON_PRETTY_PRINT));

           $data['messages'][] = Formatters::formatMessage(true,"Wrote file ".basename($filename)." successfully");


        }  catch(Exception $e) {

           $data['messages'][] = Formatters::formatMessage(false, "Couldn\'t write file ".basename($filename));

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
