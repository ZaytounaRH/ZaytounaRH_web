<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Entretien;
use App\Entity\Offreemploi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEntretien', null, [
                'widget' => 'single_text',
            ])
            ->add('heureEntretien', null, [
                'widget' => 'single_text',
            ])
            ->add('typeEntretien', ChoiceType::class,[
                'choices' =>[
                    'Presentiel' =>'PRESENTIEL',
                    'Distanciel' => 'DISTANCIEL' ,
                    'Telephonique'=>'TELEPHONIQUE'

                ],
                'label' => 'Type'
            ])
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'Planifie' =>'PLANIFIE',
                    'En_cours' => 'EN_COURS' ,
                    'Termine'=>'TERMINE',
                    'Annule'=>'ANNULE'



                ],
                'label' => 'Type'
            ])
            ->add('commentaire')
            ->add('candidat', EntityType::class, [
                'class' => Candidat::class,
                'choice_label' => 'id',
            ])
            ->add('offreemploi', EntityType::class, [
                'class' => Offreemploi::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entretien::class,
        ]);
    }
}
