<?php

namespace Teckmeb\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Teckmeb\CoreBundle\Form\GroupeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GroupeForSemestreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('semestre')
            ;   
    }
    
    public function getParent()
    {
        return GroupeType::class;
    }
}