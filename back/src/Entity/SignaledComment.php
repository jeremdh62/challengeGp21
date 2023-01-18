<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SignaledCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignaledCommentRepository::class)]
#[ApiResource]
class SignaledComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'signaledComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $signaledBy = null;

    #[ORM\ManyToOne(inversedBy: 'mySignaledComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $signaledUser = null;

    #[ORM\ManyToOne(inversedBy: 'signaledComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Comment $comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignaledBy(): ?User
    {
        return $this->signaledBy;
    }

    public function setSignaledBy(?User $signaledBy): self
    {
        $this->signaledBy = $signaledBy;

        return $this;
    }

    public function getSignaledUser(): ?User
    {
        return $this->signaledUser;
    }

    public function setSignaledUser(?User $signaledUser): self
    {
        $this->signaledUser = $signaledUser;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
