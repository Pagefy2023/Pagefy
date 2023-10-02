<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Chapitre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_chapitre', TextType::class, [
                'attr' => ['class' => 'form-style-new'],
            ])
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'form-style-new'],
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => ['class' => 'form-style-new'],
            ])
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'attr' => ['class' => 'form-style-new']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chapitre::class,
        ]);
    }
}
