<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Study::class, mappedBy="provider")
     */
    private $study;

    public function __construct()
    {
        $this->study = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Study[]
     */
    public function getStudy(): Collection
    {
        return $this->study;
    }

    public function addStudy(Study $study): self
    {
        if (!$this->study->contains($study)) {
            $this->study[] = $study;
            $study->setProvider($this);
        }

        return $this;
    }

    public function removeStudy(Study $study): self
    {
        if ($this->study->removeElement($study)) {
            // set the owning side to null (unless already changed)
            if ($study->getProvider() === $this) {
                $study->setProvider(null);
            }
        }

        return $this;
    }
}
