<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 14:41
 */

namespace PCC_EPE\Controllers;

use Exception;
use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
    public function findConfigFile($pattern = 'config_*', $suffix = 'json'): int|string|null
    {

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
    public function loadConfigFile(): array
    {

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

    /**
     * @return mixed
     */
    public function generateNewConfig() {

        $messages = new MessageController();

        $messages->addMessage( false, "Custom config file not found. Creating new one from master.");

        $data = $this->getMasterConfigFile();

        $config = Parsers::parseTextConfigFile($data);

        return $this->writeEditorConfigFile($this->generateFilename(), $config);

    }

    /**
     * @return array
     */
    public function getMasterConfigFile(): array
    {

        $filename = EZPEPATH."/config.master.txt";
        $source = 'text';

        $file = file_get_contents($filename);

        $data = [
            'file' => $file,
            'config' => [ 'source' => $source ]
        ];

        return $data;

    }

    /**
     * @param $filename
     * @param $data
     * @return mixed
     */
    public function writeEditorConfigFile($filename, $data) {

        $messages = new MessageController();
        $filecontent = [];

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

    /**
     * @return false|string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function writeTextConfig(): bool|string
    {
        $messages = new MessageController();

        // Clear previous messages
        $messages->clearMessages();

        // Load the configuration data
        $file = $this->loadConfigFile();

        // Parse the JSON configuration file
        $data = Parsers::parseJsonConfigFile($file);

        // Generate a filename for the new configuration file
        $filename = $this->generateFilename('config_', '.txt');

        try {
            // Instantiate RenderView with the required parameters
            $renderView = new RenderView(Config::$twig);

            // Get the template content for the config file
            $output = $renderView->getTemplate("config/sections_config", $data);

            // Write the output to the file
            file_put_contents(EZPEWRITEABLE . $filename, $output . PHP_EOL);

            // Log success
            $messages->addMessage(true, "Wrote file " . basename($filename) . " successfully");

            return $filename;
        } catch (Exception $e) {
            // Log any errors that occur during the write operation
            $messages->addMessage(false, "Couldn't write file " . basename($filename));
            error_log("Error in writeTextConfig: " . $e->getMessage(), 3, "/var/log/cas_debug.log");

            return false;
        }
    }


    /**
     * @param string $filename
     * @param string $suffix
     * @return string
     */
    public function generateFilename(string $filename = 'config_', string $suffix = '.json') {

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
