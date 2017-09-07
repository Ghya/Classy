<?php

namespace Classy\Form\Type;

use Classy\Domain\L_Test;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class L_TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',  Texttype::class, array(
                'label' => 'Nom de l\'évaluation'
            ));
        
        $builder->add('marks', CollectionType::class, array(
            'entry_type' => L_MarkType::class
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => L_Test::class,
        ));
    }

    public function getName()
    {
        return 'L_Test';
    }
}