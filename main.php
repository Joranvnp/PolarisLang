<?php

require 'vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

$faker = Faker\Factory::create();
// ouverture du csv avec fopen
$csv    = fopen(/*$argv[1]*/ './import/TEST_FRONT.csv' , 'a+');
$output = fopen('./export/output.csv', 'w');
$cpt = 0;
$limit = 800;
// $str = '&amp;&Eacute;&gt;&lt;';

    // boucle pour traduire le csv
    while ($column = fgetcsv($csv, 0, ';')) {
        // $a = true;
        // while ($a) {

        //     try{
                $sku   = $column[0];
                $title = html_entity_decode(str_replace(['&amp;','EACUTE'], ['', '&Eacute'], $column[1]));
                $desc  = html_entity_decode(str_replace(['&gt;','&lt'], [' ',' '], $column[2]));
                // $desc = htmlspecialchars_decode($str, ENT_COMPAT);

                $tr = new GoogleTranslate(
                    'fr', // langue résultat
                    'null', // langue de départ -> si mit à nul détection langue automatique
                    [
                        'timeout' => 10,
                        'headers' => [
                            'User-Agent' => $faker->userAgent()
                        ],
                        'proxy' => [
                            // 'https' => '92.172.168.187:8080',
                        ]
                    ]
                );

                // traduction
                $titleTranslate = $tr->translate(str_replace(',', '', $title));
                $descTranslate = $tr->translate($desc);

                // condition pour écrire la traduction
                if ($desc != '') {
                    print_r($sku . ' - ' . $titleTranslate . ' - ' . $descTranslate . "\n");
                } else {
                    print_r($sku . ' - ' . $titleTranslate . "\n");
                }

                // ecriture de la traduction dans le fichier csv
                fputcsv($output, array($sku, $titleTranslate, $descTranslate, ';'));

                // condition pour attendre entre chaque requête
                if ($cpt % 2 === 0) {
                    sleep(0.5);
                } else {
                    sleep(5);
                }
                $cpt++;
                // die();
        //         $a = false;

        //         } catch (Exception $a) {
        //             // echo ('erreur'.$sku);
        //     }

        // }
        
    }

// fermeture du csv avec fclose
fclose($output);
fclose($csv);

?>