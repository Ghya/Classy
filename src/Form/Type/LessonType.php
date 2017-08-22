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
            ->add('title', TextType::class)
            ->add('situation', TextType::class)
            ->add('goal', TextAreaType::class)
            ->add('equipment', TextAreaType::class)
            ->add('skill', TextAreaType::class)
            ->add('time', TextType::class);
    }

    public function getName()
    {
        return 'Chapitre';
    }
}