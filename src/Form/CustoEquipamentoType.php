<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\CustoEquipamento;

class CustoEquipamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valor', MoneyType::class, array('label' => 'Valor',
                'attr' => array('class' => 'form-control'),
                'currency' => 'BRL', 'scale' => 2))
            ->add('data_criacao', DateType::class, array('label' => 'Data Lançamento',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control')))
            ->add('descricao', null, array('label' => 'Descrição',
                'attr' => array('class' => 'form-control')));


        $builder->get('valor')
            ->addModelTransformer(new CallbackTransformer(
                function($valor){
                    return $valor; //number_format($valor,2,',','.');
                },
                function($valor){
                    return $valor;
                }
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => CustoEquipamento::class
        ));
    }
}
