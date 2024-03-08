<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\MaintenanceJob;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\ScheduledMaintenanceJob;
use App\Repository\MaintenanceJobRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ScheduledMaintenanceJobType extends AbstractType
{
    private $maintenanceJobRepository;

    public function __construct(MaintenanceJobRepository $maintenanceJobRepository)
    {
        $this->maintenanceJobRepository = $maintenanceJobRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => function (Car $car) {
                    return $car->getCustomer()->getName() . '\'s ' . $car->getCarFullName();
                },
                'placeholder' => 'Select a customers\' car',
            ])
            ->add('maintenanceJob', EntityType::class, [
                'class' => MaintenanceJob::class,
                'choices' => [],
                'choice_label' => 'name',
                'placeholder' => 'Choose a car first!',
            ])
            ->add('timeSlot', ChoiceType::class, [
                'label' => 'Time Slot',
                'choices' => ['Weekdays' => 'Weekdays', 'Weekends' => 'Weekends'],
                'placeholder' => 'Choose a time slot!',
            ])
            ->add('basePrice', NumberType::class, [
                'label' => 'base Price (without VAT)',
                'scale' => 2,
                'attr' => [
                    'readonly' => true,
                ],
                'required' => true,

            ])
            ->add('vatPrice', NumberType::class, [
                'label' => 'VAT Price (21%)',
                'scale' => 2,
                'attr' => [
                    'readonly' => true,
                ],
                'required' => true,

            ])
            ->add('totalPrice', NumberType::class, [
                'label' => 'Total Price (with VAT)',
                'scale' => 2,
                'attr' => [
                    'readonly' => true,
                ],
                'required' => true,

            ])

            ->add('scheduleCalculate', SubmitType::class, array(
                'label' => 'Schedule Job!',
            ));

        $formModifierCarSelect = function (FormInterface $form, Car $car = null) {
            $availableMaintenanceJobs = $car === null ? [] : $this->getAvailableMaintenanceJobs($car);

            //dd($availableMaintenanceJobs);

            if (empty($availableMaintenanceJobs)) {
                $form->add('maintenanceJob', EntityType::class, [
                    'class' => MaintenanceJob::class,
                    'choices' => [],
                    'choice_label' => 'name',
                    'placeholder' => 'Choose a car first!',
                ]);
                return;
            }

        
            $form->add('maintenanceJob', EntityType::class, [
                'class' => MaintenanceJob::class,
                'choices' => $availableMaintenanceJobs,
                'choice_label' => function (MaintenanceJob $availableMaintenanceJob) {

                    if ($availableMaintenanceJob->getBrand()) {
                        return $availableMaintenanceJob->getName() . ' (Brand)';
                    }
                    if ($availableMaintenanceJob->getModel()) {
                        return $availableMaintenanceJob->getName() . ' (Model)';
                    }
                    if ($availableMaintenanceJob->isGeneric()) {
                        return $availableMaintenanceJob->getName() . ' (Generic)';
                    }
                },
                'placeholder' => 'Choose a maintenance job',
            ]);
        };

        $formModifierMaintenanceJobSelect = function (FormInterface $form, MaintenanceJob $maintenanceJob = null) {
            if (null === $maintenanceJob) {
                return;
            }
            $form->add('maintenanceJob', EntityType::class, [
                'class' => MaintenanceJob::class,
                'selected' => $maintenanceJob,
                'choice_label' => 'name',
                'placeholder' => 'Choose a maintenance job',
            ]);

            return;
        };

        //Event listeners Car 
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifierCarSelect) {
            $data = $event->getData();

            $formModifierCarSelect($event->getForm(), $data->getCar());
        });


        $builder->get('car')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifierCarSelect) {

                $car = $event->getForm()->getData();

                $formModifierCarSelect($event->getForm()->getParent(), $car);
            }
        );

        //Eevent listeners Maintenance Job
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifierMaintenanceJobSelect) {
            $data = $event->getData();

            $formModifierMaintenanceJobSelect($event->getForm(), $data->getMaintenanceJob());
        });

        $builder->get('maintenanceJob')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifierMaintenanceJobSelect) {
                $maintenanceJob = $event->getForm()->getData();

                $formModifierMaintenanceJobSelect($event->getForm()->getParent(), $maintenanceJob);
            }
        );

        $builder->setAction($options['action']);
    }

    public function getAvailableMaintenanceJobs(Car $car): Collection
    {
        $availableMaintenanceJobs = $this->collectMaintenanceJobs($car, $this->maintenanceJobRepository);

        return $availableMaintenanceJobs;
    }

    public function collectMaintenanceJobs(Car $car, MaintenanceJobRepository $maintenanceJobRepository): Collection
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

        $genericJobs = $maintenanceJobRepository->findGenericMaintenanceJobs();

        //dd($brandJobs->toArray(), $modelJobs->toArray(), $genericJobs);

        foreach ($genericJobs as $genericJob) {
            $availableMaintenanceJobs->add($genericJob);
        }

        //dd($availableMaintenanceJobs);

        return $availableMaintenanceJobs;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduledMaintenanceJob::class,
        ]);
    }
}
