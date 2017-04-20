<?php

namespace ChatCreeSoftware\FileserverBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('file', 'Symfony\Component\Form\Extension\Core\Type\FileType')
                ->add('attach', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array( 'required' => false ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\FileAttach',
        ));
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'ChatCreeSoftware\FileserverBundle\Forms\FileAttach',
            'csrf_protection' => true,
            'csrf_field_name' => 'filetoken',);
    }

}

?>
