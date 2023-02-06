<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClipRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ClipRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read_CLip']],
    denormalizationContext: ['groups' => ['write_Clip']]
)]
class Clip
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_Clip', 'write_Clip'])]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'clips')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_Clip'])]
    #[Blameable(on: 'create')]
    private ?User $uploadedBy = null;

    #[ORM\Column]
    #[Groups(['read_Clip'])]
    private ?bool $isValid = false;

    #[ORM\Column(length: 255)]
    #[Groups(['read_Clip', 'write_Clip'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['read_Clip'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now", new \DateTimeZone("Europe/Paris"));
        $this->isValid = false;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getUploadedBy(): ?User
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?User $uploadedBy): self
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
