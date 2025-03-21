<?php

namespace App\Entity;

use App\Repository\ConsultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN')"),
        new Get(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN')"),
        new Post(security: "is_granted('ROLE_ASSISTANT')"),
        new Put(security: "is_granted('ROLE_ASSISTANT') and object.getStatut() != 'terminé'"),
        new Delete(security: "is_granted('ROLE_DIRECTOR')")
    ]
)]
#[ORM\Entity(repositoryClass: ConsultRepository::class)]
class Consult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $consultDate = null;

    #[ORM\Column(length: 255)]
    private ?string $reason = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $assistant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $veterinary = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @var Collection<int, Treatment>
     */
    #[ORM\ManyToMany(targetEntity: Treatment::class)]
    private Collection $treatment;

    public function __construct()
    {
        $this->treatment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getConsultDate(): ?\DateTimeInterface
    {
        return $this->consultDate;
    }

    public function setConsultDate(\DateTimeInterface $consultDate): static
    {
        $this->consultDate = $consultDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getVeterinary(): ?User
    {
        return $this->veterinary;
    }

    public function setVeterinary(?User $veterinary): static
    {
        $this->veterinary = $veterinary;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Treatment>
     */
    public function getTreatment(): Collection
    {
        return $this->treatment;
    }

    public function addTreatment(Treatment $treatment): static
    {
        if (!$this->treatment->contains($treatment)) {
            $this->treatment->add($treatment);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): static
    {
        $this->treatment->removeElement($treatment);

        return $this;
    }
}
