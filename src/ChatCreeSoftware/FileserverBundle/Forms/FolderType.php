<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;

class FolderType {
    private $folderName;

    public function getFolderName(){
        return $this->folderName;
    }
    
    public function setFolderName( $folderName ){
        $this->folderName = $folderName;
    }
}
?>
