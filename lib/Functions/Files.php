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

        $files = glob(PCCEPEPATH."config_*");
        $files = array_combine($files, array_map('filectime', $files));
        arsort($files);

        return key($files); // the filename

    }

    public function loadConfigFile() {

        $filename = $this->findConfigFile();

        if(!$filename) {

            $messages['status'] = false;
            $messages['text'] = "Custom config.txt file not found. Creating new one from master.";
            $filename = PCCEPEPATH."config.master.txt";

        } else {
            $messages['status'] = true;
            $messages['text'] = "Found ".$filename;

        }

        $file = file_get_contents($filename);

        return ['file' => $file, 'messages' => $messages];

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
