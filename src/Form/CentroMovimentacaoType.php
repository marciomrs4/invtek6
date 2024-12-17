<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\CentroMovimentacao;
use App\Entity\Unidade;

class CentroMovimentacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome',null,array('label'=>'Nome',
                'attr'=>array('class'=>'form-control')))
            ->add('tempoPrevencao',IntegerType::class,array('label'=>'Preventiva - ( em meses )',
                'attr'=>array('class'=>'form-control')))
            ->add('unidade',EntityType::class,array('label'=>'Unidade',
                'attr'=>array('class'=>'form-control'),
                'class' => Unidade::class ,
                'query_builder' =>    function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nome');

                },
                'placeholder'=>'Selecione'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => CentroMovimentacao::class
        ));
    }
}
