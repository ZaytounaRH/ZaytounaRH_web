<?php
<<<<<<< HEAD

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
=======
// src/Form/ProduitType.php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
>>>>>>> origin/manel_gestion_financiere
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produitName')
<<<<<<< HEAD
            ->add('prix')
            ->add('nomFournisseur')
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'id',
            ])
        ;
=======
            ->add('prix', NumberType::class, [
                'scale' => 2,  // Nombre de décimales
                'grouping' => true,  // Pour activer les séparateurs de milliers si nécessaire
                'attr' => ['step' => '0.01'],  // Pour garantir que ce soit un nombre valide avec 2 décimales
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nomFournisseur',
            ]);
>>>>>>> origin/manel_gestion_financiere
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
