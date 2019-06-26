<?php

namespace Teckmeb\AdministrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TeachingUnitType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('teachingUnitCode')
            ->add('teachingUnitName')
            ->add('creationYear')
            ->add('modules', EntityType::class, array(
                'class' => 'TeckmebAdministrationBundle:Module',
                'choice_label' => 'moduleFullName',
                'multiple' => true,
                'expanded' => true,
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\AdministrationBundle\Entity\TeachingUnit'
        ));
    }
}
