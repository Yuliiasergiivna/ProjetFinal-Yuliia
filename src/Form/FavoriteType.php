<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FavoriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('attraction', EntityType::class, [
                'class' => Attraction::class,
                'choice_label' => 'name',
                'label' => 'Attraction',
                'required' => true,
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'email',
                'label' => 'Utilisateur',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Favorite',
        ]);
    }
}
