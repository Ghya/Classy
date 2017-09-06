<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lvl', ChoiceType::class, array(
                "choices" => array(
                    "Petite Setion" => "Petite Section",
                    "Moyenne Setion" => "Moyenne Section",
                    "Grande Setion" => "Grande Section",
                    "CP" => "CP",
                    "CE1" => "CE1",
                    "CE2" => "CE2",
                    "CM1" => "CM1",
                    "CM2" => "CM2"
                )
                
            ))

            ->add('zone', ChoiceType::class, array(
                "choices" => array(
                    "A" => "A",
                    "B" => "B",
                    "C" => "C"
                )
                
            ))

            ->add('etab', TextType::class);
    }

    public function getName()
    {
        return 'Classe';
    }
}