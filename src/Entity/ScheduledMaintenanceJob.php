<?php

namespace App\Entity;

use App\Repository\ScheduledMaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduledMaintenanceJobRepository::class)]
class ScheduledMaintenanceJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledMaintenanceJobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MaintenanceJob $maintenanceJob = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledMaintenanceJobs')]
    private ?Car $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaintenanceJob(): ?MaintenanceJob
    {
        return $this->maintenanceJob;
    }

    public function setMaintenanceJob(?MaintenanceJob $maintenanceJob): static
    {
        $this->maintenanceJob = $maintenanceJob;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }
}
