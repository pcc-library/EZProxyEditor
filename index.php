<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

use PCC_EPE\Functions;

$file = Functions\ParseConfigFile::parseConfig();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EZProxy Editor</title>
</head>
<body>

<?php


if($file) {


    foreach ($file as $stanza) {

        echo "<b>" . $stanza->stanza_title . "</b>";
        echo "<pre>" .$stanza->stanza_body . "</pre>";

        echo "<hr/>";
    }

}


?>

</body>
</html>