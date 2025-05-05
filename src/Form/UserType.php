<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numTel', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\Length([
                        'min' => 8,
                        'max' => 8,
                        'exactMessage' => 'Phone number must be 8 digits long.'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Phone number must contain only digits.'
                    ])
                ]
            ])
            ->add('joursOuvrables', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Last name must contain only letters.'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'First name must contain only letters.'
                    ])
                ]
            ])
            ->add('address', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email should not be blank.'
                    ]),
                    new Assert\Email([
                        'message' => 'The email {{ value }} is not a valid email.'
                    ])
                ]
            ])
            ->add('gender', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateDeNaissance', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('user_type', ChoiceType::class, [
                'choices' => [
                    'Rh' => 'RH',
                    'Candidat' => 'CANDIDAT',
                    'Employee' => 'EMPLOYEE'
                ],
                'label' => 'Type',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Password should not be blank.'
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Password must be at least 6 characters long.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}