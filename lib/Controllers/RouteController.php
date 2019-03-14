<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-12
 * Time: 13:50
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Config;

/**
 * Class RouteController
 * @package PCC_EPE\Controllers
 */
class RouteController
{

    public function editor() {

        echo $this->renderPage('editor', false);

    }

    public function preview() {

        echo $this->renderPage('preview', false);

    }

    public function write() {

        echo $this->renderPage('preview', true);

    }

    public function renderPage($pagename, $write) {

        $renderUI = $this->getRenderUIInstance();
        $files = $this->getFileInstance();
        $data = GetDataController::init();
        $data['rss_feed'] = RSSFeed::rssFeed();
        $data['baseurl'] = BASEURL;

        if($write) {
            $data['messages'][] = $files->writeTextConfig();
        }

        return  $renderUI->renderTemplate($pagename, $data);

    }

    public function getTwigInstance()
    {
        return Config::$twig;
    }

    public function getRenderUIInstance()
    {
        return Config::$renderUI;
    }

    public function getProjectSubFolderPath()
    {
        return Config::$strSubfolderRoute;
    }

    public function getRouterInstance()
    {
        return Config::$router;
    }

    public function getPostDataInstance()
    {
        return Config::$post_data;
    }

    public function getFileInstance()
    {
        return Config::$files;
    }

}