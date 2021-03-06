<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:50
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Config;
use PCC_EPE\View\RenderView;

/**
 * Class RouteController
 * @package PCC_EPE\Controllers
 */
class RouteController
{

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

        echo $this->renderPage('preview', false );

    }


    /**
     * Render Validate Page
     */
    public function validate() {

        echo $this->renderPage('validate', false );

    }


    /**
     * Render Preview Page with Write flag
     */
    public function write() {

        echo $this->renderPage('preview', true );

    }

    /**
     *
     */
    public function upload() {

        $remote = new UploadController();

        $data = $remote->UploadConfig();

        echo $this->renderPage('upload', false, $data);

    }

    /**
     * @param $pagename | string
     * @param $write | bool
     * @param $data | array
     * @return mixed
     */
    public function renderPage($pagename, $write, $data = null) {

        $user = Config::$user;
        $views = new RenderView();

        if(!$data) {
            $data = GetDataController::init();
        }

        if($user) {

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

        }

        return  $views->getTemplate($pagename, $data);

    }



}