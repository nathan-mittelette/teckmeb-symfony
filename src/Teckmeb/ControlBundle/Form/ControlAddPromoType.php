<?php

namespace Teckmeb\ControlBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Teckmeb\CoreBundle\Form\EducationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Teckmeb\CoreBundle\Repository\PromoRepository;


class ControlAddPromoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->teacher = $options['teacher'];
        $teacher = $this->teacher;
        $builder
            ->remove('education')
            ->add('promo', EntityType::class, array(
            'class'        => 'TeckmebCoreBundle:Promo',
            'choice_label' => 'promoName',
            'multiple'     => false,
            'query_builder' => function(PromoRepository $repository) use($teacher) {
                return $repository->getPromoTeacher($teacher);}
            ));   
    }
    public function getParent()
    {
        return ControlType::class;
    }
}