<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Tiposoftware;
use App\Entity\Software;
use App\Entity\FornecedorSoftware;

class SoftwareType extends AbstractType
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
            ->add('versao',null,array('label'=>'Versão',
                                           'attr'=>array('class'=>'form-control')))
            ->add('serial',null,array('label'=>'Serial',
                                           'attr'=>array('class'=>'form-control')))
            ->add('tiposoftware',EntityType::class,array('label'=>'Tipo de Software',
                                           'attr'=>array('class'=>'form-control'),
                'class' => Tiposoftware::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.descricao');
                },
                'placeholder'=>'Selecione'))
            ->add('fornecedor',EntityType::class,array('label'=>'Fornecedor',
                'attr'=>array('class'=>'form-control'),
                'class' => FornecedorSoftware::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.nome')
                        ->where('f.status = 1');
                },
                'placeholder'=>'Selecione'))
            ->add('numeroreserva',IntegerType::class,array('label'=>'Número de Reservas',
                'attr'=>array('class'=>'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Software::class
        ));
    }
}
