<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, array(
                'label' => 'Domaine'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Programmation'
            ));
    }

    public function getName()
    {
        return 'Prog';
    }
}
