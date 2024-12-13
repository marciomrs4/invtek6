<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\AnexoAcompanhamento;

class AnexoAcompanhamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dataCriacao',DateTimeType::class,array('label'=>'Data de Criação',
                'attr' => [
                    'class' => 'form-control'
                ],
                'date_widget'=>'single_text',
                'time_widget' =>'single_text'))
            ->add('image_file',FileType::class,array('label'=>'Anexo',
                 'attr' => [
                    'class' => 'form-control'
                ],))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => AnexoAcompanhamento::class
        ));
    }
}
