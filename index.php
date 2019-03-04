<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Functions\LoadConfig;
use PCC_EPE\Frontend\RenderUI;

$data = LoadConfig::init();

echo '<pre>'.print_r(json_encode($data, JSON_PRETTY_PRINT),true).'</pre>';


//echo RenderUI::renderSections($data);

//echo "<pre>".print_r($_POST, true)."</pre>";
//
//if($_POST) {
//
//    $data['sections'] = $_POST['sections'];
//
//    echo RenderUI::renderSections($data);
//
//} else {
//
//    echo RenderUI::renderSections($data);
//
//};

//echo "<pre>".print_r($_POST, true)."</pre>";

