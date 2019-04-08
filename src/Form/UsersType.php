<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => false,'attr' => ['placeholder' => "Username"]])
            ->add('name', TextType::class, ['label' => false,'attr' => ['placeholder' => "Name"]])
            ->add('surname', TextType::class, ['label' => false,'attr' => ['placeholder' => "Surname"]])
            ->add('age', NumberType::class, ['label' => false,'attr' => ['placeholder' => "Age"]])
            ->add('email', TextType::class, ['label' => false,'attr' => ['placeholder' => "Adresse Email"]])
            ->add('password', PasswordType::class, ['label' => false,'attr' => ['placeholder' => "Mot de passe"]])
            ->add('confirm_password', PasswordType::class, ['label' => false,'attr' => ['placeholder' => "Confirmation Mot de passe "]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
