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

class EquipamentoReportType extends AbstractType
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
            ->add('fornecedor',EntityType::class,array('label'=>'Fornecedor',
                'attr'=>array('class'=>'form-control'),
                'class'=> \App\Entity\Fornecedor::class,
                'placeholder'=>'Todos'))
            ->add('marca',EntityType::class,array('label'=>'Marca',
                'attr'=>array('class'=>'form-control'),
                'class'=> \App\Entity\Marca::class,
                'placeholder'=>'Todos'))
            ->add('patrimonio',TextType::class,array('label'=>'Patrimônio',
                'attr'=>array('class'=>'form-control')))
            ->add('dataCompraA',DateType::class,array('label'=>'Data da Compra: Inicio',
                'mapped'=>false,
                'widget'=>'single_text'))
            ->add('dataCompraB',DateType::class,array('label'=>'Data da Compra: Fim',
                'mapped'=>false,
                'widget'=>'single_text'))
            ->add('numeroserie',TextType::class,array('label'=>'Número de Série',
                'attr'=>array('class'=>'form-control')))
            ->add('status',ChoiceType::class,array('label'=>'Status',
                'choices'=>array('Todos'=>'','Ativo'=>'1','Inativo'=>'0'),
                'attr'=>array('class'=>'form-control')))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'form-control'),
                'class'=> \App\Entity\CentroMovimentacao::class,
                'placeholder'=>'Todos'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'MRS\InventarioBundle\Entity\Equipamento'
//        ));
    }

    public function getBlockPrefix(): string
    {
        return 'report_equipamentos';
    }
}
