<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Functions\ParseConfigFile;
use PCC_EPE\Frontend\RenderUI;

$data = ParseConfigFile::parseConfig();


echo RenderUI::renderSections($data);

echo '<pre>'.print_r(json_encode($_POST),true).'</pre>';

