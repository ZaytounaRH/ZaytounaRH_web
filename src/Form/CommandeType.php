<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Fournisseur;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateCommande', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd', // si nécessaire
                'constraints' => [
                    new NotNull(['message' => 'La date de commande est obligatoire.']),
                ],
            ])
            ->add('quantite', null, [
                'constraints' => [
                    new NotNull(['message' => 'La quantité est obligatoire.']),
                    new Positive(['message' => 'La quantité doit être un nombre positif.']),
                    new Type(['type' => 'integer', 'message' => 'La quantité doit être un nombre entier.']),
                ],
            ])
            ->add('statutCommande', ChoiceType::class, [
                'label' => 'statut commande',
                'choices' => [
                    'En attente' => 'En attente',
                    'Accepté' => 'Accepté',
                    'Annulée' => 'Annulée',
                ],
                'placeholder' => 'Sélectionnez un statut',
                'required' => true, // Le statut est requis
                'attr' => [
                    'class' => 'form-select'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le statut de la commande est obligatoire.']),
                ],
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nomFournisseur',
                'required' => true,
                'placeholder' => 'Choisir un fournisseur',
                'constraints' => [
                    new NotNull(['message' => 'Le fournisseur est obligatoire.']),
                ],
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank(['message' => 'La description est obligatoire.']),
                ],
            ])
            ->add('prixCommande', NumberType::class, [
                'attr' => ['step' => '0.01'], // Permet d'accepter les décimales
                'required' => true,
                'constraints' => [
                    new NotNull(['message' => 'Le prix de la commande est obligatoire.']),
                    new Positive(['message' => 'Le prix doit être un nombre positif.']),
                    new Type(['type' => 'numeric', 'message' => 'Le prix doit être un nombre valide.']),
                ],
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id', // Utilise 'id' si tu veux seulement l'ID
                'required' => true,
                'constraints' => [
                    new NotNull(['message' => 'Le responsable est obligatoire.']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}