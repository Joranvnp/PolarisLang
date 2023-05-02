<?php
namespace app;

class Archive
{

    public function __construct($bouton = '')
    {

        $this->boutonArchive = $bouton;

    }

    public function setArchive($boutonArchive = '')
    {
        
        $this->bouton = $boutonArchive;

        echo '<form enctype="multipart/form-data" action="export" method="post"> Archive
        <input type="submit" /> </form>';

    }


    public function getArchive()
    {

        return $this->bouton;

    }
}


?>