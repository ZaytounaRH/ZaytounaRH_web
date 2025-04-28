<?php

namespace App\Form;

use App\Entity\Assurance;
use App\Entity\Reclamation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('incidentType')
            ->add('dateSoumission', null, [
                'widget' => 'single_text',
            ])
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'En_attente' =>'EN_ATTENTE',
                    'En_cours' => 'EN_COURS' ,
                    'Resolu'=>'RESOLU'
            



                ],
                'label' => 'Type'
            ])
            ->add('priorite', ChoiceType::class,[
                'choices' =>[
                    'Faible' =>'FAIBLE',
                    'Moyenne' => 'MOYENNE' ,
                    'Elevee'=>'ELEVEE'
            



                ],
                'label' => 'Type'
            ])
            ->add('pieceJointe')
            ->add('assurance', EntityType::class, [
                'class' => Assurance::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
