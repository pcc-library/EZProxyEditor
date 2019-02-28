<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 13:56
 */

namespace PCC_EPE\Functions;

class ParseConfigFile
{

    public static function parseConfig() {

        $loadFile = new Files();

        $file = $loadFile->loadConfigFile();

        return self::splitConfigFile($file);

    }

    public static function splitConfigFile( $file ) {

        $sections = explode('## ', $file['file']);

        $output = [
            'rss_feed' => RSSFeed::fetchRSSFeed(),
            'messages' => [],
            'sections' => []
        ];

        array_push($output['messages'], $file['messages']);

        foreach($sections as $section) {

            $section_title = strtok($section, "\n");

            $pos = strpos($section, $section_title);
            if ($pos !== false) {
                $section_content = substr_replace($section, '', $pos, strlen($section_title));
            }

            array_push($output['sections'],[
                'section_title' => self::formatTitle($section_title),
                'content' => self::formatContent($section_title, $section_content),
            ]);
            
        }
        
        return array_filter($output);
        
    }

    public static function formatTitle($title) {

        return str_replace('Start ','',$title);

    }

    public static function formatContent($title, $content) {

                return self::splitStanzas($content);

    }

    public static function splitStanzas($content) {

        $stanzas = explode('# ', $content);

        foreach($stanzas as $stanza) {

            $stanza_title = strtok($stanza, "\n");

            $pos = strpos($stanza, $stanza_title);
            if ($pos !== false) {
                $stanza_content = substr_replace($stanza, '', $pos, strlen($stanza_title));
            }

            $output[] = [ 'stanza_title' => $stanza_title, 'stanza_body' => $stanza_content];

        }

        return array_filter($output);

    }

}