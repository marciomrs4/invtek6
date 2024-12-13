<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\TipoAcessoIp;
use App\Entity\StatusIp;
use App\Entity\EnderecoIp;

class EnderecoIpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('enderecoIp',null,array('label'=>'Endereço IP',
                'attr'=>array('class'=>'form-control')))
            ->add('nome',null,array('label'=>'Host Name',
                'attr'=>array('class'=>'form-control',
                    'data-behavior'=>'uppercase')));
/*
        $builder->get('nome',null,array('label'=>'Host Name',
            'attr'=>array('class'=>'form-control',
                'data-behavior'=>'uppercase')))
            ->addModelTransformer(new CallbackTransformer(
                function($toUpperCase){
                    return strtoupper($toUpperCase);
                },
                function($toUpperCase){
                    return strtoupper($toUpperCase);
                }
            ));
*/
        
        $builder->add('observacao',TextareaType::class,array('label'=>'Observação',
            'attr'=>array('class'=>'form-control')))
            ->add('tipoAcessoIp',EntityType::class,array('label'=>'Tipo de Acesso',
                'attr'=>array('class'=>'form-control'),
                'class' => TipoAcessoIp::class))
            ->add('status',EntityType::class,array('label'=>'Status',
                'attr'=>array('class'=>'form-control'),
                'class' => StatusIp::class))
            ->add('unidade',null,array('label'=>'Unidade',
                'attr' => array('class' => 'form-control')))
            ->add('doPing', CheckboxType::class,array('label'=>'Faz Ping ?',
                'label_attr' => [
                  'class' => 'form-check-label'  
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ]
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => EnderecoIp::class
        ));
    }
}
