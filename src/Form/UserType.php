<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numTel')
            ->add('joursOuvrables')
            ->add('nom')
            ->add('prenom')
            ->add('address')
            ->add('email')
            ->add('gender')
            ->add('dateDeNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('user_type', ChoiceType::class,[
                'choices' =>[
                    'Rh' =>'RH',
                    'Candidat' => 'CANDIDAT' ,
                    'Employee'=>'EMPLOYEE'
                ],
                'label' => 'Type'
            ])
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
