<?php

namespace App\Form;

use App\Entity\Assurance;
use App\Entity\Reclamation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('incidentType', ChoiceType::class, [
                'choices' => [
                    'Accident de travail' => 'ACCIDENT_TRAVAIL',
                    'Maladie professionnelle' => 'MALADIE_PROFESSIONNELLE',
                    'Défaut de couverture' => 'DÉFAUT_COUVERTURE',
                    'Litige de contrat' => 'LITIGE_CONTRAT',
                ],
                'label' => 'Type d\'incident'
            ])
            ->add('dateSoumission', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de soumission',
                'disabled' => true, // Empêche la modification
                'data' => new \DateTimeImmutable(), // Valeur par défaut affichée
                'mapped' => false, // IMPORTANT : évite d’écraser la valeur fixée côté contrôleur
            ])
            ->add('statut', TextType::class, [
                'label' => 'Statut',
                'disabled' => true,       // l'utilisateur ne peut pas le modifier
                'data' => 'EN_ATTENTE',   // valeur affichée par défaut
                'mapped' => false,        // ne pas lier à l'entité (on gère dans le contrôleur)
            ])
            ->add('priorite', ChoiceType::class, [
                'choices' => [
                    'Faible' => 'FAIBLE',
                    'Moyenne' => 'MOYENNE',
                    'Élevée' => 'ELEVEE'
                ],
                'label' => 'Priorité'
            ])
            ->add('assurance', EntityType::class, [
                'class' => Assurance::class,
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
