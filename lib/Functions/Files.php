<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-22
 * Time: 14:41
 */

namespace PCC_EPE\Functions;

use Exception;

class Files
{

    /**
     * @return null|string
     */
    public function findConfigFile() {

        $files = glob("config_*");
        $files = array_combine($files, array_map('filectime', $files));
        arsort($files);

        return key($files); // the filename

    }

    public function loadConfigFile() {

        $filename = $this->findConfigFile();

        if(!$filename) {

            echo "Custom config.txt file not found. Creating new one from master. ";

            $filename = "config.master.txt";

        }

        $file = file_get_contents($filename);

        return $file;

    }

    public function RemoveLocalFile($file) {

        if(file_exists($file)) {

            unlink($file);

            return true;

        } else {

            return false;

        }

    }


}
