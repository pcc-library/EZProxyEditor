<?php

namespace PCC_EPE;

require __DIR__ . '/vendor/autoload.php';

define( 'PCCEPEPATH', __DIR__.'/' );

use PCC_EPE\Functions;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EZProxy Editor</title>

    <script src="assets/js/app.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

</head>
<body>

<?php $sections = Functions\ParseConfigFile::parseConfig(); ?>
<main role="main" class="container">

<?php

if($sections) {

    foreach ($sections as $section) {

        if($section['section_title']  && $section['content'] !=='' ) {

            echo '<section class="container">';

            echo "<h2>" . $section['section_title'] . "</h2>";

            foreach ($section['content'] as $item) {

                if($item['stanza_title']) {

                    echo "<article class='card'>";

                    echo "<div class=\"card-body\">";

                    echo "<h5 class=\"card-title\">" . $item['stanza_title'] . "</h5>";

                    echo "<pre>" . $item['stanza_body'] . "</pre>";

                    echo "</div>";

                    echo "</article>";

                }

            }

            echo '</section>';
            echo "<hr/>";

        }
    }

}


?>
</main>
</body>
</html>