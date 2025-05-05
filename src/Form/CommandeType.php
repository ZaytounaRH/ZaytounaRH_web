<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
<<<<<<< HEAD
    {
        $builder
            ->add('dateCommande', null, [
                'widget' => 'single_text',
            ])
            ->add('quantite')
            ->add('statutCommande')
            ->add('idFournisseur')
            ->add('description')
            ->add('prixCommande')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }
=======
{
    $builder
        ->add('dateCommande', null, [
            'widget' => 'single_text',
        ])
        ->add('quantite')
        ->add('statutCommande')
        ->add('fournisseur', EntityType::class, [
            'class' => \App\Entity\Fournisseur::class,
            'choice_label' => 'nomFournisseur',
            'required' => true, 
            'placeholder' => 'Choisir un fournisseur', 
        ])
        ->add('description')
        ->add('prixCommande')
        ->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'id',
        ])
    ;
}

>>>>>>> origin/manel_gestion_financiere

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
