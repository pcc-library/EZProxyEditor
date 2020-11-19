<?php


namespace PCC_EPE\Controllers;

class ValidateData
{

    public static function init() {

        $files = new Files();

        return Parsers::parseTextConfigFile($files->getMasterConfigFile());

    }

    public static function getSubscriptionDatabases($configuration) {

        return $configuration['sections'][2]['content'];

    }

    public static function sortStanzaNames($stanzas) {

        $sorted = array_column($stanzas, 'stanza_title');

        return array_values($sorted);
    }

}