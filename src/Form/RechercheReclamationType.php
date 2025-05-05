<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('incidentType', ChoiceType::class, [
                'label' => 'Type d\'incident',
                'required' => false,
                'choices' => [
                    'Accident de travail' => 'ACCIDENT_TRAVAIL',
                    'Maladie professionnelle' => 'MALADIE_PROFESSIONNELLE',
                    'Défaut de couverture' => 'DÉFAUT_COUVERTURE',
                    'Litige contrat' => 'LITIGE_CONTRAT',
                ],
                'placeholder' => 'Choisissez un type...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
