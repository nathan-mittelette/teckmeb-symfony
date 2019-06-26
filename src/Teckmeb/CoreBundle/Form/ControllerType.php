<?php

namespace Teckmeb\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ControllerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomBundle' , TextType::class, array(
                'label' => "Nom du bundle"
            ))
            ->add('nomRoute' , TextType::class , array(
                'label' => "Nom de la route"
            ))
            ->add('nomNavbar' , TextType::class , array(
                'label' => "Nom sur la navbar" 
            ))
            ->add('nomController' , TextType::class)
            ->add('valide' , CheckboxType::class , array(
                'required' => false
            ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\CoreBundle\Entity\Controller'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_corebundle_controller';
    }
}
