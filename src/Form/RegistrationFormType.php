<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
        ->add('username', TextType::class, [
            'label' => 'Nom d’utilisateur',
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le nom d’utilisateur est requis.']),
                new Assert\Length(['max' => 180]),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'constraints' => [
                new Assert\NotBlank(['message' => 'L’email est requis.']),
                new Assert\Email(['message' => 'Veuillez entrer un email valide.']),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'label' => 'Mot de passe',
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le mot de passe est requis.']),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}