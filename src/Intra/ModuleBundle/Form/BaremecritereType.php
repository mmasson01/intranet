<?php

namespace Intra\ModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BaremecritereType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text', array('attr' => array('class' => 'form-control')))
            ->add('description', 'textarea', array('attr' => array('class' => 'form-control')))
            ->add('points', 'collection', array(
                'type' => new BaremepointType(),
                'prototype' => true,
                'prototype_name' => 'points_name',
                'allow_add' => true,
                'by_reference' => false,
                'attr' => array('class' => 'points'),
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intra\ModuleBundle\Entity\Baremecritere'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'intra_modulebundle_baremecritere';
    }
}
