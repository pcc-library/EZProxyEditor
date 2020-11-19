<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 14:41
 */

namespace PCC_EPE\Controllers;

use Exception;
use PCC_EPE\View\RenderView;

/**
 * Class Files
 * Read & write config.txt files
 * @package PCC_EPE\Controllers
 */
class Files
{


    /**
     * Find the file matching the pattern, return the filename
     * @param string $pattern
     * @param string $suffix
     * @return int|string|null
     */
    public function findConfigFile($pattern = 'config_*', $suffix = 'json') {

        $filename = $pattern.'.{'.$suffix.'}';

        $files = glob(EZPEWRITEABLE.$filename, GLOB_BRACE);
        $files = array_combine($files, array_map('filectime', $files));
        arsort($files);

        return key($files); // the filename

    }


    /**
     * Find the latest config file, and if not found, load config.master.txt
     * @param bool $case
     * @return array
     */
    public function loadConfigFile() {

        $filename = $this->findConfigFile();

        $messages = new MessageController();

        if(!$filename) {

          $data = $this->generateNewConfig();

        } else {

            $messages->addMessage(true, "Found ".basename($filename));
            $source = 'json';

            $file = file_get_contents($filename);

            $data = [
                'file' => $file,
                'config' => [ 'source' => $source ]
            ];


        }

        return $data;

    }

    public function generateNewConfig() {

        $messages = new MessageController();

        $messages->addMessage( false, "Custom config file not found. Creating new one from master.");

        $data = $this->getMasterConfigFile();

        $config = Parsers::parseTextConfigFile($data);

        $output = $this->writeEditorConfigFile($this->generateFilename(), $config);

        return $output;

    }

    public function getMasterConfigFile() {

        $filename = EZPEPATH."/config.master.txt";
        $source = 'text';

        $file = file_get_contents($filename);

        $data = [
            'file' => $file,
            'config' => [ 'source' => $source ]
        ];

        return $data;

    }

    public function writeEditorConfigFile($filename, $data) {

        $messages = new MessageController();

        try {

            $sections = Formatters::updateDate($data['sections']);

            $filecontent = Formatters::formatSections($sections); // testing to fix array after reorder

            file_put_contents(EZPEWRITEABLE.$filename, json_encode($filecontent, JSON_PRETTY_PRINT));

            $messages->addMessage(true,"Wrote file ".basename($filename)." successfully");


        }  catch(Exception $e) {

           $messages->addMessage(false, "Couldn\'t write file ".basename($filename));

        }

        $data['sections'] = $filecontent;

        return $data;
    }

    public function writeTextConfig() {

        $messages = new MessageController();

        $messages->clearMessages();

        $files = new Files();
        $render = new RenderView();

        $file = $files->loadConfigFile();

        $data = Parsers::parseJsonConfigFile($file);

        $filename = self::generateFilename('config_','.txt');

        $output = $render->getTemplate("config/sections_config", $data);

        try {

            file_put_contents(EZPEWRITEABLE.$filename, $output);

            $messages->addMessage(true,"Wrote file ".basename($filename)." successfully");

            return $filename;


        }  catch(Exception $e) {

            $messages->addMessage(false, "Couldn\'t write file ".basename($filename));

            return false;

        }

    }

    public function generateFilename($filename = 'config_',$suffix = '.json') {

        return $filename.date('mdYhis').$suffix;

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
