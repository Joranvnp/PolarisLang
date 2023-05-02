<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php

            use app\Import;
            use app\Archive;

            // require('main.php');
            require('Class/Import.php');
            require('Class/Archive.php');

            $boutonImport = new Import();
            echo $boutonImport->setImport();

            $boutonArchive = new Archive();
            echo $boutonArchive->setArchive();

        ?>
    </body>

