<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheAssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeAssurance', ChoiceType::class, [
                'label' => 'Type d\'Assurance',
                'required' => false,
                'choices' => [
                    'SANTÉ' => 'SANTE',
                    'ACCIDENT TRAVAIL' => 'ACCIDENT_TRAVAIL',
                    'VIE' => 'VIE',
                    'RESPONSABILITÉ CIVILE' => 'RESPONSABILITE_CIVILE',
                ],
                'placeholder' => 'Choisissez un type...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
