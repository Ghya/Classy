<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre de la séance'
            ))
            ->add('situation', TextType::class, array(
                'label' => 'Situation dans l\'enseignement'
            ))
            ->add('goal', TextAreaType::class, array(
                'label' => 'Objectif(s)'
            ))
            ->add('equipment', TextType::class, array(
                'label' => 'Matériel'
            ))
            ->add('skill', TextAreaType::class, array(
                'label' => 'Compétence(s) visée(s)'
            ))
            ->add('time', TextType::class, array(
                'label' => 'Durée'
            ));
    }

    public function getName()
    {
        return 'Chapitre';
    }
}