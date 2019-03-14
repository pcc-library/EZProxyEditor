<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 13:56
 */

namespace PCC_EPE\Controllers;

/**
 * Class Parsers
 * @package PCC_EPE\Functions
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

//            case 'text':
//            return self::parseTextConfigFile($config);
//            break;
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

        $files = new Files();

        $sections = explode('## ', $config['file']);

        foreach($sections as $section) {

            $section_title = strtok($section, "\n");

            $pos = strpos($section, $section_title);
            if ($pos !== false) {
                $section_content = substr_replace($section, '', $pos, strlen($section_title));
            }

            if( strlen( $section_title ) > 1  ) {

                $config['sections'][] = [
                    'section_title' => self::formatTitle($section_title),
                    'content' => self::formatContent($section_title, $section_content),
                ];

            }

        }

        return $config;

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