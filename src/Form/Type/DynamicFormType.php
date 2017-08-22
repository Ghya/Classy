<?php

namespace Classy\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DynamicFormType extends AbstractType
{
    protected $name;
    protected $items;

    public function getName() { return $this->name; }

    public function __construct($name, $items)
    {
        $this->name  = $name;
        $this->items = $items;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        foreach($this->items as $name => $item)
        {
            switch($item['type'])
            {
                case 'text':

                    $attr = array();

                    if (isset($item['size'])) $attr['size'] = $item['size'];

                    $builder->add($name,'text',array(
                        'label'    => $item['label'],
                        'required' => false,
                        'attr'     => $attr,
                    ));
                    break;

                case 'textarea':

                    $attr = array();

                    if (isset($item['rows'])) $attr['rows'] = $item['rows'];
                    if (isset($item['cols'])) $attr['cols'] = $item['cols'];

                    $builder->add($name,'textarea',array(
                        'label'    => $item['label'],
                        'required' => false,
                        'attr'     => $attr,
                    ));
                    break;
            }
        }
        return; if ($options);
    }
}