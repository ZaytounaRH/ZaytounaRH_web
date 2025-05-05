<?php

namespace App\Form;

use App\Entity\Assurance;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class AssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type',ChoiceType::class,[
                'choices' =>[
                    'Sante' =>'SANTE',
                    'Accident_travail' => 'ACCIDENT_TRAVAIL' ,
                    'Vie'=>'VIE',
                    'Responsabilite_civile' => 'RESPONSABILITE_CIVILE' 


                ],
                'label' => 'Type'])
                ->add('dateExpiration', DateType::class, [
                    'widget' => 'single_text', // Affichage sous forme de champ de saisie unique
                    'label' => 'Date d\'expiration',
                ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getNom() . ' ' . $user->getPrenom(); // Affiche Nom + Prénom
                },
                'placeholder' => 'Sélectionnez un utilisateur',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}
