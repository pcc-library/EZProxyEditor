<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-07
 * Time: 14:03
 */

namespace PCC_EPE\Controllers;


class Formatters
{

    /**
     * @param $status | bool
     * @param $text | string
     * @return array
     */
    public static function formatMessage($status, $text) {

        return [
            $messages['status'] = $status,
            $messages['text'] = $text
        ];

    }

    /**
     * @param $title
     * @return mixed
     */
    public static function formatTitle($title) {

        return str_replace('Start ','', html_entity_decode($title));

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

    public static function updateDate($data) {

        date_default_timezone_set('America/Los_Angeles');

        $date = date('m/d/y h:i:s A');

        $data[0]['content'][0]['stanza_title'] = 'Updated '.$date;

        return $data;

    }

    public static function formatName($name) {

        return ucwords( str_replace(['.', ','], ' ' , $name) );

    }


}