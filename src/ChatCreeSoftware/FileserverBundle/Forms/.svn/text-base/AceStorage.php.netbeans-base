<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Validator\Constraints as Assert;

class AceStorage
{
    public static $ace_map = array(
                   'Voir' => MaskBuilder::MASK_VIEW,
                   'Editer' => MaskBuilder::MASK_EDIT,
                   'Admin' => MaskBuilder::MASK_OWNER
                ); 
    
    private $select;
    private $user;
    private $ace;
    private $aceEntry;
    
    public function getSelect(){
        return $this->select;
    }
    
    public function setSelect( $select ){
        $this->select = $select;
    }
    
    public function getUser(){
        return $this->user;
    }
    
    public function setUser( $user ){
        $this->user = $user;
    }
 
    public function getAce(){
        return $this->ace;
    }
    
    public function setAce( $ace ){
        $this->ace = $ace;
    }
    
    public function getAceEntry(){
        return $this->aceEntry;
    }
    
    public function setAceEntry( $aceEntry ){
        $this->aceEntry = $aceEntry;
    }
}
?>
