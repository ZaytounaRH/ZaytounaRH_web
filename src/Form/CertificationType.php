<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use App\Entity\Certification;
use App\Entity\Employee;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titreCertif', TextType::class, [
            'label' => 'Titre du certificat',
            'attr' => ['class' => 'form-control'],
            'required' => true, 
        ])
        ->add('organismeCertif', TextType::class, [
            'label' => 'Organisme',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('formation', EntityType::class, [
            'class' => Formation::class,
            'label' => 'Formation associée',
            'choice_label' => 'nomFormation',
            'placeholder' => '-- Choisir une formation --',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('employees', EntityType::class, [
            'class' => Employee::class,
            'label' => 'Employés certifiés',
            'choice_label' => function (Employee $e) {
                return $e->getUser()->getNom() . ' ' . $e->getUser()->getPrenom();
            },
            'multiple' => true,
            'expanded' => false,
            'attr' => ['class' => 'form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
