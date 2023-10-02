<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Votre adresse e-mail',
            'attr' => ['class' => 'form-style size']
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'attr' => ['class' => 'form-style size']
        ])
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'attr' => ['class' => 'form-style size']
        ])

        ->add('message', TextareaType::class, [
            'attr' => ['class' => 'form-style-text size']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class'  => 'envoi btnb'
            ]
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
