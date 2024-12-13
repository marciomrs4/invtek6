<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Equipamento;
use App\Entity\Fornecedor;
use App\Entity\Marca;
use App\Entity\Tipoequipamento;
use App\Entity\CentroMovimentacao;

class EquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome',TextType::class,array('label'=>'Nome',
                'attr'=>array('class'=>'form-control')))
            ->add('centroMovimentacao',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'form-control'),
                'class' => CentroMovimentacao::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.unidade')
                        ->addOrderBy('c.nome');
                },'placeholder' => ''))
            ->add('fornecedor',EntityType::class,array('label'=>'Fornecedor',
                'attr'=>array('class'=>'form-control'),
                'class' => Fornecedor::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.nome');
                },'placeholder' => ''))
            ->add('marca',EntityType::class,array('label'=>'Marca',
                'attr'=>array('class'=>'form-control'),
                'class' => Marca::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nome');
                },'placeholder'=>''))
            ->add('tipoequipamento',EntityType::class,array('label'=>'Tipo de Equipamento',
                'attr'=>array('class'=>'form-control'),
                'class'=> Tipoequipamento::class,
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.descricao');
                },'placeholder'=> ''))
            ->add('dataCompra',DateType::class,array('label'=>'Data da Compra',
                'widget'=>'single_text',
                'attr' => array('class'=>'form-control')))
            ->add('validade', DateType::class,array('label'=>'Vigência de Garantia',
                'widget'=>'single_text',
                'attr' => array('class'=>'form-control')))
            ->add('valorCompra', MoneyType::class, array('label' => 'Valor da Compra',
                'attr' => array('class' => 'form-control'),
                'currency' => 'BRL', 'scale' => 2))
            ->add('numeroserie',TextType::class,array('label'=>'Número de Série',
                'attr'=>array('class'=>'form-control')))
            ->add('status',CheckboxType::class,array('label'=>'Status',
                'label_attr' => [
                  'class' => 'form-check-label'  
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ]))
            ->add('patrimonio',TextType::class,array('label'=>'Patrimônio',
                'attr'=>array('class'=>'form-control')))
            ->add('descricao',TextType::class,array('label'=>'Descrição',
                'attr'=>array('class'=>'form-control')))
            ->add('observacao',TextareaType::class,array('label'=>'Observação',
                'attr'=>array('class'=>'form-control')))
            ->add('compradoPara',EntityType::class,array('label'=>'Comprado Para',
                'attr'=>array('class'=>'form-control'),
                'class' => CentroMovimentacao::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.unidade')
                        ->addOrderBy('c.nome');
                },'placeholder' => ''))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Equipamento::class
        ));
    }
}
