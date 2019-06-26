<?php

namespace Teckmeb\AbsenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AbsenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('beginDate', DateType::class, array(
            'widget' => 'single_text',
            'attr' => ['class' => 'datepicker'],
            'format' => 'dd/MM/yyyy',
            'label' => 'Date',
        ))
            ->add('justified')
            ->add('absenceType', EntityType::class, array(
            'class' => 'TeckmebAbsenceBundle:AbsenceType',
            'choice_label' => 'absenceTypeName',
            'multiple' => false
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\AbsenceBundle\Entity\Absence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_absencebundle_absence';
    }


}
