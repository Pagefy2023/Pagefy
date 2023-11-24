<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prenom')
        ->add('nom')
        ->add('Roles', ChoiceType::class, [
            'required' => true,
            'multiple' => true,
            'expanded' => true,
            'choices'  => [
              'User' => 'ROLE_USER',
              'Admin' => 'ROLE_ADMIN',
              'Moderator' => "ROLE_MODERATOR"
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
