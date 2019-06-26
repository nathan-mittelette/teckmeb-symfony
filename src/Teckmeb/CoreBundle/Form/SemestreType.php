<?php

namespace Teckmeb\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SemestreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', EntityType::class, array(
                'class' => 'TeckmebAdministrationBundle:Course',
                'multiple' => false,
            ))
            ->add('schoolYear')
            ->add('delay')
            ->add('endDate', DateType::class, array(
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyy',
                'label' => 'Date de fin',
            ))
            ->add('beginDate', DateType::class, array(
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyy',
                'label' => 'Date de début',
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\CoreBundle\Entity\Semestre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_corebundle_semestre';
    }


}
