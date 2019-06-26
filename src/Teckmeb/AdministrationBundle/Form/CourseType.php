<?php

namespace Teckmeb\AdministrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CourseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('creationYear')
            ->add('courseType', EntityType::class, array(
                    'class' => 'TeckmebAdministrationBundle:CourseType',
                    'choice_label' => 'name',
                    'multiple' => false,))
            ->add('teachingUnits', EntityType::class, array(
                    'class' => 'TeckmebAdministrationBundle:TeachingUnit',
                    'choice_label' => 'teachingUnitFullName',
                    'multiple' => true,
                    'expanded' => true));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\AdministrationBundle\Entity\Course'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_administrationbundle_course';
    }


}
