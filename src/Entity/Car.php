<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $Customer = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;


    #[ORM\OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'car')]
    private Collection $scheduledMaintenanceJobs;

    public function __construct()
    {
        $this->scheduledMaintenanceJobs = new ArrayCollection();
    }

    public function getCarFullName(): string
    {
        return $this->model->getBrand()->getName() . ' ' . $this->model->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, ScheduledMaintenanceJob>
     */
    public function getScheduledMaintenanceJobs(): Collection
    {
        return $this->scheduledMaintenanceJobs;
    }

    public function addScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): static
    {
        if (!$this->scheduledMaintenanceJobs->contains($scheduledMaintenanceJob)) {
            $this->scheduledMaintenanceJobs->add($scheduledMaintenanceJob);
            $scheduledMaintenanceJob->setCar($this);
        }

        return $this;
    }

    public function removeScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): static
    {
        if ($this->scheduledMaintenanceJobs->removeElement($scheduledMaintenanceJob)) {
            // set the owning side to null (unless already changed)
            if ($scheduledMaintenanceJob->getCar() === $this) {
                $scheduledMaintenanceJob->setCar(null);
            }
        }

        return $this;
    }
}
