<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use ChatCreeSoftware\FileserverBundle\Forms\Aces;
use ChatCreeSoftware\FileserverBundle\Forms\AceStorage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectAceType extends AbstractType {
       
    public function buildForm( FormBuilderInterface $builder, array $options ){
        $builder->add( 'aces', CollectionType::class, array(
//            'type' => new AceType(), 'options' => array( 'select' => true, 'editUser' => false ) )
            'entry_type' => AceType::class )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\Aces',
        ));
    }
    
    public function getDefaultOptions( array $options){
        return array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\Aces',
            'csrf_protection' => true,
            'csrf_field_name' => 'acetoken',);
    }    
}
?>
