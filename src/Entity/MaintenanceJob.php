<?php

namespace App\Entity;

use App\Repository\MaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceJobRepository::class)]
class MaintenanceJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: SparePart::class, inversedBy: 'maintenanceJobs')]
    private Collection $spareParts;

    #[ORM\Column]
    private ?float $hours = null;

    #[ORM\Column]
    private ?float $weekdayRate = null;

    #[ORM\Column]
    private ?float $weekendRate = null;

    #[ORM\OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'maintenanceJob')]
    private Collection $scheduledMaintenanceJobs;

    public function __construct()
    {
        $this->spareParts = new ArrayCollection();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SparePart>
     */
    public function getSpareParts(): Collection
    {
        return $this->spareParts;
    }

    public function addSparePart(SparePart $sparePart): static
    {
        if (!$this->spareParts->contains($sparePart)) {
            $this->spareParts->add($sparePart);
        }

        return $this;
    }

    public function removeSparePart(SparePart $sparePart): static
    {
        $this->spareParts->removeElement($sparePart);

        return $this;
    }

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(float $hours): static
    {
        $this->hours = $hours;

        return $this;
    }

    public function getWeekdayRate(): ?float
    {
        return $this->weekdayRate;
    }

    public function setWeekdayRate(float $weekdayRate): static
    {
        $this->weekdayRate = $weekdayRate;

        return $this;
    }

    public function getWeekendRate(): ?float
    {
        return $this->weekendRate;
    }

    public function setWeekendRate(float $weekendRate): static
    {
        $this->weekendRate = $weekendRate;

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
            $scheduledMaintenanceJob->setMaintenanceJob($this);
        }

        return $this;
    }

    public function removeScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): static
    {
        if ($this->scheduledMaintenanceJobs->removeElement($scheduledMaintenanceJob)) {
            // set the owning side to null (unless already changed)
            if ($scheduledMaintenanceJob->getMaintenanceJob() === $this) {
                $scheduledMaintenanceJob->setMaintenanceJob(null);
            }
        }

        return $this;
    }
}
