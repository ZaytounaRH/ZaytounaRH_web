<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<<<<<<< HEAD
=======
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
>>>>>>> origin/manel_gestion_financiere

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('nomFournisseur')
            ->add('adresse')
            ->add('contact')
            ->add('typeService')
=======
            ->add('nomFournisseur', TextType::class, [
                'label' => 'Nom du fournisseur',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom du fournisseur'
                ]
            ])
            ->add('adresse', TextareaType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'placeholder' => 'Entrez l\'adresse complète'
                ]
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Téléphone/Email du contact'
                ]
            ])
            ->add('typeService', ChoiceType::class, [
                'label' => 'Type de service',
                'choices' => [
                    'Transport' => 'TRANSPORT',
                    'Banque' => 'BANK',
                    'Électronique' => 'ELECTRONIQUE',
                    'Nourriture' => 'NOURRITURE',
                    'Informatique' => 'INFORMATIQUE',
                    'Meuble' => 'MEUBLE',
                ],
                'placeholder' => 'Sélectionnez un type',
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
>>>>>>> origin/manel_gestion_financiere
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/manel_gestion_financiere
