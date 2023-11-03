<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //formulaire de validateion d'email
        ->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer une adresse e-mail.',
                ]),
                new Email([
                    'message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.',
                ]),
            ],
            'attr' => [
                'class' => 'form-style-email',
            ],
        ])
        
        ->add('nom', TextType::class,[
            'attr' => [
                'class' => 'form-style-email'
            ]
        ])
        ->add('prenom', TextType::class,[
            'attr' => [
                'class' => 'form-style-email'
            ]
        ])
        //formulaire de validateion de mot de passe
            
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
            'options' => ['attr' => ['class' => 'form-style-pass', 'autocomplete' => 'new-password', 'id' => 'inputPasswordR']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Répétez le mot de passe'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un mot de passe.',
                ]),
                new Length([
                    'min' => 12, // Longueur minimale de 12 caractères
                    'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères,',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
                new Regex([
                    'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W)/', // Au moins une majuscule, un chiffre, et un caractère spécial
                    'message' => ' une lettre majuscule,une lettre minuscule, un chiffre et un caractère spécial.',
                ]),
            ],
        ])

        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false, 
            'constraints' => [
                new IsTrue([
                    'message' => 'Vous devez accepter les termes et conditions.',
                ]),
            ],
            'label' => 'J\'accepte les termes et conditions', 
        ]);
            
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
