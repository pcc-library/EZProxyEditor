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

        $renderUI = $this->getRenderUIInstance();
        $data = GetDataController::init();
        $data['rss_feed'] = RSSFeed::rssFeed();
        $data['baseurl'] = BASEURL;

        echo  $renderUI->renderTemplate('editor', $data);

    }

    public function preview() {

        $renderUI = $this->getRenderUIInstance();
        $data = GetDataController::init();
        $data['rss_feed'] = RSSFeed::rssFeed();
        $data['baseurl'] = BASEURL;

        echo  $renderUI->renderTemplate('preview', $data);

    }

    public function write() {

        $renderUI = $this->getRenderUIInstance();
        $files = $this->getFileInstance();
        $data = GetDataController::init();
        $data['rss_feed'] = RSSFeed::rssFeed();
        $data['baseurl'] = BASEURL;

        $data['messages'][] = $files->writeTextConfig();

        echo  $renderUI->renderTemplate('preview', $data);

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