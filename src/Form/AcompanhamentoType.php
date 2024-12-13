<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Acompanhamento;

class AcompanhamentoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descricao',null,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'form-control')))
            ->add('datahora',DateTimeType::class,array('label'=>'Data e Hora',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'))
            ->add('tipoacompanhamento',null,array('label'=>'Tipo de Acompanhamento',
                                           'attr'=>array('class'=>'form-control')))
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acompanhamento::class
        ]);
    }
}
