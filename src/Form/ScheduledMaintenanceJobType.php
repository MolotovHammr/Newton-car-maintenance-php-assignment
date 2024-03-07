<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\MaintenanceJob;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\ScheduledMaintenanceJob;
use App\Repository\MaintenanceJobRepository;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


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
            ->add('timeSlot', ChoiceType::class, [
                'label' => 'Time Slot',
                'choices' => ['Weekdays' => 'Weekdays', 'Weekends' => 'Weekends'],
                'placeholder' => 'Choose a time slot!',
            ])
            ->add('maintenanceJob', EntityType::class, [
                'class' => MaintenanceJob::class,
                'choices' => [],
                'choice_label' => 'name',
                'placeholder' => 'Choose a car first!',
            ])
            ->add('totalPrice', MoneyType::class, [
                'label' => 'Total Price',
                'scale' => 2,
                'disabled' => true,
                'required' => false,
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
                'choice_label' => 'name',
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

        $formModifierTimeSlotSelect = function (FormInterface $form, mixed $timeSlot = null) {
            if (null === $timeSlot) {
                return;
            }
            if (null !== $timeSlot->getCar())  {
                dd($timeSlot);
            }
            $form->add('timeSlot', ChoiceType::class, [
                'label' => 'Time Slot',
                'choices' => ['Weekdays' => 'Weekdays', 'Weekends' => 'Weekends'],
                'placeholder' => 'Choose a time slot!',
            ]);

            //$this->calculateTotalPrice($maintenanceJob, $timeSlot);
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

        //Event listeners timeSlot

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifierTimeSlotSelect) {
            $data = $event->getData();

            $formModifierTimeSlotSelect($event->getForm(), $data->getTimeSlot());
        });

        $builder->get('timeSlot')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifierTimeSlotSelect) {
                $timeSlot = $event->getForm()->getData();

                $formModifierTimeSlotSelect($event->getForm()->getParent(), $timeSlot);
            }
        );

        $builder->setAction($options['action']);
    }

    public function calculateTotalPrice(MaintenanceJob $maintenanceJob, string $timeSlot): float
    {
        dd($maintenanceJob, $timeSlot);
        $totalPrice += $availableMaintenanceJob->getWeekdayRate();

        return $totalPrice;
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
