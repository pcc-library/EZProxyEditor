<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Functions\LoadConfig;
use PCC_EPE\Frontend\RenderUI;

$data = LoadConfig::init();

echo RenderUI::renderSections($data);

if($_POST) {
echo '<pre>'.print_r(json_encode($_POST, JSON_PRETTY_PRINT),true).'</pre>';
};
