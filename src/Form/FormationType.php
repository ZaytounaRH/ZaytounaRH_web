<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomFormation')
            ->add('descriptionFormation')
            ->add('dateDebutFormation', null, [
                'widget' => 'single_text',
                'empty_data' => null,
            ])
            ->add('dateFinFormation', null, [
                'widget' => 'single_text',
                'empty_data' => null,
            ])
            ->add('employees', EntityType::class, [
                'class' => Employee::class,
                'label' => 'Employés concernés',
                'choice_label' => function (Employee $employee) {
                    return $employee->getUser()->getNom() . ' ' . $employee->getUser()->getPrenom();
                },
                'multiple' => true,
                'expanded' => false, 
                'attr' => ['class' => 'form-select', 'size' => 6] 
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
