<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\Photo;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de la photo',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Fichier image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF, WEBP)',
                    ])
                ],
            ])
            // ->add('dateUpload', null, [
            //     'label' => 'Date de téléchargement',
            //     'widget' => 'single_text',
            // ])
            ->add('attraction', EntityType::class, [
                'class' => Attraction::class,
                'choice_label' => 'name',
                'label' => 'Attraction',
                'required' => false,
            ])
            // ->add('utilisateur', EntityType::class, [
            //     'class' => Utilisateur::class,
            //     'choice_label' => 'email',
            //     'label' => 'Utilisateur',
            //     'required' => false,
            // ])
            // ->add('save', SubmitType::class, [
            //     'label' => 'Enregistrer',
            //     'attr' => [
            //         'class' => 'btn btn-primary mt-3',
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
