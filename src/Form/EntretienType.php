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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateEntretien', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date de l\'entretien',
            'required' => true,
            'empty_data' => '',
           
        ])
        ->add('heureEntretien', TimeType::class, [
            'widget' => 'single_text',
            'label' => 'Heure de l\'entretien',
            'required' => true,
            'input' => 'datetime', // Symfony stockera en tant que \DateTime
            'empty_data' => '', // Laisse vide si non rempli
            
        ])
        
            ->add('typeEntretien', ChoiceType::class, [
                'label' => 'Type d\'entretien',
                'choices' => [
                    'Présentiel' => 'PRESENTIEL',
                    'Distanciel' => 'DISTANCIEL',
                    'Téléphonique' => 'TELEPHONIQUE',
                ],
                'placeholder' => 'Choisir un type',
                'required' => true,
            ])


            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Planifié' => 'PLANIFIE',
                    'En cours' => 'EN_COURS', // ✅ corrigé ici
                    'Terminé' => 'TERMINE',
                    'Annulé' => 'ANNULE'
                ],
                'label' => 'Statut'
                
            ])
            


    

            ->add('commentaire')
            ->add('candidat', EntityType::class, [
                'class' => Candidat::class,
                'choice_label' => function (Candidat $candidat) {
                    $user = $candidat->getUser();
                    return $user ? $user->getPrenom() . ' ' . $user->getNom() : 'Candidat inconnu';
                },
                'placeholder' => 'Choisir un candidat',
                'label' => 'Candidat',
                'required' => true,
            ])

            ->add('offreemploi', EntityType::class, [
                'class' => Offreemploi::class,
                'choice_label' => 'titreOffre', // Afficher le titre de l'offre d'emploi
                'label' => 'Offre d\'emploi', // Optionnel, mais utile pour la lisibilité
            ])
            ;    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entretien::class,
        ]);
    }
}
