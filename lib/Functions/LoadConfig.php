<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 13:56
 */

namespace PCC_EPE\Functions;

/**
 * Class LoadConfig
 * @package PCC_EPE\Functions
 * Initialize the editor by loading config file, fetch OCLC RSS, populate content array for twig to render.
 */
class LoadConfig
{

    /**
     * @return array
     */
    public static function init() {

        $files = new Files();

        $config = $files->loadConfigFile();

        $data = self::splitConfigFile($config);

        return  $files->writeConfigFile($files->generateFilename(), $data);

    }

    public static function parseConfig($config) {

        return $config['json'] ? self::splitConfigFile($config) : null;

    }

    /**
     * @param $file
     * @return array
     */
    public static function splitConfigFile($file ) {

        $sections = explode('## ', $file['file']);

        $output = [
            //'config'   => [],
            'rss_feed' => RSSFeed::fetchRSSFeed(),
            'messages' => $file['messages'],
            //'sections' => []
        ];


        foreach($sections as $section) {

            $section_title = strtok($section, "\n");

            $pos = strpos($section, $section_title);
            if ($pos !== false) {
                $section_content = substr_replace($section, '', $pos, strlen($section_title));
            }

            if( strlen( $section_title ) > 1  ) {

                $output['sections'][] = [
                    'section_title' => self::formatTitle($section_title),
                    'content' => self::formatContent($section_title, $section_content),
                ];


            }

        }

        return array_filter($output);

    }

    /**
     * @param $title
     * @return mixed
     */
    public static function formatTitle($title) {

        return str_replace('Start ','',$title);

    }

    /**
     * @param $title
     * @param $content
     * @return array
     */
    public static function formatContent($title, $content) {

        return self::splitStanzas($content);

    }

    /**
     * @param $content
     * @return array
     */
    public static function splitStanzas($content) {

        $stanzas = explode('# ', $content);
        $output = [];

        foreach($stanzas as $stanza) {

            $stanza_title = strtok($stanza, "\n");

            $pos = strpos($stanza, $stanza_title);
            if ($pos !== false) {
                $stanza_content = substr_replace($stanza, '', $pos, strlen($stanza_title));
            }

            if( strlen($stanza_title) > 1 ) {

                $output[] = [
                    'stanza_title' => $stanza_title,
                    'stanza_body' => trim($stanza_content)
                ];


            }

        }

        return array_filter($output);

    }

}