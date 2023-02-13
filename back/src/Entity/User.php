<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\EmailVerifierController;
use App\Controller\RegisterController;
use App\Controller\ResetPasswordController;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asserts;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['get_user']],
    security: "is_granted('ROLE_MODERATOR') or object == user"
)]
#[GetCollection(
    normalizationContext: ['groups' => ['getc_user']],
    security: "is_granted('ROLE_MODERATOR')",
)]
#[Post(
    name: 'user_register',
    uriTemplate: 'register',
    controller: RegisterController::class,
    denormalizationContext: ['groups' => ['user_write']],
    processor: UserPasswordHasher::class
)]
#[Put(
    denormalizationContext: ['groups' => ['user_update']],
    security: "is_granted('ROLE_ADMIN') or object == user",
    processor: UserPasswordHasher::class
)]
#[Patch(
    denormalizationContext: ['groups' => ['user_update']],
    security: "is_granted('ROLE_ADMIN') or object == user",
    )]
#[Patch(
    name: 'reset_password',
    uriTemplate: 'users/{id}/reset/password',
    controller: ResetPasswordController::class,
    denormalizationContext: ['groups' => ['userp_update']],
    processor: UserPasswordHasher::class,
    security: "is_granted('ROLE_ADMIN') or object == user",
)]

#[UniqueEntity('username', message: 'Ce nom d\'utilisateur {{ value }} existe déjà.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;
    
    #[ORM\Column(length: 180, unique: true)]
    #[Asserts\NotBlank()]
    #[Groups(['get_user', 'user_write', 'getc_user'])]
    private ?string $username = null;
    
    #[ORM\Column]
    private array $roles = [];
    
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['getc_user', 'user_write', 'user_update', 'userp_update'])]
    private ?string $password = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['getc_user'])]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user', 'user_write', 'user_update'])]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'uploadedBy', targetEntity: Clip::class)]
    private Collection $clips;

    #[ORM\ManyToMany(targetEntity: Tournament::class, mappedBy: 'participants')]
    private Collection $tournaments;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Tournament::class)]
    private Collection $createdTournaments;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Media::class)]
    private Collection $medias;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Forum::class)]
    private Collection $forums;

    #[ORM\OneToMany(mappedBy: 'signaledBy', targetEntity: SignaledComment::class)]
    private Collection $signaledComments;

    #[ORM\OneToMany(mappedBy: 'signaledUser', targetEntity: SignaledComment::class)]
    private Collection $mySignaledComments;

    #[ORM\Column(nullable: true)]
    private ?bool $isVerify = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->clips = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
        $this->createdTournaments = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->forums = new ArrayCollection();
        $this->signaledComments = new ArrayCollection();
        $this->mySignaledComments = new ArrayCollection();
        $this->isVerify = false;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setCreatedBy($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCreatedBy() === $this) {
                $comment->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Clip>
     */
    public function getClips(): Collection
    {
        return $this->clips;
    }

    public function addClip(Clip $clip): self
    {
        if (!$this->clips->contains($clip)) {
            $this->clips->add($clip);
            $clip->setUploadedBy($this);
        }

        return $this;
    }

    public function removeClip(Clip $clip): self
    {
        if ($this->clips->removeElement($clip)) {
            // set the owning side to null (unless already changed)
            if ($clip->getUploadedBy() === $this) {
                $clip->setUploadedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments->add($tournament);
            $tournament->addParticipant($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getCreatedTournaments(): Collection
    {
        return $this->createdTournaments;
    }

    public function addCreatedTournament(Tournament $createdTournament): self
    {
        if (!$this->createdTournaments->contains($createdTournament)) {
            $this->createdTournaments->add($createdTournament);
            $createdTournament->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedTournament(Tournament $createdTournament): self
    {
        if ($this->createdTournaments->removeElement($createdTournament)) {
            // set the owning side to null (unless already changed)
            if ($createdTournament->getCreatedBy() === $this) {
                $createdTournament->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCreatedBy($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCreatedBy() === $this) {
                $article->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setOwner($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getOwner() === $this) {
                $media->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Forum>
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums->add($forum);
            $forum->setCreatedBy($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getCreatedBy() === $this) {
                $forum->setCreatedBy(null);
            }
        }

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
            $signaledComment->setSignaledBy($this);
        }

        return $this;
    }

    public function removeSignaledComment(SignaledComment $signaledComment): self
    {
        if ($this->signaledComments->removeElement($signaledComment)) {
            // set the owning side to null (unless already changed)
            if ($signaledComment->getSignaledBy() === $this) {
                $signaledComment->setSignaledBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SignaledComment>
     */
    public function getMySignaledComments(): Collection
    {
        return $this->mySignaledComments;
    }

    public function addMySignaledComment(SignaledComment $mySignaledComment): self
    {
        if (!$this->mySignaledComments->contains($mySignaledComment)) {
            $this->mySignaledComments->add($mySignaledComment);
            $mySignaledComment->setSignaledUser($this);
        }

        return $this;
    }

    public function removeMySignaledComment(SignaledComment $mySignaledComment): self
    {
        if ($this->mySignaledComments->removeElement($mySignaledComment)) {
            // set the owning side to null (unless already changed)
            if ($mySignaledComment->getSignaledUser() === $this) {
                $mySignaledComment->setSignaledUser(null);
            }
        }

        return $this;
    }

    public function isIsVerify(): ?bool
    {
        return $this->isVerify;
    }

    public function setIsVerify(?bool $isVerify): self
    {
        $this->isVerify = $isVerify;

        return $this;
    }
}
