<?php

namespace App\Form;

use App\Entity\Presence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    // champs visibles dans tous les cas
    $builder
        ->add('employee') // ou autre
        // ... les autres champs communs
    ;

    if ($options['is_edit']) {
        $builder->add('heureDepart', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
            'widget' => 'single_text',
            'required' => false,
        ]);
    }
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Presence::class,
        'is_edit' => false, // valeur par défaut
    ]);
}

}