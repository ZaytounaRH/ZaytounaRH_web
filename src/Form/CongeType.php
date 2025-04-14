<?php

namespace App\Form;

use App\Entity\Conge;
use App\Entity\Employee;
use App\Entity\Rh;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
 
class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('motif')
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'En_attente' =>'ENATTENTE',
                    'Accepte' => 'ACCEPTE' ,
                    'Refuse'=>'REFUSE'

                ],
                'label' => 'Type'
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
