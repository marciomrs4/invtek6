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

class MovimentacoesReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dataMovimentacaoA',DateType::class,array('label'=>'Data da Movimentação: Inicio',
                'mapped'=>false,
                'widget'=>'single_text'))
            ->add('dataMovimentacaoB',DateType::class,array('label'=>'Data da Movimentação: Fim',
                'mapped'=>false,
                'widget'=>'single_text'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => \App\Entity\Movimentacao::class
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'report_movimentacoes';
    }
}
