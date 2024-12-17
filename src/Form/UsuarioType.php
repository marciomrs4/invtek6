<?php

namespace App\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Usuario;
use App\Entity\CentroMovimentacao;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();

        $userId = null;
        if($data->getUserId()) {
            $userId = $data->getUserId()
                           ->getId();
        }

        $builder
            ->add('nomecompleto',null,array('label'=>'Nome Completo',
                'attr'=>array('class'=>'form-control')))
            ->add('nome',null,array('label'=>'Nome',
                'attr'=>array('class'=>'form-control')))
            ->add('numeroIdentificacao',TextType::class,array('label'=>'Número de Identificacao',
                'attr'=>array('class'=>'form-control')))
            ->add('departamento',EntityType::class,array('label'=>'Centro de Movimentação',
                'attr'=>array('class'=>'form-control'),
                'class' => CentroMovimentacao::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.unidade')
                        ->addOrderBy('c.nome');
                },'placeholder' => 'Selecione'))
//            ->add('user_id',EntityType::class,array('label'=>'Acesso',
//                'class' => 'App\Entity\User',
//                'query_builder' => function(EntityRepository $er) use ($userId){
//                    return $er->createQueryBuilder('u')
//                        ->leftJoin('u.usuario','usuario')
//                        ->where('usuario.user_id IS NULL')
//                        ->andWhere('u.isActive = true')
//                        ->orWhere('usuario.user_id = :user_id')
//                        ->setParameter('user_id',$userId)
//                        ->orderBy('u.username');
//                },'placeholder'=>'Nenhum'))
            ->add('status',CheckboxType::class,array('label'=>'Status',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'attr' => [
                    'class' => 'form-check-input',
                    'title' => 'Status'
                ]
                ))
            ->add('observacao',TextareaType::class,array('label'=>'Observação',
                'attr'=>array('class'=>'form-control')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Usuario::class
        ));
    }
}
