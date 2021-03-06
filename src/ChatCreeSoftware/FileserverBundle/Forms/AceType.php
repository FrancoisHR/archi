<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use ChatCreeSoftware\FileserverBundle\Forms\AceStorage;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AceType extends AbstractType {
   
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder->add( 'select', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('required' => false ));

        $userOptions = array(
                'class' => 'ChatCreeSoftware\CoreBundle\Entity\User',
                'choice_label' => 'login',
            );
        
        if( isset( $options['excludeUsers'] )) {
            $userOptions['query_builder'] = function(EntityRepository $er) use ($options){
                
                return $er->createQueryBuilder('u') 
                        ->andWhere( "u.login NOT IN (" . $options['excludeUsers'] . ") ")
                        ->orderBy( "u.login", "ASC" );
            };
        } else {
            $userOptions['query_builder'] = function(EntityRepository $er) use ($options){
                
                return $er->createQueryBuilder('u') 
                        ->orderBy( "u.login", "ASC" );
            };            
        }
        
        $builder->add(
                'user',EntityType::class, $userOptions );
          
        $builder->add(
                'ace', ChoiceType::class, array(
                'choices' => AceStorage::$ace_map ) );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\AceStorage',
        ));
    }
    
    public function getDefaultOptions( array $options){
        return array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\AceStorage',
            'csrf_protection' => true,
            'csrf_field_name' => 'token',
            'excludeUsers' => null );
    }
}
?>
