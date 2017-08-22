<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class MarkType extends AbstractType {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {

        foreach($options['your_options'] as $key, $option) { //you can name $option as $filedName or whatever you find convenient
            $builder->add($option, $key.Type::class);
        }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'your_options' => null
        ])
    }
}

