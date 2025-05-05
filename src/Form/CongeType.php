<?php

namespace App\Form;

use App\Entity\Conge;
use App\Entity\Employee;
use App\Entity\Rh;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champs de base
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('motif');

        // ✅ Champ "statut" uniquement en mode édition
        if ($options['is_edit']) {
            $builder->add('statut', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'ENATTENTE',
                    'Accepté' => 'ACCEPTE',
                    'Refusé' => 'REFUSE'
                ],
                'label' => 'Statut'
            ]);
        }

        // ✅ Champ employé
        $builder->add('employee', EntityType::class, [
            'class' => Employee::class,
            'choice_label' => function (Employee $employee) {
                $user = $employee->getUser(); // si Employee hérite de User
                return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'Inconnu';
            },
            'label' => 'Employé',
        ]);
        

        // ✅ Champ RH (lié à l'entité Rh)
        $builder->add('rh', EntityType::class, [
            'class' => Rh::class,
            'choice_label' => function (Rh $rh) {
                $user = $rh->getUser();
                return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'RH inconnu';
            },
            'label' => 'Responsable RH'
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
            'is_edit' => false,
        ]);
    }
}