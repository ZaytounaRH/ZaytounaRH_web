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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
 
=======

>>>>>>> origin/ons_gestion_recrutement
=======

>>>>>>> origin/asma_gestion_presence
=======
 
>>>>>>> origin/manel_gestion_financiere
class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
        // Champs de base
>>>>>>> origin/ons_gestion_recrutement
=======
        // Champs de base
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
            ->add('motif')
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'En_attente' =>'ENATTENTE',
                    'Accepte' => 'ACCEPTE' ,
                    'Refuse'=>'REFUSE'

                ],
                'label' => 'Type'
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'id',
            ])
            ->add('rh', EntityType::class, [
                'class' => Rh::class,
                'choice_label' => 'id',
            ])
        ;
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence
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
<<<<<<< HEAD
            'choice_label' => 'id',
        ]);
=======
            'choice_label' => function (Employee $employee) {
                $user = $employee->getUser(); // si Employee hérite de User
                return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'Inconnu';
            },
            'label' => 'Employé',
        ]);
        
>>>>>>> origin/asma_gestion_presence

        // ✅ Champ RH (lié à l'entité Rh)
        $builder->add('rh', EntityType::class, [
            'class' => Rh::class,
            'choice_label' => function (Rh $rh) {
                $user = $rh->getUser();
                return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'RH inconnu';
            },
            'label' => 'Responsable RH'
        ]);
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
        
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        ]);
    }
}
=======
            'is_edit' => false,
        ]);
    }
}
>>>>>>> origin/ons_gestion_recrutement
=======
            'is_edit' => false,
        ]);
    }
}
>>>>>>> origin/asma_gestion_presence
=======
        ]);
    }
}
>>>>>>> origin/manel_gestion_financiere
