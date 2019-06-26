<?php

namespace Teckmeb\ControlBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Teckmeb\CoreBundle\Repository\SubjectRepository;
use Teckmeb\CoreBundle\Repository\GroupeRepository;
use Teckmeb\ControlBundle\Model\FiltreControl;
use Teckmeb\ControlBundle\Repository\ControlTypeRepository;


class FiltreControlType extends AbstractType
{
    public $teacher;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->teacher = $options['teacher'];
        $teacher = $this->teacher;
        $builder
            ->add('subject', EntityType::class, array(
                'class' => 'TeckmebCoreBundle:Subject',
                'placeholder' => 'Tous',
                'label' => 'Matières',
                'multiple' => false,
                'required' => false,
                'query_builder' => function (SubjectRepository $repository) use ($teacher) {
                    return $repository->getSubjectByTeacher($teacher);
                }
            ))
            ->add('groupe', EntityType::class, array(
                'class'        => 'TeckmebCoreBundle:Groupe',
                'label' => 'Groupes',
                'placeholder' => 'Tous',
                'multiple'     => false,
                'required' => false,
                'query_builder' => function (GroupeRepository $repository) use ($teacher) {
                    return $repository->getGroupesByTeacher($teacher);
                }
            ))
            ->add('typeControl', EntityType::class, array(
                'class'        => 'TeckmebControlBundle:ControlType',
                'label' => 'Type de contrôle',
                'placeholder' => 'Tous',
                'multiple'     => false,
                'required' => false,
                'query_builder' => function (ControlTypeRepository $repository) {
                    return $repository->getTypeControl();
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FiltreControl::class,
            'teacher' => null
        ));
    }
}
