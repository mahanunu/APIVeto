<?php

namespace App\Entity;

use App\Repository\ConsultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
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
        new Put(security: "is_granted('ROLE_ASSISTANT')", securityMessage: "Seuls les assistants peuvent mettre à jour le paiement."),
        new Delete(security: "is_granted('ROLE_DIRECTOR')")
    ]
)]
#[ORM\Entity(repositoryClass: ConsultRepository::class)]
class Consult
{
    public const STATUS_SCHEDULED = 'programmé';
    public const STATUS_IN_PROGRESS = 'en cours';
    public const STATUS_COMPLETED = 'terminé';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate;

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

    #[ORM\Column(length: 20)]
    private ?string $status = self::STATUS_SCHEDULED;

    #[ApiProperty]
    #[ORM\ManyToMany(targetEntity: Treatment::class, inversedBy: "consults")]
    private Collection $treatment;

    #[ORM\Column(type: Types::STRING, length: 10, options: ["default" => "unpaid"])]
    private ?string $paymentStatus = "unpaid";

    public function __construct()
    {
        $this->creationDate = new \DateTime();
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
        if (!in_array($status, [self::STATUS_SCHEDULED, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED])) {
            throw new \InvalidArgumentException("Statut invalide.");
        }

        $this->status = $status;
        return $this;
    }

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

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(string $status): static
    {
        $this->paymentStatus = $status;
        return $this;
    }
}
