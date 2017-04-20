<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use ChatCreeSoftware\FileserverBundle\Forms\Aces;
use ChatCreeSoftware\FileserverBundle\Forms\AceStorage;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType {
       
    public function buildForm( FormBuilderInterface $builder, array $options ){
        $builder->add( 'primaire', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('label' => ' ', 'required' => false ) )
                ->add( 'id', 'Symfony\Component\Form\Extension\Core\Type\HiddenType')
                ->add( 'mail','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'attr' => array( 'style' => 'width: 245px' )));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChatCreeSoftware\CoreBundle\Entity\Email',
        ));
    }

    public function getDefaultOptions( array $options){
        return array(
            'data_class' => 'ChatCreeSoftware\CoreBundle\Entity\Email',
            'csrf_protection' => true,
            'csrf_field_name' => 'mailtoken',);
    }    
}
?>
