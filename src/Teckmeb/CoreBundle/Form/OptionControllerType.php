<?php

namespace Teckmeb\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OptionControllerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $listController = $event->getData();
                if (null === $listController) {
                    return;
                }
                for ($i = 0; $i < count($listController->listOption); $i++) {
                    $event->getForm()->add('value' . $i, TextType::class, array(
                        "attr" => array("class" => "tooltipped", "data-position" => "top", "data-tooltip" => $listController->listOption[$i]->getTips()),
                        'label' => "Valeur",
                    ));
                }
            }
        );
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Teckmeb\ModuleBundle\Model\ListOption'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'teckmeb_corebundle_optioncontroller';
    }
}
