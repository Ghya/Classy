<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, array(
                'choices'  => array(
                    'Masculin' => '1',
                    'Féminin' => '2'),
                'label' => 'Sexe'
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom de l\'élève'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom de l\'élève'
            ))
            ->add('birth', TextType::class, array(
                'label' => 'Date de naissance'
            ))
            ->add('momName', TextType::class, array(
                'label' => 'Nom complet de la mère'
            ))
            ->add('dadName', TextType::class, array(
                'label' => 'Nom complet du père'
            ))
            ->add('tel', TextType::class, array(
                'label' => 'Téléphone des parents'
            ))
            ->add('adress', TextType::class, array(
                'label' => 'Adresse des parents'
            ))
            ->add('cp', NumberType::class, array(
                'label' => 'Code Postal'
            ))
            ->add('city', TextType::class, array(
                'label' => 'Ville'
            ))
            ->add('prevEtab', TextType::class, array(
                'label' => 'Etablissement précédent',
                'required' => false
            ))
            ->add('ppre', CheckboxType::class, array(
                'label' => 'PPRE',
                'required' => false
            ))
            ->add('rased', CheckboxType::class, array(
                'label' => 'RASED',
                'required' => false
            ))
            ->add('pai', CheckboxType::class, array(
                'label' => 'PAI',
                'required' => false
            ))
            ->add('apc', CheckboxType::class, array(
                'label' => 'APC',
                'required' => false
            ))
            ->add('ppreNote', TextType::class, array(
                'label' => 'Note sur le PPRE',
                'required' => false
            ))
            ->add('rasedNote', TextType::class, array(
                'label' => 'Note sur le RASED',
                'required' => false
            ))
            ->add('paiNote', TextType::class, array(
                'label' => 'Note sur le PAI',
                'required' => false
            ))
            ->add('apcNote', TextType::class, array(
                'label' => 'Note sur l\'APC',
                'required' => false
            ))
            ->add('coop', CheckboxType::class, array(
                'label' => 'Coopérative',
                'required' => false
            ))
            ->add('coll', CheckboxType::class, array(
                'label' => 'Gouter collectif',
                'required' => false
            ))
            ->add('note', TextAreaType::class, array(
                'label' => 'Remarque sur l\'élève',
                'required' => false
            ));
    }

    public function getName()
    {
        return 'Student';
    }
}