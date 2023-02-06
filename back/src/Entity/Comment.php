<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read_Comment']],
    denormalizationContext: ['groups' => ['write_Comment']]
)]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column]
    #[Groups(['read_Comment'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_Comment'])]
    #[Blameable(on: 'create')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_Comment', 'write_Comment'])]
    private ?Forum $forum = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_Comment', 'write_Comment'])]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: SignaledComment::class)]
    #[Groups(['read_Comment'])]
    private Collection $signaledComments;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now", new \DateTimeZone("Europe/Paris"));
        $this->signaledComments = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, SignaledComment>
     */
    public function getSignaledComments(): Collection
    {
        return $this->signaledComments;
    }

    public function addSignaledComment(SignaledComment $signaledComment): self
    {
        if (!$this->signaledComments->contains($signaledComment)) {
            $this->signaledComments->add($signaledComment);
            $signaledComment->setComment($this);
        }

        return $this;
    }

    public function removeSignaledComment(SignaledComment $signaledComment): self
    {
        if ($this->signaledComments->removeElement($signaledComment)) {
            // set the owning side to null (unless already changed)
            if ($signaledComment->getComment() === $this) {
                $signaledComment->setComment(null);
            }
        }

        return $this;
    }
}
