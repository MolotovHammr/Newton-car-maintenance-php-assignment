<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: 'brand', orphanRemoval: true)]
    private Collection $models;

    #[ORM\ManyToMany(targetEntity: SparePart::class, mappedBy: 'brands')]
    private Collection $spareParts;

    #[ORM\OneToMany(targetEntity: MaintenanceJob::class, mappedBy: 'brand')]
    private Collection $maintenanceJobs;

    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->spareParts = new ArrayCollection();
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): static
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): static
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

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
            $sparePart->addBrand($this);
        }

        return $this;
    }

    public function removeSparePart(SparePart $sparePart): static
    {
        if ($this->spareParts->removeElement($sparePart)) {
            $sparePart->removeBrand($this);
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
            $maintenanceJob->setBrand($this);
        }

        return $this;
    }

    public function removeMaintenanceJob(MaintenanceJob $maintenanceJob): static
    {
        if ($this->maintenanceJobs->removeElement($maintenanceJob)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceJob->getBrand() === $this) {
                $maintenanceJob->setBrand(null);
            }
        }

        return $this;
    }
}
