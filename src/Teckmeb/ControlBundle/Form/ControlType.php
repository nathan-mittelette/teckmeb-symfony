<?php

namespace Teckmeb\ControlBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Teckmeb\CoreBundle\Repository\EducationRepository;


class ControlType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->teacher = $options['teacher'];
        $teacher = $this->teacher;
        $builder
            ->add('controlName', TextType::class)
            ->add('coefficient', IntegerType::class)
            ->add('divisor', IntegerType::class)
            ->add('education', EntityType::class, array(
            'class'        => 'TeckmebCoreBundle:Education',
            'choice_label' => 'educationName',
            'multiple'     => false,
            'query_builder' => function(EducationRepository $repository) use($teacher) {
          return $repository->getEducationTeacher($teacher);}
          ))
            ->add('controlDate', DateType::class, array(
            'widget' => 'single_text',
            'attr' => ['class' => 'datepicker'],
            'format' => 'dd/MM/yyy',
            'label' => 'Date',
        ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\ControlBundle\Entity\Control',
            'teacher' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_controlbundle_control';
    }
}
