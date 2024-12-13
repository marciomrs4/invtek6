<?php

namespace App\Form\Report;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Tipoequipamento;
use App\Entity\CentroMovimentacao;

class EquipamentoChartType extends AbstractType
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
                'class' => Tipoequipamento::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('T')
                        ->orderBy('T.descricao');
                },'placeholder'=>'Todos'))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'form-control'),
                'class'=> CentroMovimentacao::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('C')
                        ->orderBy('C.nome');
                },'placeholder'=>'Todos'))
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

    public function getBlockPrefix()
    {
        return 'chart_equipamentos';
    }
}
