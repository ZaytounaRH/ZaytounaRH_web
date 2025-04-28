<?php

namespace App\Form;

use App\Entity\Presence;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presence::class,
            'is_edit' => false,
        ]);
    }
}
