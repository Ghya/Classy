<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Titre de l\'étape'
            ))
            ->add('content', TextAreaType::class, array(
                'label' => 'Contenu de l\'étape'
            ))
            ->add('time', TextType::class, array(
                'label' => 'Durée éstimée'
            ));
    }

    public function getName()
    {
        return 'Etapes';
    }
}