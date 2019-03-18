<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 13:56
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Config;

/**
 * Class Parsers
 * @package PCC_EPE\Controllers
 * Initialize the editor by loading config file, fetch OCLC RSS, populate content array for twig to render.
 */
class Parsers
{


    public static function parseConfig($config) {


        switch ($config['config']['source']) {

            case 'json':
            return self::parseJsonConfigFile($config);
            break;

            case 'post':
            return $config;
            break;

        }

        return $config;

    }

    public static function parsePostData($config) {

        $files = new Files();

        $data = [
                'config'   => [
                    'source' => 'post'
                ],
                'sections' => $config
            ];

        $data['messages'][] = Formatters::formatMessage(true,'Configuration updated.');

        return $files->writeEditorConfigFile($files->generateFilename(), $data);

    }

    public static function parseJsonConfigFile($config) {

        $data = [
            'config'   => [
                'source' => $config['config']['source']
            ],
            //'rss_feed' => RSSFeed::fetchRSSFeed(),
            'messages' => $config['messages'],
            'sections' => json_decode($config['file'])
        ];

        return $data;

    }



    /**
     * @param $file
     * @return array
     */
    public static function parseTextConfigFile($config ) {

        $sections = explode('## ', $config['file']);

        foreach($sections as $section) {

            $section_title = strtok($section, "\n");

            $pos = strpos($section, $section_title);
            if ($pos !== false) {
                $section_content = substr_replace($section, '', $pos, strlen($section_title));
            }

            if( strlen( $section_title ) > 1  ) {

                $config['sections'][] = [
                    'section_title' => Formatters::formatTitle($section_title),
                    'content' => Formatters::formatContent($section_title, $section_content),
                ];

            }

        }

        return $config;

    }

}