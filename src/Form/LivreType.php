<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Entity\Bibliotheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // formulaire d'ajout de nouveau livre
        $builder
    ->add('titre', TextType::class, [
        'attr' => ['class' => 'form-style-new'],
    ])
    ->add('auteur', EntityType::class, [
        'class' => Auteur::class,
        'choice_label' => 'nom',
        'attr' => ['class' => 'form-style-new']
    ])
    ->add('categorie', EntityType::class, [
        'class' => Categorie::class,
        'choice_label' => 'nom',
        'attr' => [
            'class' => 'form-style-new'
        ],
    ])
    ->add('resume', TextareaType::class, [
        'attr' => ['class' => 'form-style-new'],
    ])
    ->add('couverture', FileType::class, [
        'attr' => ['class' => 'form-style-new'],
        'data_class' => null, // Permet de traiter la valeur comme une chaîne de caractères
    ])
    
    ->add('date_parution', DateType::class, [
        'widget' => 'single_text',
        'attr' => ['class' => 'form-style-new'],
    ])
    ->add('editeur', TextType::class, [
        'attr' => ['class' => 'form-style-new'],
    ])
    ->add('extrait', TextType::class, [
        'attr' => ['class' => 'form-style-new'],
    ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,

        ]);
    }
}
