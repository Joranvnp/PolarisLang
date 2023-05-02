<?php

        use app\Import;
        use app\Archive;
        use app\Trad;


        require('Class/Import.php');
        require('Class/Archive.php');
        require('Class/Trad.php');

        $nomOrigine = 'import/'.$_FILES['monfichier']['name'];
        $elementsChemin = pathinfo($nomOrigine);
        $extensionFichier = $elementsChemin['extension'];
        $extensionsAutorisees = array("csv");

        foreach (glob("import/*.csv") as $filename) {
            unlink($filename);
        }

        if (!(in_array($extensionFichier, $extensionsAutorisees))) {
            echo "Le fichier n'a pas l'extension attendue";
        } else {    
            
            $repertoireDestination = dirname(__FILE__)."/";
            $nomDestination = "fichier_du_".date("d_m_Y_H_i").".".$extensionFichier;

            // echo($_FILES["monfichier"]["tmp_name"]."///". $repertoireDestination.$nomOrigine);

            if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], $repertoireDestination.$nomOrigine)) {

                exec("php main.php $nomOrigine");

                echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                        " a été déplacé vers ".$repertoireDestination.$nomOrigine;


            } else {
                echo "Le fichier n'a pas été uploadé ou ".
                        "Le déplacement du fichier temporaire a échoué".
                        " vérifiez l'existence du répertoire ".$repertoireDestination;
            }

        }

        $boutonArchive = new Archive();
        echo $boutonArchive->setArchive();

?>
