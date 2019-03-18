<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-18
 * Time: 11:52
 */

namespace PCC_EPE\Controllers;

use PCC_EPE\Models\Messages;

class MessageController
{

    public function getMessages() {

        return Messages::$messages;

    }

    public function addMessage($status, $text) {

        Messages::$messages[] = Formatters::formatMessage($status, $text);

        return true;

    }

    public function clearMessages() {

        Messages::$messages = [];

        return true;

    }

}