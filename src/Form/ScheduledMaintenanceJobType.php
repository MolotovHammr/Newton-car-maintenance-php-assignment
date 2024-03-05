<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\MaintenanceJob;
use App\Entity\ScheduledMaintenanceJob;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduledMaintenanceJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maintenanceJob', EntityType::class, [
                'class' => MaintenanceJob::class,
'choice_label' => 'id',
            ])
            ->add('cars', EntityType::class, [
                'class' => Car::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduledMaintenanceJob::class,
        ]);
    }
}
