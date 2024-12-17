<?php

namespace App\Form;

use App\Form\Listener\AddMotivoMovimentacao;
use App\Form\Listener\AddUsuarioDestinoMovimentacao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Movimentacao;

class MovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datahora', DateTimeType::class, array('label'=>'Data e Hora',
                'date_widget'=>'single_text',
                'time_widget'=>'single_text',
                ))
            ->add('usuarioOrigem',null,array('label'=>'Usuário Origem',
                'attr'=>array('class'=>'form-control')))
            ->add('usuarioDestino',null,array('label'=>'Usuário Destino',
                'attr'=>array('class'=>'form-control')))
            ->add('tipomovimentacao',null,array('label'=>'Tipo de Movimentacao',
                'placeholder'=>'Selecione',
                'attr'=>array('class'=>'form-control')))
            ->add('motivomovimentacao',null,array('label'=>'Motivo de Movimentacao',
                'attr'=>array('class'=>'form-control')))

        ;

        $builder->addEventSubscriber(new AddMotivoMovimentacao());
        //$builder->addEventSubscriber(new AddUsuarioDestinoMovimentacao());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Movimentacao::class
        ));
    }
}
