<?php

namespace App\Form;

use App\Entity\Offreemploi;
use App\Entity\Rh;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OffreemploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreOffre')
            ->add('description')
            


            ->add('datePublication', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'offre',
                'required' => true,
                'empty_data' => (new \DateTime())->format('Y-m-d'),
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
                'class' => RH::class,
                'choice_label' => function (Rh $candidat) {
                    $user = $candidat->getUser();
                    return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'RH inconnu';
                },
                'placeholder' => 'un seul RH',
                'label' => 'RH',
                'required' => true,
            ])
            
            ->add('image', TextType::class, [
              'required' => false,
              'label' => 'Image (URL ou nom du fichier)'
                 ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offreemploi::class,
        ]);
    }
}
