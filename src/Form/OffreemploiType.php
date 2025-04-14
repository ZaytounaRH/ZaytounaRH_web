<?php

namespace App\Form;

use App\Entity\Offreemploi;
use App\Entity\Rh;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffreemploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreOffre')
            ->add('description')
            ->add('datePublication', null, [
                'widget' => 'single_text',
            ])
            ->add('salaire')
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'Ouverte' =>'OUVERTE',
                    'Fermee' => 'FERMEE' ,
                    'Pourvue'=>'POURVUE',
                    'Annulee'=>'ANNULEE',
                    'Encours'=>'ENCOURS'



                ],
                'label' => 'Type'
            ])
            ->add('rh', EntityType::class, [
                'class' => Rh::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offreemploi::class,
        ]);
    }
}
