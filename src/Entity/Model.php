<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $year = null;

    #[ORM\ManyToOne(inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\ManyToMany(targetEntity: SparePart::class, mappedBy: 'models')]
    private Collection $spareParts;

    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'model')]
    private Collection $cars;

    #[ORM\OneToMany(targetEntity: MaintenanceJob::class, mappedBy: 'model')]
    private Collection $maintenanceJobs;

    public function __construct()
    {
        $this->spareParts = new ArrayCollection();
        $this->cars = new ArrayCollection();
        $this->maintenanceJobs = new ArrayCollection();
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

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

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
            $sparePart->addModel($this);
        }

        return $this;
    }

    public function removeSparePart(SparePart $sparePart): static
    {
        if ($this->spareParts->removeElement($sparePart)) {
            $sparePart->removeModel($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setModel($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getModel() === $this) {
                $car->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MaintenanceJob>
     */
    public function getMaintenanceJobs(): Collection
    {
        return $this->maintenanceJobs;
    }

    public function addMaintenanceJob(MaintenanceJob $maintenanceJob): static
    {
        if (!$this->maintenanceJobs->contains($maintenanceJob)) {
            $this->maintenanceJobs->add($maintenanceJob);
            $maintenanceJob->setModel($this);
        }

        return $this;
    }

    public function removeMaintenanceJob(MaintenanceJob $maintenanceJob): static
    {
        if ($this->maintenanceJobs->removeElement($maintenanceJob)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceJob->getModel() === $this) {
                $maintenanceJob->setModel(null);
            }
        }

        return $this;
    }
}
