<?php

namespace App\Entity;

use App\Repository\ScheduledMaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank]
    private ?MaintenanceJob $maintenanceJob = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledMaintenanceJobs')]
    #[Assert\NotBlank]
    private ?Car $car = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $timeSlot = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?float $totalPrice = null;

    #[ORM\Column]
    private ?float $basePrice = null;

    #[ORM\Column]
    private ?float $vatPrice = null;

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

    public function getTimeSlot(): ?string
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(string $timeSlot): static
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    public function setBasePrice(float $basePrice): static
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getVatPrice(): ?float
    {
        return $this->vatPrice;
    }

    public function setVatPrice(float $vatPrice): static
    {
        $this->vatPrice = $vatPrice;

        return $this;
    }
}
