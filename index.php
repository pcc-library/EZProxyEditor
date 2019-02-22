<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EZProxy Editor</title>
</head>
<body>

<?php

require_once 'ezproxyeditor.php';

$file = file_get_contents("config.master.txt");

$config = explode('## ', $file);

foreach($config as $stanza) {
    
        $stanza_title = strtok($stanza, "\n");

        $pos = strpos($stanza, $stanza_title);
        if ($pos !== false) {
            $newstring = substr_replace($stanza, '', $pos, strlen($stanza_title));
        }

        echo "<b>".$stanza_title."</b>";
        echo "<pre>".$newstring."</pre>";

        echo "<hr/>";
    }
?>

</body>
</html>