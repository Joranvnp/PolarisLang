<?php
namespace app;

class Import
{

    public function __construct($bouton = '')
    {

        $this->boutonImport = $bouton;
        

    }

    public function setImport($boutonImport = '')
    {
        
        $this->bouton = $boutonImport;

        echo '<form enctype="multipart/form-data" action="fileupload.php" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000000" />
        Inserer un fichier CSV pour traduire <input class= "bordure "type="file" name="monfichier" />
        <input type="submit" />
      </form>';

    }


    public function getImport()
    {

        return $this->bouton;

    }
}


?>