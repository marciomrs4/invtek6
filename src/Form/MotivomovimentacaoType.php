<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Motivomovimentacao;

class MotivomovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao',null,array('label'=>'Descrição',
                                           'attr'=>array('class'=>'form-control')))
            ->add('tipomovimentacao',null,array('label'=>'Tipo de movimentação',
                                           'attr'=>array('class'=>'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Motivomovimentacao::class
        ));
    }
}