<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-07
 * Time: 14:03
 */

namespace PCC_EPE\Functions;


class Utilities
{

    /**
     * @param $data array
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

}