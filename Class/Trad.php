<?php
namespace app;

class Trad
{

    public function __construct($trad = '')
    {

        $this->traduction = $trad;

    }

    public function setTrad($traduction = '')
    {

        $this->trad = $traduction;

        require 'vendor/autoload.php';
        require('fileupload.php');
        
        // use Stichoza\GoogleTranslate\GoogleTranslate;
        
        $faker = Faker\Factory::create();
        // ouverture du csv avec fopen
        // $csv    = fopen('Polaris_CSV/POLARIS_NOMS.csv', 'a+');
        $csv    = fopen($_FILES["monfichier"]["tmp_name"], 'a+');
        $output = fopen('output.csv', 'w');
        $cpt = 0;
        $limit = 800;
        // $str = '&amp;&Eacute;&gt;&lt;';
        
            // boucle pour traduire le csv
            while ($column = fgetcsv($csv, 0, ';')) {
                $a = true;
                while ($a) {
        
                    try{
                        $sku   = $column[0];
                        $title = html_entity_decode(str_replace(['&amp;','EACUTE'], ['', '&Eacute'], $column[1]));
                        $desc  = html_entity_decode(str_replace(['&gt;','&lt'], [' ',' '], $column[2]));
                        // $desc = htmlspecialchars_decode($str, ENT_COMPAT);
                        
                        // echo("1");
        
                        $tr = new GoogleTranslate(
                            'fr',
                            'en',
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
        
                        // echo("2");
        
                        // traduction
                        $titleTranslate = $tr->translate(str_replace(',', '', $title));
                        $descTranslate = $tr->translate($desc);
        
                        echo("3");
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
                        $a = false;
        
                    } catch (Exception $a) {
                        // echo ('erreur'.$sku);
                }
        
            }
                
        }
        
        // fermeture du csv avec fclose
        fclose($output);
        fclose($csv);

    }

    public function getTrad()
    {

        return $this->trad;

    }

}


?>