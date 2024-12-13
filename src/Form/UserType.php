<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',null,array('label'=>'Usuário',
                'attr'=>array('class'=>'form-control')))
            ->add('roles',TextType::class,array('label'=>'Permissões',
                'attr'=>array('class'=>'form-control')))
            ->add('password', PasswordType::class,array('label'=>'Senha',
                'attr'=>array('class'=>'form-control')))
            ->add('passwordRepet', PasswordType::class,array('label'=>'Repetir Senha',
                'attr'=>array('class'=>'form-control')))
        ;
        
        $builder->get('roles')
            ->addModelTransformer(new \Symfony\Component\Form\CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return json_encode($tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return json_decode($tagsAsString);
                }
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
