<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SequenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('events','bootstrap_collection',
                      array(
                            'type' => new EventType(),
                            'allow_add'          => true,
                            'allow_delete'       => true,
                            'add_button_text'    => 'Add',
                            'delete_button_text' => 'X',
                            'sub_widget_col'     => 11,
                            'button_col'         => 1,
                            'prototype_name'     => 'inlinep',
                            'options'            => array(
                              'attr' => array('style' => 'inline')
                            )
                        ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sequence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_sequence';
    }
}
