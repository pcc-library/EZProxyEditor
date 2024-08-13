<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:50
 */
namespace PCC_EPE\Controllers;

use Exception;
use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;

/**
 * Class RouteController
 * @package PCC_EPE\Controllers
 */
class RouteController
{
    protected $renderView;

    public function __construct(RenderView $renderView)
    {
        $this->renderView = $renderView;
    }

    /**
     * Render Editor Page
     */
    public function editor() {
        echo $this->renderPage('editor', false);
    }

    /**
     * Render New Stanza Page
     */
    public function addnew() {
        echo $this->renderPage('new', false);
    }

    /**
     * Render Preview Page
     */
    public function preview() {
        echo $this->renderPage('preview', false);
    }

    /**
     * Render Validate Page
     */
    public function validate() {
        echo $this->renderPage('validate', false);
    }

    /**
     * Render Preview Page with Write flag.
     */
    public function write() {
        try {
            // Initialize the Files class
            $files = new Files();

            // Attempt to write the configuration file
            $filename = $files->writeTextConfig();

            if ($filename) {
                // Log the success
                error_log("Configuration successfully written to file: $filename", 3, "/var/log/cas_debug.log");

                // Re-render the preview page with the write flag set to true
                echo $this->renderPage('preview', true);
            } else {
                // Log failure and throw an exception
                error_log("Failed to write the configuration file.", 3, "/var/log/cas_debug.log");
                throw new \Exception("Failed to write configuration.");
            }
        } catch (Exception $e) {
            // Log the error
            error_log("Error in write method: " . $e->getMessage(), 3, "/var/log/cas_debug.log");

            // Render the preview page with an error message
            echo $this->renderPage('preview', false, [
                'error' => "An error occurred while writing the configuration: " . $e->getMessage()
            ]);
        }
    }


    public function upload() {
        $remote = new UploadController();
        $data = $remote->UploadConfig();
        echo $this->renderPage('upload', false, $data);
    }

    /**
     * Handle form submission and update the configuration.
     */
    public function update()
    {
        // Get the post data from Config
        $postData = Config::$post_data;

        // Debug: Log the form data to the CAS debug log
//        error_log("Form submission data: " . print_r($postData, true), 3, "/var/log/cas_debug.log");

        $messages = new MessageController();

        $files = new Files();

        try {
            // Validate and process the post data
            if (!isset($postData['sections']) || !is_array($postData['sections'])) {
//                $messages->addMessage(false, "Invalid data: 'sections' is missing or not an array.");
                echo $this->renderPage('editor', false);
                return;
            }

            // Generate the filename and write the updated config
            $filename = $files->generateFilename();
            $configData = ['sections' => $postData['sections']];

            // Log the file write operation
            error_log("Attempting to write config file: " . $filename, 3, "/var/log/cas_debug.log");

            $files->writeEditorConfigFile($filename, $configData);

            // Log success
            error_log("Successfully wrote config file: " . $filename, 3, "/var/log/cas_debug.log");

            // Redirect or reload the page after successful update
            header("Location: " . BASEURL . "/");
            exit;

        } catch (Exception $e) {
            // Log the error
            error_log("Error during update: " . $e->getMessage(), 3, "/var/log/cas_debug.log");
            $messages->addMessage(false, "An error occurred: " . $e->getMessage());
            echo $this->renderPage('editor', false);
        }
    }




    /**
     * @param $pagename | string
     * @param $write | bool
     * @param $data | array
     * @return string
     */
    public function renderPage($pagename, $write, $data = null) {
        $user = Config::$user;

        if (!$data) {
            $data = GetDataController::init();
        }

        if ($user) {
            $master = ValidateData::init();
            $current = (array) $data['sections'][2];

            $files = new Files();
            $data['rss_feed'] = RSSFeed::rssFeed();
            $data['baseurl'] = BASEURL;
            $data['user'] = Formatters::formatName($user);
            $data['master'] = ValidateData::sortStanzaNames(ValidateData::getSubscriptionDatabases($master));
            $data['titles'] = ValidateData::sortStanzaNames($current['content']);

            $data['difference'] = array_diff($data['master'], $data['titles']);

            if ($write) {
                $data['filename'] = $files->writeTextConfig();
            }
        } else {
            $pagename = 'nope';
            $data = [];
            $data['baseurl'] = BASEURL;
        }

        return $this->renderView->getTemplate($pagename, $data);
    }
}
