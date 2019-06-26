<?php

namespace Teckmeb\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Teckmeb\CoreBundle\Repository\TeacherRepository;

class EducationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->subject = $options['subject'];
        $subject = $this->subject;
        $builder
            ->add('teacher', EntityType::class, array(
            'class'        => 'TeckmebCoreBundle:Teacher',
            'multiple'     => false,
            'query_builder' => function(TeacherRepository $repository) use($subject) {
          return $repository->myFindTeacherBySubject($subject);}
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\CoreBundle\Entity\Education',
            'subject' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_corebundle_education';
    }


}
