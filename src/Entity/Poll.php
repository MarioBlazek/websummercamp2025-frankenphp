<?php

namespace App\Entity;

use App\Repository\PollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PollRepository::class)]
class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, PollOption>
     */
    #[ORM\OneToMany(targetEntity: PollOption::class, mappedBy: 'poll', cascade: ['persist'], orphanRemoval: true)]
    private Collection $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, PollOption>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(PollOption $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setPoll($this);
        }

        return $this;
    }

    public function removeOption(PollOption $option): static
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getPoll() === $this) {
                $option->setPoll(null);
            }
        }

        return $this;
    }
}
