<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\MaintenanceJob;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\ScheduledMaintenanceJob;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;


class ScheduledMaintenanceJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => function (Car $car) {
                    return $car->getCustomer()->getName() . '\'s ' . $car->getCarFullName();
                },
            ]);

        $formModifierMaintenanceJobs = function (FormInterface $form, Car $car = null) {
                $availableMaintenanceJobs = $car === null ? [] : $this->getAvailableMaintenanceJobs($car);

                $form->add('maintenanceJob', EntityType::class, [
                    'class' => MaintenanceJob::class,
                    'choices' => $availableMaintenanceJobs,
                    'choice_label' => 'name',
                    'placeholder' => 'Choose a maintenance job',
                ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifierMaintenanceJobs) {
            $data = $event->getData();

            $formModifierMaintenanceJobs($event->getForm(), $data->getCar());
        });

        $builder->get('car')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifierMaintenanceJobs) {

                $car = $event->getForm()->getData();

                $formModifierMaintenanceJobs($event->getForm()->getParent(), $car);
            }
        );
    }

    public function getAvailableMaintenanceJobs(Car $car): Collection
    {
        $availableMaintenanceJobs = new ArrayCollection();


        $brandJobs = $car->getModel()->getBrand()->getMaintenanceJobs();

        foreach ($brandJobs as $brandJob) {
            $availableMaintenanceJobs->add($brandJob);
        }
        
        $modelJobs = $car->getModel()->getMaintenanceJobs();

        foreach ($modelJobs as $modelJob) {
            $availableMaintenanceJobs->add($modelJob);
        }

        return $availableMaintenanceJobs;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduledMaintenanceJob::class,
        ]);
    }
}
