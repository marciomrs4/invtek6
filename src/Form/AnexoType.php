<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Anexo;

class AnexoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image_file',FileType::class,array('label'=>'Arquivo',
                  'attr'=>array('class'=>'form-control')))
            ->add('nome',null,array('label'=>'Nome',
                  'attr'=>array('class'=>'form-control')))
            ->add('datacriacao',DateTimeType::class,array('label'=>'Data de Criação',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Anexo::class
        ));
    }
}
