<?php

namespace App\Form\Report;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcompanhamentoReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipoequipamento',EntityType::class,array('label'=>'Tipo de Equipamento',
                'attr'=>array('class'=>'form-control'),
                'class' => \App\Entity\Tipoequipamento::class,
                'placeholder'=>'Todos'))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'form-control'),
                'class'=> \App\Entity\CentroMovimentacao::class,
                'placeholder'=>'Todos'))
        ;
    }


    public function getBlockPrefix(): string
    {
        return 'report_acompanhamento';
    }
}
