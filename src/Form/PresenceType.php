<?php

namespace App\Form;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
use App\Entity\Employee;
use App\Entity\Presence;
use App\Entity\Rh;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
<<<<<<< HEAD
=======
use App\Entity\Presence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
>>>>>>> origin/ons_gestion_recrutement
=======
use App\Entity\Presence;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('heureArrive', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', null, [
                'widget' => 'single_text',
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
    {
        $builder
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => function (Employee $employee) {
                    $user = $employee->getUser(); // ⚠️ adapte ceci à ta relation réelle
                    return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'Employé inconnu';
                },
                'label' => 'Employé',
            ]);

        if ($options['is_edit']) {
            $builder->add('heureDepart', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ]);
        }
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presence::class,
<<<<<<< HEAD
<<<<<<< HEAD
        ]);
    }
}
=======
{
    // champs visibles dans tous les cas
    $builder
        ->add('employee') // ou autre
        // ... les autres champs communs
    ;

    if ($options['is_edit']) {
        $builder->add('heureDepart', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
            'widget' => 'single_text',
            'required' => false,
        ]);
    }
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Presence::class,
        'is_edit' => false, // valeur par défaut
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
